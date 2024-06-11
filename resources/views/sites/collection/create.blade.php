<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="mt-4 mb-4">
            <a href="/sites" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to
                Collections</a>
        </div>
        <h1 class="text-3xl font-bold mb-4">Add New Collection</h1>
        <form action="/sites" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                <input required type="text" name="name" id="name" oninput="generateSlug()"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">Slug</label>
                <input required type="text" name="slug" id="slug"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                <textarea name="description" id="description"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <!-- Inside your form -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">User</label>
                <select name="user_id" id="user_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select User</option>
                    [@foreach ($users as $user)]
                        <option value="{{ $user['id'] }}">{{ $user['username'] }}</option>
                    [@endforeach]
                </select>
            </div>

            <!-- Inside your form -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Category</label>
                <select name="category_id" id="category_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Category</option>
                    [@foreach ($categories as $category)]
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    [@endforeach]
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="followers_count">Followers Count</label>
                <input required type="text" name="followers_count" id="followers_count"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="type">Type</label>
                <input required type="text" name="type" id="type"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="url">URL</label>
                <input required type="text" name="url" id="url"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create</button>
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
