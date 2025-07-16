<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
            'balance' => $request->user()->balance?->balance ?? 0,
            'transactions' => $request->user()->transactions()->latest()->limit(5)->get(),
        ]);
    }
}
