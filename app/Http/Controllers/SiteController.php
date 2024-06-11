<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    private function getConnection()
    {
        $conn = new \mysqli('127.0.0.1', 'root', '', 'awwwards');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public function index()
    {
        $conn = $this->getConnection();
        $query = "SELECT collection.*, user.username AS user_name, category.name AS category_name 
                  FROM collection
                  JOIN user ON collection.user_id = user.id
                  JOIN category ON collection.category_id = category.id";
        $result = $conn->query($query);

        $collections = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $collections[] = $row;
            }
        }

        // Fetch categories from the database
        $categoryQuery = "SELECT * FROM category";
        $categoryResult = $conn->query($categoryQuery);
        $categories = [];
        if ($categoryResult->num_rows > 0) {
            while ($row = $categoryResult->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        $conn->close();

        return view('sites.collection.collection', compact('collections', 'categories'));
    }


    public function create()
    {
        $conn = $this->getConnection();

        // Fetch users from the database
        $userQuery = "SELECT * FROM user";
        $userResult = $conn->query($userQuery);
        $users = [];
        if ($userResult->num_rows > 0) {
            while ($row = $userResult->fetch_assoc()) {
                $users[] = $row;
            }
        }

        // Fetch categories from the database
        $categoryQuery = "SELECT * FROM category";
        $categoryResult = $conn->query($categoryQuery);
        $categories = [];
        if ($categoryResult->num_rows > 0) {
            while ($row = $categoryResult->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        $conn->close();

        return view('sites.collection.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $conn = $this->getConnection();

        $name = $conn->real_escape_string($request->name);
        $description = $conn->real_escape_string($request->description);
        $user_id = $conn->real_escape_string($request->user_id);
        $slug = $conn->real_escape_string($request->slug);
        $category_id = $conn->real_escape_string($request->category_id);
        $followers_count = $conn->real_escape_string($request->followers_count);
        $created_at = $conn->real_escape_string(now());
        $type = $conn->real_escape_string($request->type);
        $url = $conn->real_escape_string($request->url);

        $query = "INSERT INTO collection (name, description, user_id, slug, category_id, followers_count, created_at, type, url) 
                  VALUES ('$name', '$description', '$user_id', '$slug', '$category_id', '$followers_count', '$created_at', '$type', '$url')";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/sites')->with('success', 'Collection created successfully.');
        } else {
            $conn->close();
            return redirect('/sites/create')->with('error', 'Error creating collection: ' . $conn->error);
        }
    }

    public function edit($id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);

        // Fetch collection data
        $collectionQuery = "SELECT * FROM collection WHERE id = $id";
        $collectionResult = $conn->query($collectionQuery);
        if ($collectionResult->num_rows > 0) {
            $collection = $collectionResult->fetch_assoc();
        } else {
            $conn->close();
            return redirect('/sites')->with('error', 'Collection not found.');
        }

        // Fetch users from the database
        $userQuery = "SELECT * FROM user";
        $userResult = $conn->query($userQuery);
        $users = [];
        if ($userResult->num_rows > 0) {
            while ($row = $userResult->fetch_assoc()) {
                $users[] = $row;
            }
        }

        // Fetch categories from the database
        $categoryQuery = "SELECT * FROM category";
        $categoryResult = $conn->query($categoryQuery);
        $categories = [];
        if ($categoryResult->num_rows > 0) {
            while ($row = $categoryResult->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        $conn->close();

        return view('sites.collection.edit', compact('collection', 'users', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $name = $conn->real_escape_string($request->name);
        $description = $conn->real_escape_string($request->description);
        $user_id = $conn->real_escape_string($request->user_id);
        $category_id = $conn->real_escape_string($request->category_id);
        $followers_count = $conn->real_escape_string($request->followers_count);
        $type = $conn->real_escape_string($request->type);
        $url = $conn->real_escape_string($request->url);

        $query = "UPDATE collection SET 
                  name = '$name', description = '$description', user_id = '$user_id', category_id = '$category_id', 
                  followers_count = '$followers_count', type = '$type', url = '$url' 
                  WHERE id = $id";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/sites')->with('success', 'Collection updated successfully.');
        } else {
            $conn->close();
            return redirect("/sites/$id/edit")->with('error', 'Error updating collection: ' . $conn->error);
        }
    }

    public function destroy($id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $query = "DELETE FROM collection WHERE id = $id";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/sites')->with('success', 'Collection deleted successfully.');
        } else {
            $conn->close();
            return redirect('/sites')->with('error', 'Error deleting collection: ' . $conn->error);
        }
    }
}

// <?php

// namespace App\Http\Controllers;

// use App\Models\Category;
// use App\Models\UserDesign;
// use Illuminate\Http\Request;
// use App\Models\Collection;

// class SiteController extends Controller
// {
//     public function index()
//     {
//         $collections = Collection::with(['user', 'category'])->get();
//         return view('sites.collection.collection', compact('collections'));
//     }

//     public function create()
//     {
//         // Fetch users from the database
//         $users = UserDesign::all();

//         // Fetch categories from the database
//         $categories = Category::all();

//         // Pass users and categories to the view
//         return view('sites.collection.create', compact('users', 'categories'));
//     }

//     public function store(Request $request)
//     {
//         $collection = Collection::create([
//             'name' => $request->name,
//             'description' => $request->description,
//             'user_id' => $request->user_id,
//             'slug' => $request->slug,
//             'category_id' => $request->category_id,
//             'followers_count' => $request->followers_count,
//             'created_at' => now(), // or $request->created_at if provided
//             'type' => $request->type,
//             'url' => $request->url,
//         ]);

//         return redirect('/sites')->with('success', 'Collection created successfully.');
//     }

//     public function edit($id)
//     {
//         $collection = Collection::findOrFail($id);
//         $users = UserDesign::all(); // Mendapatkan semua pengguna
//         $categories = Category::all(); // Mendapatkan semua kategori
//         return view('sites.collection.edit', compact('collection', 'users', 'categories'));
//     }


//     public function update(Request $request, $id)
//     {
//         $collection = Collection::findOrFail($id);
//         $collection->name = $request->name;
//         $collection->description = $request->description;
//         $collection->user_id = $request->user_id;
//         $collection->category_id = $request->category_id;
//         $collection->followers_count = $request->followers_count;
//         $collection->type = $request->type;
//         $collection->url = $request->url;
//         $collection->save();

//         return redirect('/sites');
//     }

//     public function destroy($id)
//     {
//         $collection = Collection::findOrFail($id);
//         $collection->delete();

//         return redirect('/sites');
//     }
// }
