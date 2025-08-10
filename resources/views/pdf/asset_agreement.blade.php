<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Agreement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.5; }
        .header-container { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .logo { height: 45px; }
        table { border-collapse: collapse; width: auto; margin: 10px 0; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px 10px; }
    </style>
</head>
<body>

<div class="header-container">
    <img src="{{ public_path('images/logobr.jpg') }}" class="logo" alt="Logo">
    <div>
        <strong>Brandix Apparel Solutions Limited</strong><br>
        Batticaloa
    </div>
</div>

<h3>Asset Details</h3>
<table>
    <tr>
        <th>Device Name</th>
        <td>{{ $asset->device_name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Brand</th>
        <td>{{ $asset->brand ?? '-' }}</td>
    </tr>
    <tr>
        <th>Model</th>
        <td>{{ $asset->model ?? '-' }}</td>
    </tr>
    <tr>
        <th>Serial Number</th>
        <td>{{ $asset->serial_number ?? '-' }}</td>
    </tr>
</table>

<p><strong>Date:</strong> {{ $date }}</p>
<p><strong>Employee Name:</strong> {{ $user->name }}</p>

<p>
I, <strong>{{ $user->name }}</strong>, acknowledge receipt of the above-mentioned asset.  
I agree to return it, along with all accessories, upon resignation or upon request by IT.
</p>

<p>
I am responsible for the full value of the device in the event of loss or damage, as per company policy.
</p>

<p>Signature: _________________________</p>

</body>
</html>
