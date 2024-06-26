<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Edit Item</h1>
        <form action="/items/{{ $item['id'] }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
                <input type="text" name="title" id="title" value="{{ $item['title'] }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
            <div class="mb-4">
                <label for="collection_id" class="block text-gray-700 font-bold mb-2">Collection:</label>
                <select name="collection_id" id="collection_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="">Select Collection</option>
                    @foreach ($collections as $collection)
                        <option value="{{ $collection['id'] }}"
                            {{ $collection['id'] == $item['collection_id'] ? 'selected' : '' }}>
                            {{ $collection['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                <input type="text" name="type" id="type" value="{{ $item['type'] }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
            <div class="mb-4">
                <label for="preview_link" class="block text-gray-700 font-bold mb-2">Preview Link:</label>
                <input type="text" name="preview_link" id="preview_link" value="{{ $item['preview_link'] }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="name_id" class="block text-gray-700 font-bold mb-2">User Design Name:</label>
                <select name="name_id" id="name_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Pilih User Design</option>
                    @foreach ($users as $userDesign)
                        <option value="{{ $userDesign['id'] }}"
                            {{ $userDesign['id'] == $item['name_id'] ? 'selected' : '' }}>{{ $userDesign['username'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Tambahkan input untuk tags -->
            <div class="mb-4">
                <label for="tags" class="block text-gray-700 font-bold mb-2">Tags:</label>
                <input type="text" name="tags" id="tags" value="{{ $item['tags'] }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Masukkan tags, pisahkan dengan koma">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update
                    Item</button>
                <a href="/items"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>
