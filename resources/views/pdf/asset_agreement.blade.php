<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Agreement</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 14px; 
            line-height: 1.5; 
            margin: 20px;
            background: #fff;
        }
        .container {
            border: 1px solid black;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo {
            height: 45px;
            flex-shrink: 0;
        }
        .company-info {
            text-align: right;
            flex-grow: 1;
        }
        .asset-details-container {
            text-align: right;
            margin-bottom: 20px;
        }
        table { 
            border-collapse: collapse; 
            width: auto; 
            margin: 10px 0; 
        }
        table, th, td { 
            border: 1px solid black; 
        }
        th, td { 
            padding: 6px 10px; 
        }
        /* Right align the table */
        .asset-details-container table {
            margin-left: auto;
            margin-right: 0;
        }
        .note {
            margin-top: 20px; 
            font-size: 12px; 
            font-style: italic;
        }
        .date-employee-container {
            text-align: left; 
            border-top: 3px double black; 
            border-bottom: 3px double black; 
            padding: 10px 0; 
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-container">
        <img src="{{ public_path('images/logobr.jpg') }}" class="logo" alt="Logo">
        <div class="company-info">
            <strong>Brandix Apparel Solutions Limited</strong><br>
            Batticaloa
        </div>
    </div>

    <div class="asset-details-container">
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
    </div>

    <div class="date-employee-container">
        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>Employee Name:</strong> {{ $user->name }}</p>
    </div>

    <p>
    I, <strong>{{ $user->name }}</strong>, acknowledge receipt of a <strong>{{ $asset->asset_type ?? 'Desktop' }}</strong> and its accessories with serial number <strong>{{ $asset->serial_number }}</strong>.  
    I agree to return this <strong>{{ $asset->asset_type ?? 'Desktop' }}</strong> and all associated equipment to Brandix Essentials Ltd upon resignation or when requested by IT.
    </p>

    <p>
    I accept full responsibility for the replacement value of the <strong>{{ $asset->asset_type ?? 'Desktop' }}</strong> and its accessories in the event of loss or damage, as outlined in the Brandix Essentials ICT Policy.
    </p>

    <p>
    I agree to adhere to all company regulations and policies governing the use of this equipment as stated in the Brandix Essentials ICT Policy.
    </p>

    <p>Signature: _________________________</p>

    <div class="note">
        <strong>*Note.</strong><br>
        Accessories include: Charger<br>
        Damages include: Breaking any part of the {{ $asset->asset_type ?? 'Desktop' }} or its accessories, water damage, etc.<br>
        Computer Name - {{ $asset->device_name ?? 'N/A' }}
    </div>
</div>

</body>
</html>
