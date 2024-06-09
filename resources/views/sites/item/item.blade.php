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
                        <td class="border px-4 py-2">{{ $item['id'] }}</td>
                        <td class="border px-4 py-2">{{ $item['title'] }}</td>
                        <td class="border px-4 py-2">{{ $item['collection_name'] }}</td>
                        <td class="border px-4 py-2">
                            @if (!empty($item['created_at']))
                                @php
                                    $timestamp = is_numeric($item['created_at'])
                                        ? $item['created_at']
                                        : strtotime($item['created_at']);
                                @endphp
                                {{ \Carbon\Carbon::createFromTimestamp($timestamp)->format('d F Y') }}
                            @endif
                        </td>

                        <td class="border px-4 py-2">{{ $item['type'] }}</td>
                        <td class="border px-4 py-2">{{ $item['preview_link'] }}</td>
                        <td class="border px-4 py-2">{{ $item['user_name'] }}</td>
                        <td class="border px-4 py-2">
                            @foreach (explode(',', $item['tags']) as $tagName)
                                {{ $tagName }}
                                @if (!$loop->last)
                                    ,<!-- Add comma if it's not the last tag -->
                                @endif
                            @endforeach
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <a href="/items/{{ $item['id'] }}/edit"
                                class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/items/{{ $item['id'] }}" method="POST" class="inline-block">
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
