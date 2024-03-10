<?php

namespace App\Http\Controllers;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'total_income' => $user->incomes->sum('amount'),
            'total_expense' => $user->expenses->sum('amount'),
            'transactions' => $user->transactions->all()
        ]);
    }

    public function incomes()
    {
        $user = auth()->user();

        return $user->incomes->all();
    }

    public function expenses()
    {
        $user = auth()->user();

        return $user->expenses->all();
    }
}
