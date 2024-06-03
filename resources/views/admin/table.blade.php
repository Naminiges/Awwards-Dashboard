{{-- iya?? --}}

<!DOCTYPE html>
<html>
<head>
    <title>Table View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Table: {{ $table }}</h1>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($columns as $column)
                        <td>{{ $row->$column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
