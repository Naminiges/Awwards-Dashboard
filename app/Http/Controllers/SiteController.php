<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserDesign;
use Illuminate\Http\Request;
use App\Models\Collection;

class SiteController extends Controller
{
    public function index()
    {
        $collections = Collection::with(['user', 'category'])->get();
        return view('sites.collection.collection', compact('collections'));
    }

    public function create()
    {
        // Fetch users from the database
        $users = UserDesign::all();

        // Fetch categories from the database
        $categories = Category::all();

        // Pass users and categories to the view
        return view('sites.collection.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $collection = Collection::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'followers_count' => $request->followers_count,
            'created_at' => now(), // or $request->created_at if provided
            'type' => $request->type,
            'url' => $request->url,
        ]);

        return redirect('/sites')->with('success', 'Collection created successfully.');
    }

    public function edit($id)
    {
        $collection = Collection::findOrFail($id);
        $users = UserDesign::all(); // Mendapatkan semua pengguna
        $categories = Category::all(); // Mendapatkan semua kategori
        return view('sites.collection.edit', compact('collection', 'users', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);
        $collection->name = $request->name;
        $collection->description = $request->description;
        $collection->user_id = $request->user_id;
        $collection->category_id = $request->category_id;
        $collection->followers_count = $request->followers_count;
        $collection->type = $request->type;
        $collection->url = $request->url;
        $collection->save();

        return redirect('/sites');
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        $collection->delete();

        return redirect('/sites');
    }
}
