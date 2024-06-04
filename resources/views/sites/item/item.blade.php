<!DOCTYPE html>
<html>

<head>
    <title>Items</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="mt-4 mb-4">
            <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go to
                Homepage</a>
            <a href="/items/create" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add
                New Item</a>
        </div>
        <h1 class="text-3xl font-bold mb-8">Items</h1>
        <table id="myTable" class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Collection</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Preview Link</th>
                    <th class="px-4 py-2">User Design Name</th>
                    <th class="px-4 py-2">Tags</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $item->id }}</td>
                        <td class="border px-4 py-2">{{ $item->title }}</td>
                        <td class="border px-4 py-2">{{ $item->collection->name }}</td>
                        <td class="border px-4 py-2">{{ $item->created_at }}</td>
                        <td class="border px-4 py-2">{{ $item->type }}</td>
                        <td class="border px-4 py-2">{{ $item->preview_link }}</td>
                        <td class="border px-4 py-2">{{ $item->userDesign->username }}</td>
                        <td class="border px-4 py-2">
                            @foreach ($item->tags as $tag)
                                {{ $tag->name }}
                                @if (!$loop->last)
                                    , <!-- Add comma if it's not the last tag -->
                                @endif
                            @endforeach
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <a href="/items/{{ $item->id }}/edit"
                                class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/items/{{ $item->id }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

</html>