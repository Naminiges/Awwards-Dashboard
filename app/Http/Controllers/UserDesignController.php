<?php

// app/Http/Controllers/SiteController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDesign;

class UserDesignController extends Controller
{
    public function users()
    {
        $users = UserDesign::all();
        return view('sites.user', compact('users'));
    }
}
