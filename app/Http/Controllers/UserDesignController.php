<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDesign;

class UserDesignController extends Controller
{
    public function users()
    {
        $users = UserDesign::all();
        return view('sites.user.user', compact('users'));
    }

    public function create()
    {
        return view('sites.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:user',
            'display_name' => 'required',
        ]);

        UserDesign::create($request->all());

        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = UserDesign::findOrFail($id);
        return view('sites.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:user,username,' . $id,
            'display_name' => 'required',
        ]);

        $user = UserDesign::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = UserDesign::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }
}
