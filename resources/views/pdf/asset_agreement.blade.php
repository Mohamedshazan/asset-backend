<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Agreement</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 15mm 20mm 15mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            page-break-inside: avoid;
            color: #000;
        }
        .container {
            width: 100%;
            max-height: 270mm; /* fit inside A4 minus margins */
            overflow: hidden;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo {
            height: 45px;
        }
        .company-info {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
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
            text-align: left;
        }
        .double-line {
            border-top: 3px double black;
            margin: 10px 0;
        }
        .signature-section {
            margin-top: 30px;
        }
        .notes {
            margin-top: 25px;
            font-size: 12px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-container">
            <img src="{{ public_path('images/logobr.jpg') }}" class="logo" alt="Logo">
            <div class="company-info">
                Brandix Apparel Solutions Limited<br>
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

        <div class="double-line"></div>

        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>Employee Name:</strong> {{ $user->name }}</p>

        <div class="double-line"></div>

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

        <div class="signature-section">
            <p>Signature: _________________________</p>
        </div>

        <div class="notes">
            <strong>*Note.</strong><br>
            Accessories include: Charger<br>
            Damages include: Breaking any part of the {{ $asset->asset_type ?? 'Desktop' }} or its accessories, water damage, etc.<br>
            Computer Name - {{ $asset->device_name ?? 'N/A' }}
        </div>
    </div>
</body>
</html>
