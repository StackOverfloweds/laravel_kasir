<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;

class SalesTransactionController extends Controller
{
    // Menampilkan semua transaksi penjualan
    public function index()
    {
        $transactions = SalesTransaction::all();
        return response()->json($transactions);
    }

    // Menampilkan transaksi penjualan berdasarkan ID
    public function show($id)
    {
        $transaction = SalesTransaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    // Menambah transaksi penjualan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|numeric',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction = SalesTransaction::create($validated);

        return response()->json($transaction, 201);
    }

    // Mengupdate transaksi penjualan
    public function update(Request $request, $id)
    {
        $transaction = SalesTransaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $validated = $request->validate([
            'menu_id' => 'sometimes|exists:menus,id',
            'quantity' => 'sometimes|numeric',
            'total_price' => 'sometimes|numeric',
            'payment_method' => 'sometimes|string',
            'transaction_date' => 'sometimes|date',
        ]);

        $transaction->update($validated);

        return response()->json($transaction);
    }

    // Menghapus transaksi penjualan
    public function destroy($id)
    {
        $transaction = SalesTransaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}