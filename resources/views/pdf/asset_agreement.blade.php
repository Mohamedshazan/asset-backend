<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Agreement</title>
    <style>
       @page {
    size: A4;
    margin: 1mm; /* equal margin all sides */
}
body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 14px;
    line-height: 1.4;
    margin: 0;
    padding: 0;
    color: #000;
    box-sizing: border-box;
}
*, *:before, *:after {
    box-sizing: inherit;
}

.container {
    max-width: 190mm; /* closer to full A4 width (210mm) minus @page margins */
    margin: 5mm auto; /* reduce vertical margin */
    padding: 3mm; /* less padding inside the border */
    border: 1px solid black;
    box-sizing: border-box;
    overflow: hidden;
    page-break-inside: avoid;
}


.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.logo {
    height: 70px;
    width: auto;
    object-fit: contain;
    margin-top: 8px; /* Adjust this value as needed */
}


.company-info {
    text-align: right;
    font-weight: 700;
    font-size: 16px;
    line-height: 1.2;
}

.asset-details-wrapper {
    width: 360px;
    /* float: right;  <-- Remove float */
    margin-left: auto; /* Push to right with margin-left auto */
    margin-bottom: 20px;
    background-color: #fafafa;
    padding: 10px 15px;
    border-radius: 4px;
    box-sizing: border-box;
    clear: both;
}

/* ... rest unchanged */


        /* Table styles */
        .asset-details-wrapper table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px 0 0 0;
        }
        .asset-details-wrapper th,
        .asset-details-wrapper td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
            vertical-align: middle;
        }
        .asset-details-wrapper th {
            background-color: #f2f2f2;
            width: 40%;
            font-weight: 600;
        }

       /* Double line separator */
.double-line {
    border-top: 3px double black;
    margin: 15px 0 15px 0;
    clear: both;
}

p {
    margin: 8px 0;
}

/* Updated signature section */
.signature-section {
    margin-top: 30px;
    clear: both;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    max-width: 400px;
}

.signature-section > div {
    width: 45%;
    text-align: center;
}

.signature-section .line {
    border-bottom: 1px solid black;
    height: 1.5em;
    margin-bottom: 5px;
}

/* Label under the line */
.signature-section .label {
    font-weight: normal;
    font-size: 14px;
}

/* Notes */
.notes {
    margin-top: 25px;
    font-size: 12px;
    font-style: italic;
    clear: both;
    line-height: 1.3;
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

      <div class="signature-section">
  <div>
    <div class="line"></div>
    <div class="label">Signature</div>
  </div>
  <div>
    <div class="line"></div>
    <div class="label">Date</div>
  </div>
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









