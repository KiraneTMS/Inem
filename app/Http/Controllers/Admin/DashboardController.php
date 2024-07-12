<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $users = User::all()->count();
        $transaksis = Transaksi::all()->count();
        //$transaksishopee = Transaksi::DB::select("SELECT count transaksis GROUP BY ecommerce;");
        $products = Product::all()->count();
        // $transaksi_shopee = Transaksi::where('ecommerce', 'shopee')->count();
        $transaksi_shopee = DB::select("SELECT count(no_invoice) as transaksi_shopee FROM transaksis WHERE ecommerce='shopee' AND id_user=". auth()->user()->id .";");
        $transaksi_tokopedia = DB::select("SELECT count(no_invoice) as transaksi_tokopedia FROM transaksis WHERE ecommerce='tokopedia' AND id_user=". auth()->user()->id .";");
        $pendapatan = DB::select("SELECT sum(harga_jual) as pendapatan FROM transaksis  WHERE id_user=". auth()->user()->id ." ;");
        $pengeluaran = DB::select("SELECT sum(voucher_penjual + voucher_ecommerce - diskon_dari_penjual - diskon_dari_ecommerce + ongkir - biaya_pengiriman + biaya_asuransi) as pengeluaran FROM transaksis WHERE id_user=". auth()->user()->id .";");
        // return dd($total_pendapatan);
        
        return view('admin.dashboard', compact('users','transaksis','products','pendapatan','pengeluaran','transaksi_shopee','transaksi_tokopedia'));
    }
}
