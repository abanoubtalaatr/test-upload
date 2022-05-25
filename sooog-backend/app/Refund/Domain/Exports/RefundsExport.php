<?php

namespace App\Refund\Domain\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\User\Domain\Resources\UserAddressResource;
use DB;

class RefundsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public $refund, $filter;
    public function __construct($refund, $filter)
    {
        $this->refund = $refund;
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->refund->filter($this->filter)->get();
    }

    public function map($item): array
    {
        
        return [
            $item->id,
            optional(optional($item->order)->user)->name,
            optional(optional(optional($item->order)->userAddress)->city)->name,
            $item->total,
            $item->status->name,
            optional(optional($item->order)->paymentMethod)->name,
            //optional($item->order)->created_at,
            $item->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'City',
            'Total',
            'Refund Status',
            'Payment Method',
            //'Order date',
            'Refund date'
        ];
    }
}