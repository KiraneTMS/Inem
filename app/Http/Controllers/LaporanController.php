<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    
    public function index()
    {
        $transaksis = Transaksi::all()->get_data(auth()->user()->id);
        return view('admin.laporan.index', compact('transaksis'));
    }

    public function export_laporan(Request $request)
    {
        if (Request()->dari != null && Request()->ke != null) {
            $range = [Request()->dari, Request()->ke];
        } else {
            $range = [date('Y-m-d'), date('Y-m-d')];
        }
        $data = [
            'count_harga'           => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('harga_jual'),
            'count_ongkir_pembeli'  => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('voucher_penjual'),
            'count_gratis_ongkir'   => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('voucher_ecommerce'),
            'count_ongkir_kekurir'  => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('diskon_dari_penjual'),
            'biaya_admin'           => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('diskon_dari_ecommerce'),
            'biaya_layanan'         => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('ongkir'),
            'biaya_transaksi'       => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('biaya_pengiriman'),
            'pajak'                 => Transaksi::whereBetween('tanggal_pesanan', $range)->distinct('no_invoice')->sum('biaya_asuransi'),
            'range_tanggal'         => date('d F Y', strtotime(Request()->dari)) . ' - ' . date('d F Y', strtotime(Request()->ke)),
        ];
        $pdf = PDF::loadView('admin.laporan.cetak_pdf', $data)
            ->setPaper('a4', 'portrait')->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => TRUE, 'enable_javascript' => TRUE]);

        $nama_tgl = date('d/F/Y', strtotime(Request()->dari)) . '-' . date('d/F/Y', strtotime(Request()->ke));
        return $pdf->download('LaporanTransaksi-' . $nama_tgl . '.pdf');
        // return view('admin.laporan.cetak_pdf', $data);
    }
}
