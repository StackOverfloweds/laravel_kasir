<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Menampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    // Menampilkan detail menu berdasarkan ID
    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        return response()->json($menu);
    }

    // Menambah menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'required|string',
        ]);

        $menu = Menu::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'category' => $validated['category'],
        ]);

        return response()->json($menu, 201);
    }

    // Mengupdate menu
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
        ]);

        if (isset($validated['name'])) {
            $menu->name = $validated['name'];
        }
        if (isset($validated['price'])) {
            $menu->price = $validated['price'];
        }
        if (isset($validated['description'])) {
            $menu->description = $validated['description'];
        }
        if (isset($validated['category'])) {
            $menu->category = $validated['category'];
        }

        $menu->save();

        return response()->json($menu);
    }

    // Menghapus menu
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->delete();

        return response()->json(['message' => 'Menu deleted successfully']);
    }
}