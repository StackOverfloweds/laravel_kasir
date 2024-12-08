<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
      // Menampilkan semua menu
      public function index()
      {
          $menus = Menu::all();
  
          // Append the full image URL to each menu
          $menus->each(function($menu) {
              if ($menu->image) {
                  $menu->image_url = asset('storage/' . $menu->image); // Generate full image URL
              }
          });
  
          return response()->json($menus);
      }
  
      // Menampilkan detail menu berdasarkan ID
      public function show($id)
      {
          $menu = Menu::find($id);
  
          if (!$menu) {
              return response()->json(['message' => 'Menu not found'], 404);
          }
  
          // Append the full image URL to the single menu
          if ($menu->image) {
              $menu->image_url = asset('storage/' . $menu->image); // Generate full image URL
          }
  
          return response()->json($menu);
      }

    // Menambah menu baru
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the image upload if it exists
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public'); // Store image in the 'menus' directory in the public disk
        } else {
            $imagePath = null;
        }

        // Create a new menu entry
        $menu = Menu::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'image' => $imagePath, // Save the image path in the database
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

        // Validate the request
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the image upload if it exists
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($menu->image && Storage::exists('public/' . $menu->image)) {
                Storage::delete('public/' . $menu->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('menus', 'public');
            $menu->image = $imagePath; // Update the image path
        }

        // Update other menu fields
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

        // Delete the image file if it exists
        if ($menu->image && Storage::exists('public/' . $menu->image)) {
            Storage::delete('public/' . $menu->image);
        }

        $menu->delete();

        return response()->json(['message' => 'Menu deleted successfully']);
    }
}
