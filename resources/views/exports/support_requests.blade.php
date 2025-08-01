<!DOCTYPE html>
<html>
<head>
    <title>Support Requests Report</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
    </style>
</head>
<body>
    <h2>Support Requests Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Issue</th>
                <th>Status</th>
                <th>Priority</th>
                <th>User</th>
                <th>Asset</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $req)
                <tr>
                    <td>{{ $req->id }}</td>
                    <td>{{ $req->issue }}</td>
                    <td>{{ $req->status }}</td>
                    <td>{{ $req->priority }}</td>
                    <td>{{ $req->user->name ?? 'N/A' }}</td>
                    <td>{{ $req->asset->device_name ?? 'N/A' }}</td>
                    <td>{{ $req->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
