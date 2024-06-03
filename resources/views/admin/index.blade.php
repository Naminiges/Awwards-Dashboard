<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Admin Page</h1>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Table</th>
                <th>Lihat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tables as $table)
                <tr>
                    <td>{{ $table }}</td>
                    <td>
                        <a href="{{ route('admin.showTable', $table) }}" class="btn btn-info">View Table</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>

{{-- iya? --}}