<!DOCTYPE html>
<html>

<head>
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="mt-4 mb-4">
            <a href="/categories" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to
                Category</a>
        </div>
        <h1 class="text-3xl font-bold mb-4">Edit Category</h1>
        <form action="/categories/{{ $category->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                <input type="text" name="name" id="name" oninput="generateSlug()"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('name', $category->name ?? '') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">Slug</label>
                <input type="text" name="slug" id="slug"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('slug', $category->slug ?? '') }}">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update</button>
            </div>
        </form>
    </div>
    <script>
        function generateSlug() {
            // Get the value from the name input
            const name = document.getElementById('name').value;

            // Convert the name to a slug
            const slug = name.trim().toLowerCase().replace(/\s+/g, '-');

            // Set the slug value to the slug input
            document.getElementById('slug').value = slug;
        }
    </script>
</body>

</html>
