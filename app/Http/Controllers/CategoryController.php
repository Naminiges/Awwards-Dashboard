<?php

// app/Http/Controllers/SiteController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('sites.category.category', compact('categories'));
    }

    public function create()
    {
        return view('sites.category.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|unique:category|max:255',
            'slug' => 'required|unique:category|max:255',
        ]);

        // Buat instansiasi objek Category dan atur nilainya
        $category = Category::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
        ]);

        // Redirect ke halaman kategori dengan pesan sukses
        return redirect('/categories')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('sites.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect('/categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/categories')->with('success', 'Category deleted successfully.');
    }



}
