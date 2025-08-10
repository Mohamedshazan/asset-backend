@component('mail::message')
# Asset Agreement

Hello {{ $user->name }},

Please find attached the **Asset Assignment Agreement** for your allocated device:
In this mail I have attached the Device as PDF format. Read the agreement and send your accept mail

- **Device Name:** {{ $asset->device_name ?? '-' }}  
- **Model:** {{ $asset->model ?? '-' }}  
- **Serial Number:** {{ $asset->serial_number ?? '-' }}

If you have any questions or need assistance, please contact **IT Support**.

Thanks,  
{{ config('app.name') }}

@endcomponent
