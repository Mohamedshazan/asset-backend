<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Asset Agreement</title>
    <style>
@page {
    size: A4;
    margin: 2mm;
}

body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 13px; /* slightly smaller */
    line-height: 1.3;
    margin: 0;
    padding: 0;
    color: #000;
    box-sizing: border-box;
}

.container {
    border: 1px solid black;
    padding: 6mm; /* reduced padding */
    box-sizing: border-box;
    page-break-inside: avoid;
}

/* Make asset details wrapper narrower */
.asset-details-wrapper {
    width: 320px;
    margin-left: auto;
    margin-bottom: 15px;
    background-color: #fafafa;
    padding: 8px 12px;
    border-radius: 4px;
    page-break-inside: avoid;
}

.asset-details-wrapper table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 6px;
}

.asset-details-wrapper th,
.asset-details-wrapper td {
    border: 1px solid #000;
    padding: 4px 8px;
    font-size: 13px;
}

.signature-table {
    width: 70%;
    margin-top: 30px;
    border-collapse: collapse;
    text-align: center;
}

.signature-table td {
    width: 25%;
    vertical-align: top;
    padding: 0 15px;
}

.signature-table .line {
    border-bottom: 1px solid black;
    height: 1.3em;
    margin-bottom: 4px;
}

.notes {
    margin-top: 20px;
    font-size: 11px;
    font-style: italic;
    line-height: 1.2;
}

/* Reduce vertical spacing */
p {
    margin: 6px 0;
}

.double-line {
    border-top: 3px double black;
    margin: 12px 0;
}

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

        <div class="asset-details-wrapper">
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

        <table class="signature-table">
            <tr>
                <td>
                    <div class="line"></div>
                    Signature
                </td>
                <td>
                    <div class="line"></div>
                    Date
                </td>
            </tr>
        </table>

        <div class="notes">
            <strong>*Note.</strong><br>
            Accessories include: Charger<br>
            Damages include: Breaking any part of the {{ $asset->asset_type ?? 'Desktop' }} or its accessories, water damage, etc.<br>
            Computer Name - {{ $asset->device_name ?? 'N/A' }}
        </div>
    </div>
</body>

</html>



