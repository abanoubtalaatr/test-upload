<?php

namespace App\RequestOfferQuantity\Domain\Exports;

use App\Product\Domain\Models\Product;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RequestOfferQuantityExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $categories = Product::where('store_id', auth()->guard('store')->user()->store->id)
            ->pluck('category_id')
            ->toArray();

        return RequestOfferQuantity::whereIn('category_id', $categories)->where('status','pending')->get();
    }

    public function map($item): array
    {
        $itemData = [
            $item->id,
            $item->product_name,
            $item->category->name,
            $item->details,
            $item->status,
            $item->created_at->format('Y-m-d'),
        ];

        return $itemData;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product',
            'Category',
            'Details',
            'Status',
            'Created Date'
        ];
    }
}
