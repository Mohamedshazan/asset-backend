<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SupportRequestsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $requests;

    public function __construct($requests)
    {
        $this->requests = $requests;
    }

    public function collection()
    {
        return $this->requests;
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Department',
            'Asset',
            'Issue',
            'Priority',
            'Status',
            'Created At',
        ];
    }

    public function map($request): array
    {
        return [
            $request->id,
            optional($request->user)->name,
            optional($request->user?->department)->name,
            optional($request->asset)->device_name,
            $request->issue,
            $request->priority,
            $request->status,
            $request->created_at->toDateString(),
        ];
    }
}
