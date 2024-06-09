<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDesignController extends Controller
{
    private function getConnection()
    {
        $conn = new \mysqli('127.0.0.1', 'root', '', 'awwwards');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function users()
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM user";
        $result = $conn->query($query);
        $users = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        $conn->close();

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

        $conn = $this->getConnection();
        $username = $conn->real_escape_string($request->username);
        $displayName = $conn->real_escape_string($request->display_name);
        $query = "INSERT INTO user (username, display_name) VALUES ('$username', '$displayName')";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect()->route('users')->with('success', 'User created successfully.');
        } else {
            $conn->close();
            return redirect()->route('users')->with('error', 'Error creating user: ' . $conn->error);
        }
    }

    public function edit($id)
    {
        $conn = $this->getConnection();
        $id = $conn->real_escape_string($id);
        $query = "SELECT * FROM user WHERE id = '$id'";
        $result = $conn->query($query);
        $user = $result->fetch_assoc();
        $conn->close();

        return view('sites.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:user,username,' . $id,
            'display_name' => 'required',
        ]);

        $conn = $this->getConnection();
        $id = $conn->real_escape_string($id);
        $username = $conn->real_escape_string($request->username);
        $displayName = $conn->real_escape_string($request->display_name);
        $query = "UPDATE user SET username = '$username', display_name = '$displayName' WHERE id = '$id'";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect()->route('users')->with('success', 'User updated successfully.');
        } else {
            $conn->close();
            return redirect()->route('users')->with('error', 'Error updating user: ' . $conn->error);
        }
    }

    public function destroy($id)
    {
        $conn = $this->getConnection();
        $id = $conn->real_escape_string($id);
        $query = "DELETE FROM user WHERE id = '$id'";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect()->route('users')->with('success', 'User deleted successfully.');
        } else {
            $conn->close();
            return redirect()->route('users')->with('error', 'Error deleting user: ' . $conn->error);
        }
    }
}

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\UserDesign;

// class UserDesignController extends Controller
// {
//     public function users()
//     {
//         $users = UserDesign::all();
//         return view('sites.user.user', compact('users'));
//     }

//     public function create()
//     {
//         return view('sites.user.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'username' => 'required|unique:user',
//             'display_name' => 'required',
//         ]);

//         UserDesign::create($request->all());

//         return redirect()->route('users')->with('success', 'User created successfully.');
//     }

//     public function edit($id)
//     {
//         $user = UserDesign::findOrFail($id);
//         return view('sites.user.edit', compact('user'));
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'username' => 'required|unique:user,username,' . $id,
//             'display_name' => 'required',
//         ]);

//         $user = UserDesign::findOrFail($id);
//         $user->update($request->all());

//         return redirect()->route('users')->with('success', 'User updated successfully.');
//     }

//     public function destroy($id)
//     {
//         $user = UserDesign::findOrFail($id);
//         $user->delete();

//         return redirect()->route('users')->with('success', 'User deleted successfully.');
//     }
// }
