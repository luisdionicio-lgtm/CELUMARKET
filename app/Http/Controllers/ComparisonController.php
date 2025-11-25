<?php

namespace App\Http\Controllers;

use App\Models\Comparison;

class ComparisonController extends Controller
{
    public function index()
    {
        $comparaciones = Comparison::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('comparisons.index', compact('comparaciones'));
    }
}