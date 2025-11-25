<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly PaymentService $paymentService
    ) {
    }

    /* ---------------------------------------------------------
     * Paso 1 - Resumen del carrito
     * --------------------------------------------------------- */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $this->cartService->mergeSessionToUser($user);
        }

        $items = $this->cartService->getItems($user);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Tu carrito esta vacio.');
        }

        $totals = $this->cartService->totals($items);

        return view('checkout.index', compact('items', 'totals'));
    }

    /* ---------------------------------------------------------
     * Paso 2 - Datos de envio
     * --------------------------------------------------------- */
    public function shipping(Request $request)
    {
        $user = $request->user();
        $items = $this->cartService->getItems($user);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Tu carrito esta vacio.');
        }

        $shipping = session('checkout.shipping', []);
        $totals = $this->cartService->totals($items);

        return view('checkout.shipping', compact('items', 'totals', 'shipping'));
    }

    public function storeShipping(Request $request)
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:120'],
            'direccion' => ['required', 'string', 'max:180'],
            'ciudad'    => ['required', 'string', 'max:100'],
            'pais'      => ['required', 'string', 'max:80'],
            'telefono'  => ['required', 'string', 'max:30'],
        ]);

        session()->put('checkout.shipping', $data);

        return redirect()->route('checkout.payment');
    }

    /* ---------------------------------------------------------
     * Paso 3 - Metodo de Pago
     * --------------------------------------------------------- */
    public function payment(Request $request)
    {
        $user = $request->user();
        $items = $this->cartService->getItems($user);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Tu carrito esta vacio.');
        }

        if (!session()->has('checkout.shipping')) {
            return redirect()->route('checkout.shipping');
        }

        $totals  = $this->cartService->totals($items);
        $payment = session('checkout.payment', [
            'metodo' => 'card',
            'notas'  => null,
        ]);

        return view('checkout.payment', compact('items', 'totals', 'payment'));
    }

    public function storePayment(Request $request)
    {
        $data = $request->validate([
            'metodo' => ['required', 'in:card,cash'],
            'notas'  => ['nullable', 'string', 'max:255'],
        ]);

        session()->put('checkout.payment', $data);

        return redirect()->route('checkout.confirm');
    }

    /* ---------------------------------------------------------
     * Pagos QR (AJAX)
     * --------------------------------------------------------- */
    public function generateQrPayment(Request $request)
    {
        $request->validate([
            'method' => ['nullable', 'in:yape,plin'],
        ]);

        $user = $request->user();
        $items = $this->cartService->getItems($user);

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'El carrito esta vacio'], 422);
        }

        if (!session()->has('checkout.shipping')) {
            return response()->json(['success' => false, 'message' => 'Faltan datos de envio'], 422);
        }

        $order = $this->paymentService->ensurePendingOrder($user, $items, 'cash');
        $payment = $this->paymentService->generateQrPayment($order, $request->input('method', 'yape'));

        session()->put('checkout.payment', ['metodo' => 'cash', 'notas' => null]);

        $qrPayload = json_encode([
            'code' => $payment->payment_code,
            'amount' => $payment->amount,
            'order' => $order->order_number,
            'method' => $payment->payment_method,
        ]);

        return response()->json([
            'success' => true,
            'payment_id' => $payment->id,
            'payment_code' => $payment->payment_code,
            'amount' => $payment->amount,
            'expires_at' => $payment->expires_at->toIso8601String(),
            'qr_data' => $qrPayload,
            'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrPayload),
        ]);
    }

    public function checkQrStatus(Payment $payment)
    {
        $order = $payment->order()->with('user')->first();

        if (!$order || $order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'status' => 'unauthorized'], 403);
        }

        $payment = $this->paymentService->checkPaymentStatus($payment);

        return response()->json([
            'success' => true,
            'status' => $payment->status,
            'payment_id' => $payment->id,
        ]);
    }

    public function confirmQrCode(Request $request)
    {
        $data = $request->validate([
            'payment_id' => ['required', 'exists:payments,id'],
            'code' => ['required', 'string'],
        ]);

        $payment = Payment::with('order.user')->findOrFail($data['payment_id']);

        if ($payment->order?->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $confirmed = $this->paymentService->confirmQrCode($payment->order, $data['code']);

        if (!$confirmed) {
            return response()->json(['success' => false, 'message' => 'Codigo invalido o expirado'], 422);
        }

        return response()->json([
            'success' => true,
            'status' => $confirmed->status,
        ]);
    }

    /* ---------------------------------------------------------
     * Paso 4 - Confirmacion
     * --------------------------------------------------------- */
    public function confirm(Request $request)
    {
        $user  = $request->user();
        $items = $this->cartService->getItems($user);

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Tu carrito esta vacio.');
        }

        $shipping = session('checkout.shipping');
        $payment  = session('checkout.payment');

        if (!$shipping) return redirect()->route('checkout.shipping');
        if (!$payment)  return redirect()->route('checkout.payment');

        $totals = $this->cartService->totals($items);

        return view('checkout.confirm', compact('items', 'totals', 'shipping', 'payment'));
    }

    /* ---------------------------------------------------------
     * Paso 5 - Finalizacion
     * --------------------------------------------------------- */
    public function complete(Request $request)
    {
        $user  = $request->user();
        $items = $this->cartService->getItems($user);

        $shipping = session('checkout.shipping');
        $payment  = session('checkout.payment');
        $orderId  = session('checkout.order_id');

        if (!$shipping || !$payment) {
            return redirect()->route('checkout.show');
        }

        // Si el carrito esta vacio pero ya existe una orden pendiente/completada, usarla para mostrar resumen.
        if ($items->isEmpty() && $orderId) {
            $order = Order::with('items.product')->where('user_id', $user->id)->find($orderId);
            if ($order) {
                $items = $order->items->map(function ($item) {
                    return (object) [
                        'product' => $item->product ?? (object) ['name' => $item->product_name],
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal,
                    ];
                });
            }
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Tu carrito esta vacio.');
        }

        $totals = $this->cartService->totals($items);

        // Limpiar sesion del checkout
        session()->forget(['checkout.shipping', 'checkout.payment', 'checkout.order_id']);

        return view('checkout.complete', compact('items', 'totals', 'shipping', 'payment'));
    }
}
