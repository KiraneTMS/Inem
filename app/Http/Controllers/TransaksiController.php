<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransaksiImport;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{

    private $Transaksi;

    public function __construct(){
        $this->Transaksi = new Transaksi;
    }
    
    public function index()
    {
        $transaksis = $this->Transaksi->get_data(auth()->user()->id);
        // $transaksis = Transaksi::where('id_user', auth()->user()->id);
        // $transaksi = Transaksi::where('ecommerce', 'shopee')->sum('original_price');
        return view('admin.transaksis.index', compact('transaksis'));
    }


    // Method lain seperti create, store, edit, update, destroy, dll.
    public function import()
    {
        // if (!Session()->get('email')) {
        //     return redirect()->route('login');
        // }

        $file = Request()->file('file');

        Excel::import(new TransaksiImport, $file);

        return redirect()->back()->with('berhasil', 'Data berhasil diimport !');
    }

    public function show($no_invoice)
    {
        $transaksis = Transaksi::where('no_invoice',$no_invoice)->get();
        return view('admin.transaksis.show', compact('transaksis'));
    }

    public function penghasilan()
    {
        $transaksis = DB::select("SELECT sum(harga_jual) as pendapatan, ecommerce, sum(voucher_penjual + voucher_ecommerce - diskon_dari_penjual - diskon_dari_ecommerce + ongkir - biaya_pengiriman + biaya_asuransi) as pengeluaran FROM transaksis WHERE ". auth()->user()->id ." GROUP BY ecommerce;"); 
        $total = DB::select("SELECT sum(harga_jual) + sum(voucher_penjual + voucher_ecommerce - diskon_dari_penjual - diskon_dari_ecommerce + ongkir - biaya_pengiriman + biaya_asuransi) as total FROM transaksis WHERE id_user=".auth()->user()->id .";");
        $penghasilan_shopee = DB::select("SELECT sum(harga_jual) as penghasilan_shopee FROM transaksis WHERE ecommerce='shopee' AND id_user=". auth()->user()->id .";");
        $total_shopee = DB::select("SELECT sum(harga_jual) + sum(voucher_penjual + voucher_ecommerce - diskon_dari_penjual - diskon_dari_ecommerce + ongkir - biaya_pengiriman + biaya_asuransi) as total_shopee FROM transaksis WHERE ecommerce='shopee' AND id_user=". auth()->user()->id .";");
        $total_tokopedia = DB::select("SELECT sum(harga_jual) + sum(voucher_penjual + voucher_ecommerce - diskon_dari_penjual - diskon_dari_ecommerce + ongkir - biaya_pengiriman + biaya_asuransi) as total_tokopedia FROM transaksis WHERE ecommerce='tokopedia' AND id_user=". auth()->user()->id .";");
        $penghasilan_tokopedia = DB::select("SELECT sum(harga_jual) as penghasilan_tokopedia FROM transaksis WHERE ecommerce='tokopedia' AND id_user= ". auth()->user()->id .";");
        // return dd($total_pendapatan);
        return view('admin.penghasilan', compact('transaksis','total','penghasilan_shopee','penghasilan_tokopedia','total_shopee','total_tokopedia'));

    }

    public function ringkasan()
    {
    $transaksis = Transaksi::select('no_invoice', 'nama_pembeli', 'ecommerce', 'tanggal_pesanan')
    ->groupBy('no_invoice', 'nama_pembeli', 'ecommerce', 'tanggal_pesanan')
    ->distinct('no_invoice')
    ->where('id_user', '=', auth()->user()->id)
    ->get();
        return view('admin.transaksis.ringkasan', compact('transaksis'));
    }
    
    public function laporan()
    {
        // $transaksis = Transaksi::all();
        if (Request()->dari != null && Request()->ke != null) {
            $range = [Request()->dari, Request()->ke];
        } else {
            $range = [date('Y-m-d'), date('Y-m-d')];
        }
        $data = [
            'count_harga'           => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('harga_jual'),
            'count_ongkir_pembeli'  => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('voucher_penjual'),
            'count_gratis_ongkir'   => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('voucher_ecommerce'),
            'count_ongkir_kekurir'  => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('diskon_dari_penjual'),
            'biaya_admin'           => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('diskon_dari_ecommerce'),
            'biaya_layanan'         => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('ongkir'),
            'biaya_transaksi'       => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('biaya_pengiriman'),
            'pajak'                 => Transaksi::whereBetween('tanggal_pesanan', $range)->where('id_user', '=', auth()->user()->id)->sum('biaya_asuransi'),
        ];
        return view('admin.laporan.laporan', $data);
    }
}
