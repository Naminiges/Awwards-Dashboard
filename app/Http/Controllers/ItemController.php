<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Collection;
use App\Models\Item;
use App\Models\Tag;
use App\Models\User;

class ItemController extends Controller
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
        $query = "SELECT item.*, collection.name AS collection_name, user.username AS user_name, GROUP_CONCAT(tag.name) AS tags
        FROM item
        LEFT JOIN collection ON item.collection_id = collection.id
        LEFT JOIN user ON item.name_id = user.id
        LEFT JOIN item_tag ON item.id = item_tag.item_id
        LEFT JOIN tag ON item_tag.tag_id = tag.id
        GROUP BY item.id";
        $result = $conn->query($query);

        $items = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        $conn->close();

        return view('sites.item.item', compact('items'));
    }

    public function create()
    {
        $conn = $this->getConnection();

        // Fetch collections from the database
        $collectionQuery = "SELECT * FROM collection";
        $collectionResult = $conn->query($collectionQuery);
        $collections = [];
        if ($collectionResult->num_rows > 0) {
            while ($row = $collectionResult->fetch_assoc()) {
                $collections[] = $row;
            }
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

        $conn->close();

        return view('sites.item.create', compact('collections', 'users'));
    }

    public function store(Request $request)
    {
        $conn = $this->getConnection();
    
        // Validate request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'collection_id' => 'required|exists:collection,id',
            'type' => 'required|string|max:255',
            'preview_link' => 'nullable|string|max:255',
            'name_id' => 'nullable|string|max:255',
            'tags' => 'nullable|string', // Add validation for tags
        ]);
    
        $title = $conn->real_escape_string($request->title);
        $collection_id = $conn->real_escape_string($request->collection_id);
        $type = $conn->real_escape_string($request->type);
        $preview_link = $conn->real_escape_string($request->preview_link);
        $name_id = $conn->real_escape_string($request->name_id);
        $created_at = $conn->real_escape_string(now());
    
        // Insert into the items table using raw SQL
        $query = "INSERT INTO item (title, collection_id, type, preview_link, name_id, created_at) 
                  VALUES ('$title', '$collection_id', '$type', '$preview_link', '$name_id', '$created_at')";
    
        if ($conn->query($query) === TRUE) {
            $itemId = $conn->insert_id;
            // Insert tags
            if ($request->has('tags')) {
                $tags = $conn->real_escape_string($request->input('tags'));
                // Insert the tags directly into the database
                $tagQuery = "INSERT INTO tag (name) VALUES ('$tags')";
                $conn->query($tagQuery);
                // Get the last inserted tag's ID
                $tagId = $conn->insert_id;
                // Insert into the item_tag pivot table
                $pivotQuery = "INSERT INTO item_tag (item_id, tag_id) VALUES ('$itemId', '$tagId')";
                $conn->query($pivotQuery);
            }
            $conn->close();
            return redirect('/items')->with('success', 'Item created successfully.');
        } else {
            $conn->close();
            return redirect('/items/create')->with('error', 'Error creating item: ' . $conn->error);
        }
    }
    

    public function edit($id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);

        $query = "SELECT item.*, collection.name AS collection_name, user.username AS user_name, GROUP_CONCAT(tag.name) AS tags
                  FROM item
                  LEFT JOIN collection ON item.collection_id = collection.id
                  LEFT JOIN user ON item.name_id = user.id
                  LEFT JOIN item_tag ON item.id = item_tag.item_id
                  LEFT JOIN tag ON item_tag.tag_id = tag.id
                  WHERE item.id = $id
                  GROUP BY item.id";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $item = $result->fetch_assoc();
            // Fetch collections from the database
            $collectionQuery = "SELECT * FROM collection";
            $collectionResult = $conn->query($collectionQuery);
            $collections = [];
            if ($collectionResult->num_rows > 0) {
                while ($row = $collectionResult->fetch_assoc()) {
                    $collections[] = $row;
                }
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

            $conn->close();
            return view('sites.item.edit', compact('item', 'collections', 'users'));
        } else {
            $conn->close();
            return redirect('/items')->with('error', 'Item not found.');
        }
    }


    public function update(Request $request, $id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $title = $conn->real_escape_string($request->title);
        $collection_id = $conn->real_escape_string($request->collection_id);
        $type = $conn->real_escape_string($request->type);
        $preview_link = $conn->real_escape_string($request->preview_link);
        $name_id = $conn->real_escape_string($request->name_id);

        // Update item
        $query = "UPDATE item SET 
                  title = '$title', collection_id = '$collection_id', type = '$type', 
                  preview_link = '$preview_link', name_id = '$name_id'
                  WHERE id = $id";

        if ($conn->query($query) === TRUE) {
            // Update tags if present in the request
            if ($request->has('tags')) {
                $tags = $conn->real_escape_string($request->input('tags'));

                // Update tags directly
                $updateQuery = "UPDATE tag 
                                SET name = '$tags' 
                                WHERE id IN (SELECT tag_id FROM item_tag WHERE item_id = $id)";
                $conn->query($updateQuery);
            }
            $conn->close();
            return redirect('/items')->with('success', 'Item updated successfully.');
        } else {
            $conn->close();
            return redirect("/items/$id/edit")->with('error', 'Error updating item: ' . $conn->error);
        }
    }




    public function destroy($id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $query = "DELETE FROM item WHERE id = $id";

        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/items')->with('success', 'Item deleted successfully.');
        } else {
            $conn->close();
            return redirect('/items')->with('error', 'Error deleting item: ' . $conn->error);
        }
    }
}

// <?php

// namespace App\Http\Controllers;

// use App\Models\Collection;
// use App\Models\Item;
// use App\Models\Tag;
// use App\Models\UserDesign;
// use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;

// class ItemController extends Controller
// {
//     public function index()
//     {
//         $items = Item::with(['collection', 'userDesign'])->get();
//         return view('sites.item.item', compact('items'));
//     }

//     public function create()
//     {
//         $collections = Collection::all();
//         $userDesigns = UserDesign::all();
//         return view('sites.item.create', compact('collections', 'userDesigns'));
//     }

//     public function store(Request $request)
//     {
//         // Validasi request
//         $validatedData = $request->validate([
//             'title' => 'required|string|max:255',
//             'collection_id' => 'required|exists:collection,id',
//             'type' => 'required|string|max:255',
//             'preview_link' => 'nullable|string|max:255',
//             'name_id' => 'nullable|string|max:255',
//             'tags' => 'nullable|string', // Tambahkan validasi untuk tags
//         ]);

//         // Buat item baru dengan data yang sudah divalidasi
//         $item = new Item();
//         $item->title = $validatedData['title'];
//         $item->collection_id = $validatedData['collection_id'];
//         $item->type = $validatedData['type'];
//         $item->preview_link = $validatedData['preview_link'];
//         $item->name_id = $validatedData['name_id'];
//         $item->created_at = Carbon::now();
//         $item->save();

//         // Simpan tags
//         if ($request->has('tags')) {
//             $tags = explode(',', $request->input('tags'));
//             $tagIds = [];
//             foreach ($tags as $tagName) {
//                 $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
//                 $tagIds[] = $tag->id;
//             }
//             $item->tags()->sync($tagIds);
//         }

//         // Redirect ke halaman index dengan pesan sukses
//         return redirect('/items')->with('success', 'Item created successfully.');
//     }



//     public function edit($id)
//     {
//         $item = Item::findOrFail($id);
//         $collections = Collection::all();
//         $userDesigns = UserDesign::all();
//         return view('sites.item.edit', compact('item', 'collections', 'userDesigns'));
//     }


//     public function update(Request $request, $id)
//     {
//         // Validasi request
//         $validatedData = $request->validate([
//             'title' => 'required|string|max:255',
//             'collection_id' => 'required|exists:collection,id',
//             'type' => 'required|string|max:255',
//             'preview_link' => 'nullable|string|max:255',
//             'name_id' => 'nullable|string|max:255',
//             'tags' => 'nullable|string', // Tambahkan validasi untuk tags
//         ]);

//         // Temukan item yang akan diubah
//         $item = Item::findOrFail($id);

//         // Update item dengan data yang sudah divalidasi
//         $item->fill($validatedData);
//         $item->save();

//         // Update tags
//         if ($request->has('tags')) {
//             $tags = explode(',', $request->input('tags'));
//             $tagIds = [];
//             foreach ($tags as $tagName) {
//                 $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
//                 $tagIds[] = $tag->id;
//             }
//             $item->tags()->sync($tagIds);
//         }

//         // Redirect ke halaman index dengan pesan sukses
//         return redirect('/items')->with('success', 'Item berhasil diperbarui.');
//     }


//     public function destroy($id)
//     {
//         // Temukan item yang akan dihapus
//         $item = Item::findOrFail($id);

//         // Hapus item
//         $item->delete();

//         // Redirect ke halaman index dengan pesan sukses
//         return redirect('/items')->with('success', 'Item deleted successfully.');
//     }
// }
