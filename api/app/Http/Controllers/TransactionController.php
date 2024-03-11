<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StoreIncomeRequest;
use App\Models\Check;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'total_income' => $user->currentAmountIncomes(),
            'total_expense' => $user->currentAmountExpenses(),
            'transactions' => $user->validTransactions(),
        ]);
    }

    public function incomes()
    {
        $user = auth()->user();

        return $user->incomes()
            ->with('check')
            ->get();
    }

    public function expenses()
    {
        $user = auth()->user();

        return $user->expenses->all();
    }

    public function addPurchase(Request $request)
    {
        $data = $request->only(['amount', 'description']);

        $validator = Validator::make($data, (new StoreExpenseRequest())->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $expense = Transaction::create([
            'amount' => $data['amount'],
            'description' => $data['description'],
            'type' => TransactionType::Expense->value,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json($expense, Response::HTTP_CREATED);
    }
    
    public function depositCheck(Request $request)
    {
        $data = $request->only(['amount', 'description', 'picture']);

        $validator = Validator::make($data, (new StoreIncomeRequest())->rules());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return DB::transaction(function() use ($request, &$income) {
            $income = $this->createTransaction($request->only(['amount', 'description']), TransactionType::Income->value);

            $picture = $request->file('picture')->store('public');

            Check::create([
                'picture' => basename($picture),
                'transaction_id' => $income->id,
            ]);

            return response()->json($income, Response::HTTP_CREATED);
        });
    }

    protected function createTransaction(array $data, string $type)
    {
        return Transaction::create([
            'amount' => $data['amount'],
            'description' => $data['description'],
            'type' => $type,
            'user_id' => auth()->id(),
        ]);
    }
}
