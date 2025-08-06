<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Agreement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h1, h2, h3 { margin: 0; padding: 0; }
        .section { margin-bottom: 15px; }
    </style>
</head>
<body>

<p>Brandix Apparel Solutions Limited,<br> Batticaloa.</p>

<h3>Serial Numbers</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <td><strong>Serial No</strong></td>
        <td>{{ $asset->serial_number }}</td>
    </tr>
    <tr>
        <td><strong>Battery</strong></td>
        <td>IN BUILD</td>
    </tr>
    <tr>
        <td><strong>Charger</strong></td>
        <td>{{ $asset->charger_serial ?? 'N/A' }}</td>
    </tr>
</table>

<p><strong>Make:</strong> {{ $asset->brand }}<br>
<strong>Model:</strong> {{ $asset->model }}</p>

<p><strong>Date:</strong> {{ $date }}</p>

<p><strong>Employee Name:</strong> {{ $user->name }}</p>

<p>
I am {{ $user->name }} acknowledge receipt of a {{ ucfirst($asset->asset_type) }} 
and its accessories with a serial number of {{ $asset->serial_number }}. 
I agree to return this {{ ucfirst($asset->asset_type) }} & all of its associated 
equipment to Brandix Essentials Ltd at the time of resigning.
</p>

<p>
I am responsible for the full value of the {{ ucfirst($asset->asset_type) }} in the event 
of loss (Equipment replaceable value at the time of lost) or its accessories.
</p>

<p>
I agree to adhere to the Company's regulations and policies governing the use of the 
stated in the Brandix Essentials ICT Policy.
</p>

<br><br>
<p>____________________<br>Signature &nbsp;&nbsp;&nbsp; Date</p>

<small>
*Note: Accessories include: Charger. Damages include: Breaking any part of the 
{{ ucfirst($asset->asset_type) }} or its accessories, water damage, etc.
</small>

</body>
</html>
