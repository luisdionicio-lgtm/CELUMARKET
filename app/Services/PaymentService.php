<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    /**
     * Crea o reutiliza una orden pendiente en base al carrito actual.
     */
    public function ensurePendingOrder(User $user, Collection $items, string $paymentMethod = 'cash'): Order
    {
        $orderId = session('checkout.order_id');

        if ($orderId) {
            $existing = Order::with('items')->where('user_id', $user->id)->find($orderId);
            if ($existing && $existing->status === 'pending') {
                return $existing;
            }
        }

        $total = $items->sum('subtotal');
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $this->generateOrderNumber(),
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $paymentMethod,
            'simulated' => $user->isAdmin(),
        ]);

        foreach ($items as $line) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $line->product->id ?? null,
                'product_name' => $line->product->nombre ?? ($line->product->name ?? 'Producto'),
                'price' => $line->price,
                'quantity' => $line->quantity,
                'subtotal' => $line->subtotal,
            ]);
        }

        session(['checkout.order_id' => $order->id]);

        return $order->fresh('items');
    }

    /**
     * Genera un pago QR pendiente.
     */
    public function generateQrPayment(Order $order, string $method = 'yape'): Payment
    {
        $code = strtoupper(substr($method, 0, 2)) . '-' . Str::upper(Str::random(8));

        return Payment::create([
            'order_id' => $order->id,
            'payment_method' => $method,
            'amount' => $order->total,
            'status' => 'pending',
            'payment_code' => $code,
            'expires_at' => now()->addMinutes(15),
        ]);
    }

    /**
     * Confirma un pago pendiente con el codigo mostrado al usuario.
     */
    public function confirmQrCode(Order $order, string $code): ?Payment
    {
        $payment = $order->payments()
            ->where('status', 'pending')
            ->where('payment_code', $code)
            ->latest()
            ->first();

        if (!$payment) {
            return null;
        }

        return $this->markCompleted($payment);
    }

    /**
     * Revisa y actualiza el estado (expira si corresponde).
     */
    public function checkPaymentStatus(Payment $payment): Payment
    {
        if ($payment->status === 'pending' && $payment->expires_at && $payment->expires_at->isPast()) {
            $payment->update(['status' => 'expired']);
        }

        return $payment->refresh();
    }

    /**
     * Marca un pago como completado y procesa la orden.
     */
    public function markCompleted(Payment $payment): Payment
    {
        if (!$payment->isPending()) {
            return $payment;
        }

        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        $order = $payment->order()->with('items', 'user')->first();

        if ($order) {
            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid',
                'payment_method' => $payment->payment_method,
            ]);

            if ($order->items()->count() > 0 && $order->user) {
                $this->cartService->clear($order->user);
            }
        }

        return $payment->refresh();
    }

    /**
     * Procesa pago (simulado o real) creando la orden y limpiando carrito.
     * Se mantiene para compatibilidad con el flujo existente.
     */
    public function process(User $user, Collection $items, array $payload): Order
    {
        $order = $this->ensurePendingOrder($user, $items, $payload['method'] ?? 'card');

        $this->markOrderAsPaid($order, $payload['method'] ?? 'card');
        $this->cartService->clear($user);

        Mail::raw($this->buildReceiptMessage($order, $items), function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Confirmacion de pago - CELU MARKET');
        });

        return $order;
    }

    protected function markOrderAsPaid(Order $order, string $method): void
    {
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
            'payment_method' => $method,
        ]);
    }

    protected function buildReceiptMessage(Order $order, Collection $items): string
    {
        $lines = $items->map(function ($line) {
            $productName = $line->product->nombre ?? ($line->product->name ?? 'Producto');
            return "- {$line->quantity} x {$productName}: S/ " . number_format($line->subtotal, 2);
        })->implode("\n");

        $simulated = $order->simulated ? "\n\nAdvertencia: este pago fue simulado por un administrador." : '';

        return "Gracias por tu compra en CELU MARKET.\n\nResumen:\n{$lines}\n\nTotal pagado: S/ "
            . number_format($order->total, 2)
            . "\nMetodo: {$order->payment_method}{$simulated}\n\nTu pedido esta en estado: {$order->status}.";
    }

    protected function generateOrderNumber(): string
    {
        return 'ORD-' . Str::upper(Str::random(10));
    }
}
