@component('mail::message')
# Asset Agreement

Hello {{ $user->name }},

Please find attached the Asset Agreement PDF for your asset:

**Device Name:** {{ $asset->device_name ?? '-' }}  
**Model:** {{ $asset->model ?? '-' }}  
**Serial Number:** {{ $asset->serial_number ?? '-' }}

If you have any questions, please contact IT support.

Thanks,  
{{ config('app.name') }}
@endcomponent
