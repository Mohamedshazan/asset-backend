<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Asset Agreement</title>
<style>
  @page {
    size: A4;
    margin: 20mm 15mm 20mm 15mm; /* top/right/bottom/left */
  }
  body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background: #fff;
  }
  .page-container {
    box-sizing: border-box;
    width: 100%;
    max-width: 210mm; /* A4 width */
    min-height: 277mm; /* A4 height minus margins */
    padding: 20mm 25mm;
    border: 1.5pt solid #000;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }
  .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
  }
  .logo {
    height: 50px;
    object-fit: contain;
  }
  .company-info {
    text-align: right;
    font-weight: 600;
    font-size: 16px;
  }
  h3 {
    margin-top: 0;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
    color: #004d00; /* Dark green for professionalism */
  }
  table {
    border-collapse: collapse;
    width: auto;
    margin: 0 0 20px auto;
    text-align: left;
    font-size: 14px;
  }
  table, th, td {
    border: 1px solid #000;
  }
  th, td {
    padding: 8px 12px;
  }
  .asset-details-container {
    text-align: right;
  }
  /* Date & Employee left aligned with double border top & bottom */
  .date-employee-container {
    text-align: left;
    border-top: 3px double #000;
    border-bottom: 3px double #000;
    padding: 12px 0;
    margin-bottom: 25px;
    font-weight: 600;
    font-size: 15px;
  }
  p {
    margin: 12px 0;
    font-size: 14px;
  }
  .signature {
    margin-top: 30px;
    font-weight: 600;
    font-size: 15px;
  }
  .note {
    margin-top: 40px;
    font-size: 12px;
    font-style: italic;
    line-height: 1.3;
    color: #555;
  }
</style>
</head>
<body>
  <div class="page-container">
    <div class="header-container">
      <img src="{{ public_path('images/logobr.jpg') }}" alt="Brandix Logo" class="logo" />
      <div class="company-info">
        Brandix Apparel Solutions Limited<br />
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

    <p class="signature">Signature: _________________________</p>

    <div class="note">
      <strong>*Note.</strong><br />
      Accessories include: Charger<br />
      Damages include: Breaking any part of the {{ $asset->asset_type ?? 'Desktop' }} or its accessories, water damage, etc.<br />
      Computer Name - {{ $asset->device_name ?? 'N/A' }}
    </div>
  </div>
</body>
</html>
