<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Archive</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>Content Archive</h2>

    <table>
        <thead>
            <tr>
                <th>Content Posted</th>
                <th>Content Path</th>
                <th>Caption</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($archive as $item)
                <tr>
                    <td><img src="{{ public_path('storage/' . $item['file_path']) }}" width="50"></td>
                    <td>{{ $item['file_path'] }}</td>
                    <td>{{ $item['caption'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
