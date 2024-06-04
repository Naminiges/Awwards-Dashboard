<!DOCTYPE html>
<html>
<head>
    <title>Collections</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="mt-4 mb-4">
            <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go to Homepage</a>
            <a href="/sites/create" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New Collection</a>
        </div>
        <h1 class="text-3xl font-bold mb-8">Collections</h1>
        <table id="myTable" class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Followers Count</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">URL</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collections as $collection)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $collection->id }}</td>
                        <td class="border px-4 py-2">{{ $collection->name }}</td>
                        <td class="border px-4 py-2">{{ $collection->description }}</td>
                        <td class="border px-4 py-2">{{ $collection->user->username ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $collection->category->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $collection->followers_count }}</td>
                        <td class="border px-4 py-2">{{ $collection->created_at }}</td>
                        <td class="border px-4 py-2">{{ $collection->type }}</td>
                        <td class="border px-4 py-2">{{ $collection->url }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="/sites/{{ $collection->id }}/edit" class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/sites/{{ $collection->id }}" method="POST" class="inline-block">
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
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
</html>