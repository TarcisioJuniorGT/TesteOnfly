<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expense\StoreExpenseFormRequest;
use App\Http\Requests\Expense\UpdateExpenseFormRequest;
use App\Http\Resources\ExpenseResource;
use App\Jobs\SendNewExpenseNotification;
use App\Models\Expense;
use App\Notifications\NewExpenseNotification;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Auth::user()->expenses;
        if ($expenses->isEmpty()) {
            return response()->json([
                'message' => 'No expense registered'
            ]);
        } else {
            return ExpenseResource::collection(Auth::user()->expenses);
        }
    }

    public function store(StoreExpenseFormRequest $request)
    {
        $expense = new Expense();
        $expense->description = $request->input('description');
        $expense->date = $request->input('date');
        $expense->id_user = $request->input('id_user');
        $expense->value = $request->input('value');
        $expense->email = Auth::user()->email;
        $expense->save();
        SendNewExpenseNotification::dispatch($expense);
        return response()->json([
            'message' => 'Expense created'
        ], 200);
    }

    public function show(string $id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('show', $expense);
        return response()->json([
            'expense' => new ExpenseResource($expense)
        ], 200);
    }

    public function update(UpdateExpenseFormRequest $request, string $id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('update', $expense);
        $expense->description = $request->input('description');
        $expense->date = $request->input('date');
        $expense->id_user = $request->input('id_user');
        $expense->value = $request->input('value');
        $expense->email = Auth::user()->email;
        $expense->save();
        return response()->json([
            'message' => 'Expense edited'
        ], 200);
    }

    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('destroy', $expense);
        $expense->delete();
        return response()->json([
            'message' => 'Expense deleted'
        ], 200);
    }
}
