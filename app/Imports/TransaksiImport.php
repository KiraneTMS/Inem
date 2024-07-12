<?php

namespace App\Imports;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiImport implements ToModel, WithStartRow
{

    public function model(array $row)
    {

        return new Transaksi([

            'id_user'   => auth()->user()->id,
            'no_invoice' => $row[0],
            'ecommerce' => $row[1],
            'nama_pembeli' => $row[2],
            'tanggal_pesanan' => date('Y-m-d', ($row[3] - 25569) * 86400),
            'nama_produk' => $row[4],
            'jumlah' => $row[5],
            'harga_jual' => $row[6],
            'berat' => $row[7],
            'voucher_penjual' => $row[8],
            'voucher_ecommerce' => $row[9],
            'diskon_dari_penjual' => $row[10],
            'diskon_dari_ecommerce' => $row[11],
            'ongkir' => $row[12],
            'biaya_pengiriman' => $row[13],
            'biaya_asuransi' => $row[14],
            'kurir' => $row[15],
            'total_harga' => $row[16],

        ]);
    }
    public function startRow(): int
    {
        return 2; // Mulai import dari baris ke-2
    }
}
