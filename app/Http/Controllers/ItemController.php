<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Item;
use App\Models\UserDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['collection', 'userDesign'])->get();
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
        // Validasi request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'collection_id' => 'required|exists:collection,id',
            'type' => 'required|string|max:255',
            'preview_link' => 'nullable|string|max:255',
            'name_id' => 'nullable|string|max:255',
        ]);

        // Buat item baru dengan data yang sudah divalidasi
        $item = new Item();
        $item->title = $validatedData['title'];
        $item->collection_id = $validatedData['collection_id'];
        $item->type = $validatedData['type'];
        $item->preview_link = $validatedData['preview_link'];
        $item->name_id = $validatedData['name_id'];
        $item->created_at = Carbon::now();
        $item->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect('/items')->with('success', 'Item created successfully.');
    }



    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $collections = Collection::all();
        $userDesigns = UserDesign::all();
        return view('sites.item.edit', compact('item','collections', 'userDesigns'));
    }


    public function update(Request $request, $id)
    {
        // Validasi request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'collection_id' => 'required|exists:collection,id',
            'type' => 'required|string|max:255',
            'preview_link' => 'nullable|string|max:255',
            'name_id' => 'nullable|string|max:255',
        ]);
    
        // Temukan item yang akan diubah
        $item = Item::findOrFail($id);
    
        // Update item dengan data yang sudah divalidasi
        $item->fill($validatedData);
        $item->save();
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect('/items')->with('success', 'Item berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        // Temukan item yang akan dihapus
        $item = Item::findOrFail($id);

        // Hapus item
        $item->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect('/items')->with('success', 'Item deleted successfully.');
    }
}
