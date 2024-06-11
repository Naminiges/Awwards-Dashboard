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
            <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go to
                Homepage</a>
            <a href="/sites/create" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add
                New Collection</a>
        </div>
        <h1 class="text-3xl font-bold mb-8">Collections</h1>
        @if (session('success'))
            <div id="alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Success:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span id="close-btn" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                    <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1 1 0 01-1.414 1.414L10 11.414l-2.93 2.93a1 1 0 01-1.415-1.415l2.93-2.93-2.93-2.93a1 1 0 111.415-1.415l2.93 2.93 2.93-2.93a1 1 0 111.415 1.415l-2.93 2.93 2.93 2.93a1 1 0 010 1.414z" />
                    </svg>
                </span>
            </div>
        @endif

        <script>
            // Ambil elemen tombol close dan alert
            const closeBtn = document.getElementById('close-btn');
            const alertBox = document.getElementById('alert');

            // Tambahkan event listener untuk tombol close
            closeBtn.addEventListener('click', () => {
                alertBox.style.display = 'none'; // Sembunyikan alert saat tombol close ditekan
            });
        </script>

        <!-- Category Filter Dropdown -->
        <div class="mb-4">
            <label for="categoryFilter" class="block text-gray-700 text-sm font-bold mb-2">Filter by Category:</label>
            <select id="categoryFilter"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>

        <table id="myTable" class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">URL</th>
                    <th class="px-4 py-2">Followers Count</th>
                    <th class="px-4 py-2">Actions</th>
                    <th class="px-4 py-2" style="display: none;">Category ID</th> <!-- Hidden Category ID column -->
                </tr>
            </thead>
            <tbody>
                @foreach ($collections as $collection)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $collection['id'] }}</td>
                        <td class="border px-4 py-2">{{ $collection['name'] }}</td>
                        <td class="border px-4 py-2">{{ $collection['description'] }}</td>
                        <td class="border px-4 py-2">{{ $collection['user_name'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $collection['category_name'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            @if (!empty($collection['created_at']))
                                @php
                                    $timestamp = is_numeric($collection['created_at'])
                                        ? $collection['created_at']
                                        : strtotime($collection['created_at']);
                                @endphp
                                {{ \Carbon\Carbon::createFromTimestamp($timestamp)->format('d F Y') }}
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $collection['type'] }}</td>
                        <td class="border px-4 py-2">{{ $collection['url'] }}</td>
                        <td class="border px-4 py-2">{{ $collection['followers_count'] }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="/sites/{{ $collection['id'] }}/edit"
                                class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/sites/{{ $collection['id'] }}" method="POST" class="inline-block"
                                onsubmit="return confirmDelete()" id="delete-user-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td class="border px-4 py-2" style="display: none;">{{ $collection['category_id'] }}</td>
                        <!-- Hidden Category ID column value -->
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
        var table = $('#myTable').DataTable({
            columnDefs: [{
                targets: [10], // Target the hidden category ID column
                visible: false,
                searchable: true
            }]
        });

        // Filter by category
        $('#categoryFilter').on('change', function() {
            var category = $(this).val();
            table.column(10).search(category).draw(); // Search in the hidden category ID column
        });
    });

    function confirmDelete() {
        return confirm('Are you sure you want to delete this collection?');
    }
</script>

</html>
