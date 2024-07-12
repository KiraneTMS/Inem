<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'id_user',
        'no_invoice',
        'ecommerce',
            'nama_pembeli',
            'tanggal_pesanan',
            'nama_produk',
            'jumlah',
            'harga_jual',
            'berat',
            'voucher_penjual',
            'voucher_ecommerce',
            'diskon_dari_penjual',
            'diskon_dari_ecommerce',
            'ongkir',
            'biaya_pengiriman',
            'biaya_asuransi',
            'kurir',
            'total_harga',

    ];

    public function get_data($id_user){
        // dd('masuk');
        return DB::table('transaksis')->where('id_user', $id_user)->get();
    }
}
