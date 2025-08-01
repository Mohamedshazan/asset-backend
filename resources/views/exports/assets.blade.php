<!DOCTYPE html>
<html>
<head>
    <title>Assets Report</title>
</head>
<body>
    <h2>Assets Report</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Asset Type</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Device Name</th>
                <th>Serial No</th>
                <th>Status</th>
                <th>Location</th>
                <th>Department</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($assets as $asset)
            <tr>
                <td>{{ $asset->id }}</td>
                <td>{{ $asset->asset_type }}</td>
                <td>{{ $asset->brand }}</td>
                <td>{{ $asset->model }}</td>
                <td>{{ $asset->device_name }}</td>
                <td>{{ $asset->serial_number }}</td>
                <td>{{ $asset->status }}</td>
                <td>{{ $asset->location }}</td>
                <td>{{ $asset->department->name ?? 'N/A' }}</td>
                <td>{{ $asset->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
