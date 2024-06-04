<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Collection;
use App\Models\UserDesign;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('sites.item.item', compact('items'));
    }

    public function create()
    {
        $collections = Collection::all();
        $userDesigns = UserDesign::all();
        return view('sites.item.create', compact('collections', 'userDesigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'collection_id' => 'required|exists:collection,id',
            'type' => 'required|max:255',
            'preview_link' => 'required', // Menambahkan validasi untuk preview_link
            'name_id' => 'required', // Menambahkan validasi untuk name_id
        ]);
    
        Item::create($request->all());
    
        return redirect('/items')->with('success', 'Item created successfully.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $collections = Collection::all();
        $userDesigns = UserDesign::all();
        return view('sites.item.edit', compact('item', 'collections', 'userDesigns'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'collection_id' => 'required|exists:collections,id',
            'type' => 'required|max:255',
            // Add other validation rules as needed
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->all());

        return redirect('/items')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect('/items')->with('success', 'Item deleted successfully.');
    }
}

