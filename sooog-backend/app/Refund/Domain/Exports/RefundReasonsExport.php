<?php

namespace App\Refund\Domain\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\User\Domain\Resources\UserAddressResource;
use DB;

class RefundReasonsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public $reason, $filter;
    public function __construct($reason, $filter)
    {
        $this->reason = $reason;
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->reason->filter($this->filter)->get();
    }

    public function map($item): array
    {
        return [
            $item->name,
            $item->status == 1 ? 'Active' : 'inactive',
            $item->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Status',
            'Creating Date',
        ];
    }
}