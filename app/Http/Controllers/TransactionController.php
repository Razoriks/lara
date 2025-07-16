<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $transactions = $request->user()->transactions()
            ->when($request->filled('description'), function ($query) use ($request) {
                $query->where('description', 'like', '%'.$request->input('description').'%');
            })
            ->orderBy($request->input('sort', 'created_at'), $request->input('order', 'desc'))
            ->get();

        return response()->json($transactions);
    }
}
