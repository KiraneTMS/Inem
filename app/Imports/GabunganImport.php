<?php

namespace App\Imports;

use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;


class GabunganImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }

    // public function headingRow(): int
    // {
    //     return 1;
    // }

    public function model(array $row)
    {
        // $product = Product::with(['prices', 'stocks', 'varieties', 'zstatuses'])->where('user_id', Auth::id())->get();
        $product = Product::with(['prices', 'stocks', 'varieties', 'statuses'])->where('product_code', $row['2'])->first();

        // dd($product);

        if ($product) {
            // $product->product_code = $row['2'];
            // $product->path_foto = $row['3'];
            // $product->name = $row['4'];
            // $product->category_id = $row['5'];
            // $product->deskripsi_produk = $row['6'];
            // $product->merk = $row['7'];
            // $product->variasi = $row['8'];
            // $product->jumlah_pillihan = $row['9'];
            // $product->price = $row['10'];
            // $product->quantity = $row['11'];
            // $product->pilihan1 = $row['12'];
            // $product->pilihan2 = $row['13'];
            // $product->pilihan3 = $row['14'];
            // $product->pilihan4 = $row['15'];
            // $product->pilihan5 = $row['16'];
            // $product->pilihan6 = $row['17'];
            // $product->pilihan7 = $row['18'];
            // $product->harga1 = $row['19'];
            // $product->harga2 = $row['20'];
            // $product->harga3 = $row['21'];
            // $product->harga4 = $row['22'];
            // $product->harga5 = $row['23'];
            // $product->harga6 = $row['24'];
            // $product->harga7 = $row['25'];
            $product->stocks->stock_1 = $row['24'];
            $product->stocks->stock_2 = $row['25'];
            $product->stocks->stock_3 = $row['26'];
            $product->stocks->stock_4 = $row['27'];
            $product->stocks->stock_5 = $row['28'];
            $product->stocks->stock_6 = $row['29'];
            $product->stocks->stock_7 = $row['30'];
            // $product->berat = $row['31'];
            // $product->ongkir = $row['32'];
            $product->statuses->status = $row['33'];
            $product->save();
        }

        return $product;
    }
}
