<?php

namespace App\Exports;

use App\Models\Accessary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AccessaryExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Accessary::with('supplier')->get();
    }

    /**
     * Returns headers for report
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tên phụ tùng',
            'Giá',
            'Số lượng nhập',
            "Số lượng xuất",
            "Số lượng tồn",
            "Mức min",
            "Nhà cung cấp",
            "Ngày tạo",
        ];
    }

    public function map($accessary): array
    {
        return [
            $accessary->name,
            number_format($accessary->price, 0, '', '.') . ' VNĐ',
            number_format($accessary->quantityImport, 0, '', '.'),
            number_format($accessary->quantityExport, 0, '', '.'),
            number_format($accessary->quantityStock, 0, '', '.'),
            number_format($accessary->quantityMin, 0, '', '.'),
            $accessary->supplier->name,
            date_format($accessary->created_at, 'd/m/Y'),
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                /* Set with for sheet excel */
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);
            },
        ];
    }
}
