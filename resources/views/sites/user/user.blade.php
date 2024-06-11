<!DOCTYPE html>
<html>

<head>
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="mt-4 mb-4">
            <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go to
                Homepage</a>
            <a href="{{ route('users.create') }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add New User Design</a>
        </div>
        <h1 class="text-3xl font-bold mb-8">Users</h1>
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
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Display Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $user['id'] }}</td>
                        <td class="border px-4 py-2">{{ $user['username'] }}</td>
                        <td class="border px-4 py-2">{{ $user['display_name'] }}</td>
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('users.edit', $user['id']) }}"
                                class="text-yellow-500 hover:text-yellow-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user['id']) }}" method="POST"
                                class="inline-block" onsubmit="return confirmDelete()" id="delete-user-form">
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
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>
</html>
