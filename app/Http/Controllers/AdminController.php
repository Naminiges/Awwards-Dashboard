<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current', $tables);
        return view('admin.index', compact('tables'));
    }

    public function showTable($table)
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        $data = DB::table($table)->get();
        return view('admin.table', compact('table', 'columns', 'data'));
    }
}

// iya???