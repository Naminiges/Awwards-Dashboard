<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // public function index()
    // {
    //     $tables = DB::select('SHOW TABLES');
    //     $tables = array_map('current', $tables);
    //     return view('admin.index', compact('tables'));
    // }

    // public function showTable($table)
    // {
    //     $columns = DB::getSchemaBuilder()->getColumnListing($table);
    //     $data = DB::table($table)->get();
    //     return view('admin.table', compact('table', 'columns', 'data'));
    // }
    public function index()
    {
        $items = Item::with('collection')->get();
        $itemsGroupedByCollection = $items->groupBy('collection.name')->map(function ($group) {
            return $group->count();
        });
    
        $itemsData = $itemsGroupedByCollection->map(function($count, $collectionName) {
            return [
                'collectionName' => $collectionName,
                'count' => $count,
            ];
        })->values();

        return view('welcome', compact('items', 'itemsData'));
    }

}

// iya???