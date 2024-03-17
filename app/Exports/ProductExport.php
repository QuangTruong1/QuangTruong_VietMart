<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ProductExport implements FromArray, WithEvents, WithColumnWidths, WithHeadings
{
    // public function collection()
    // {
    //     return Product::with('Product_category', 'Status', 'Status_censorship')->get();
    // }  
    // public function map($row): array
    // {
    //     return [
    //         $row->name,
    //         $row->content,
    //         $row->description,
    //         $row->price,                                  
    //         $row->Status->name_status,           
    //         $row->Status_censorship->name_censorship,           
    //         $row->Product_category->cat_name,           
    //     ];
    // }
    public function array(): array
    {
        $products = Product::with('Product_category', 'Status', 'Status_censorship')->get();

        $data = [];

        foreach ($products as $row) {
            $data[] = [
                $row->name,
                $row->content,
                $row->description,
                $row->price,
                $row->Status->name_status,
                $row->Status_censorship->name_censorship,
                $row->Product_category->cat_name,
            ];
        }

        return $data;
    }

    public function map($row): array
    {
        return $row;
    }

    public function headings(): array
    {
        return [
            'Tên sản phẩm',
            'Mô tả',
            'Chi tiết sản phẩm',
            'Giá',                     
            'Tình trạng',
            'Kiểm duyệt',
            'Loại sản phẩm'   
        ];
    }  

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 15,        
            'E' => 15,        
            'F' => 15,        
            'G' => 30,        
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:B1';
                $color = '93ccea';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($color);
            }
        ];
    }  
}

