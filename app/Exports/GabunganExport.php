<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Storage;

class GabunganExport implements FromCollection, WithMapping, ShouldAutoSize, WithEvents, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $products;
    private $excelData;
    private $excelPath;

    public function __construct($excelData, $excelPath)
    {
        $this->excelData = $excelData;
        $this->excelPath = $excelPath;
    }

    public function collection($excelData)
    {
        $spreadsheet = IOFactory::load($this->excelPath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Data baru');
        $writer = new Xlsx($spreadsheet);
        $writer->save($this->excelPath);
        return $this->excelData;
    }

    public function map($products): array
    {
        return
        [
             $products->path_photo,
             $products->product_code,
             $products->name,
             $products->category_id,
             $products->product_desc,
             $products->merk,
             $products->variety,
             $products->jumlah_pilihan,
             $products->jumlah_harga,
             $products->jumlah_stok,
             $products->varieties->option_1,
             $products->varieties->option_2,
             $products->varieties->option_3,
             $products->varieties->option_4,
             $products->varieties->option_5,
             $products->varieties->option_6,
             $products->varieties->option_7,
             $products->prices->price_1,
             $products->prices->price_2,
             $products->prices->price_3,
             $products->prices->price_4,
             $products->prices->price_5,
             $products->prices->price_6,
             $products->prices->price_7,
             $products->stocks->stock_1,
             $products->stocks->stock_2,
             $products->stocks->stock_3,
             $products->stocks->stock_4,
             $products->stocks->stock_5,
             $products->stocks->stock_6,
             $products->stocks->stock_7,
             $products->weight,
             $products->ongkir,
             $products->statuses->status,
        ];
    }

    public function registerEvents(): array
    {
        return [
            // AfterSheet::class => function (AfterSheet $event) {
            //     $event->sheet->getStyle('C2:C'.$event->sheet->getHighestRow())->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            //     $event->sheet->getStyle('D2:D'.$event->sheet->getHighestRow())->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
            // },
        ];
    }

    // public function startCell(): string
    // {
    //     return 'A2';
    // }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z999')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:Z999')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function exportData()
    {
        Excel::store($this, $this->excelPath);
    }

}
