<?php

namespace App\PromoCode\Domain\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;


class PromoCodesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public $promo_code, $filter;
    public function __construct($promo_code, $filter)
    {
        $this->promo_code = $promo_code;
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->promo_code->filter($this->filter)->get();
    }

    public function map($item): array
    {
        $active = $item->is_active == 1 ? 'Active' : 'Inactive';
        return [
            $item->code,
            $item->name,
            $item->type,
            // $item->value,
            // $item->start_date,
            // $item->end_date,
            $active,
            $item->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return [
            'Promo Code',
            'Name',
            'Type',
            // 'Value',
            // 'Start date',
            // 'End date',
            'Status',
            'Creating Date',
        ];
    }
}