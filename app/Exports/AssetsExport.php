
<?php



// app/Exports/AssetsExport.php

use Maatwebsite\Excel\Concerns\FromCollection;

class AssetsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Department',
            'Brand',
            'Model',
            'Device Name',
            'OS',
            'Serial Number',
            'Status',
            'Asset Type',
            'Location',
            'Assigned To',
            'Created At'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->id,
            optional($asset->department)->name,
            $asset->brand,
            $asset->model,
            $asset->device_name,
            $asset->os,
            $asset->serial_number,
            $asset->status,
            $asset->asset_type,
            $asset->location,
            optional($asset->user)->name,
            $asset->created_at->toDateString(),
        ];
    }
}
