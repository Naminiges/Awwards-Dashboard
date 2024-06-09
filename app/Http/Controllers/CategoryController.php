<?php

// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
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

        $query = "SELECT * FROM category";
        $result = $conn->query($query);

        $categories = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        $conn->close();

        return view('sites.category.category', compact('categories'));
    }

    public function create()
    {
        return view('sites.category.create');
    }

    public function store(Request $request)
    {
        // Validate data
        $validatedData = $request->validate([
            'name' => 'required|unique:category|max:255',
            'slug' => 'required|unique:category|max:255',
        ]);

        $conn = $this->getConnection();

        $name = $conn->real_escape_string($validatedData['name']);
        $slug = $conn->real_escape_string($validatedData['slug']);

        $query = "INSERT INTO category (name, slug) VALUES ('$name', '$slug')";
        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/categories')->with('success', 'Category created successfully.');
        } else {
            $conn->close();
            return redirect('/categories/create')->with('error', 'Error creating category: ' . $conn->error);
        }
    }

    public function edit($id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $query = "SELECT * FROM category WHERE id = $id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
        } else {
            $conn->close();
            return redirect('/categories')->with('error', 'Category not found.');
        }
        $conn->close();

        return view('sites.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);

        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $name = $conn->real_escape_string($request->input('name'));
        $slug = $conn->real_escape_string($request->input('slug'));

        $query = "UPDATE category SET name = '$name', slug = '$slug' WHERE id = $id";
        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/categories')->with('success', 'Category updated successfully.');
        } else {
            $conn->close();
            return redirect("/categories/$id/edit")->with('error', 'Error updating category: ' . $conn->error);
        }
    }

    public function destroy($id)
    {
        $conn = $this->getConnection();

        $id = $conn->real_escape_string($id);
        $query = "DELETE FROM category WHERE id = $id";
        if ($conn->query($query) === TRUE) {
            $conn->close();
            return redirect('/categories')->with('success', 'Category deleted successfully.');
        } else {
            $conn->close();
            return redirect('/categories')->with('error', 'Error deleting category: ' . $conn->error);
        }
    }
}

// <?php

// // app/Http/Controllers/SiteController.php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Category;

// class CategoryController extends Controller
// {
//     public function index()
//     {
//         $categories = Category::all();
//         return view('sites.category.category', compact('categories'));
//     }

//     public function create()
//     {
//         return view('sites.category.create');
//     }

//     public function store(Request $request)
//     {
//         // Validasi data
//         $validatedData = $request->validate([
//             'name' => 'required|unique:category|max:255',
//             'slug' => 'required|unique:category|max:255',
//         ]);

//         // Buat instansiasi objek Category dan atur nilainya
//         $category = Category::create([
//             'name' => $validatedData['name'],
//             'slug' => $validatedData['slug'],
//         ]);

//         // Redirect ke halaman kategori dengan pesan sukses
//         return redirect('/categories')->with('success', 'Category created successfully.');
//     }

//     public function edit($id)
//     {
//         $category = Category::findOrFail($id);
//         return view('sites.category.edit', compact('category'));
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'name' => 'required|max:255',
//             'slug' => 'required|max:255',
//         ]);

//         $category = Category::findOrFail($id);
//         $category->update($request->all());

//         return redirect('/categories')->with('success', 'Category updated successfully.');
//     }

//     public function destroy($id)
//     {
//         $category = Category::findOrFail($id);
//         $category->delete();

//         return redirect('/categories')->with('success', 'Category deleted successfully.');
//     }



// }
