<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengeluaranBelanja;
class PengeluaranBelanjaController extends Controller
{
    // Get all expenses
    public function index()
    {
        $expenses = PengeluaranBelanja::all();
        return response()->json($expenses);
    }

    // Store a new expense
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense = PengeluaranBelanja::create($request->all());
        return response()->json($expense, 201);
    }

    // Show a specific expense
    public function show($id)
    {
        $expense = PengeluaranBelanja::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        return response()->json($expense);
    }

    // Update an existing expense
    public function update(Request $request, $id)
    {
        $expense = PengeluaranBelanja::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'date' => 'sometimes|required|date',
        ]);

        $expense->update($request->all());
        return response()->json($expense);
    }

    // Delete an expense
    public function destroy($id)
    {
        $expense = PengeluaranBelanja::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        $expense->delete();
        return response()->json(['message' => 'Expense deleted successfully']);
    }
}
