<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesTransactionController extends Controller
{
    // Menampilkan semua transaksi penjualan
    public function index()
    {
        // Eager load 'menu' and 'user' relationships
        $transactions = SalesTransaction::with(['menu', 'user'])
            ->get();

        // Map the results to include the menu name and user name
        $transactionsWithDetails = $transactions->map(function ($transaction) {
            $transaction->menu_name = $transaction->menu->name;  // Get the menu name
            $transaction->user_name = $transaction->user->name;  // Get the user name
            return $transaction;
        });

        return response()->json($transactionsWithDetails);
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
        try {
            // Validate input from the request
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id', // Ensure user_id is valid
                'menu_id' => 'required|array', // Ensure menu_id is an array
                'menu_id.*' => 'exists:menus,id', // Ensure all menu_ids are valid
                'quantity' => 'required|array', // Ensure quantity is an array
                'quantity.*' => 'integer|min:1', // Ensure all quantities are valid integers
                'total_amount' => 'required|numeric',
                'payment_method' => 'required|string|in:QRIS,Cash,Bank',
                'transaction_date' => 'required|date',
            ]);

            // Begin a transaction to handle multiple items
            DB::beginTransaction();

            // Loop through each menu item and store the transaction for each item
            foreach ($validated['menu_id'] as $index => $menuId) {
                SalesTransaction::create([
                    'user_id' => $validated['user_id'],
                    'menu_id' => $menuId,
                    'quantity' => $validated['quantity'][$index], // Get the corresponding quantity
                    'total_amount' => $validated['total_amount'], // You can calculate total for each item if needed
                    'payment_method' => $validated['payment_method'],
                    'transaction_date' => $validated['transaction_date'],
                ]);
            }

            // Commit the transaction to save all entries
            DB::commit();

            // Log success
            Log::info('Transaksi berhasil disimpan', ['request_data' => $validated]);

            return response()->json(['message' => 'Transaksi berhasil disimpan'], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Log error details
            Log::error('Error menyimpan transaksi penjualan', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan transaksi.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
