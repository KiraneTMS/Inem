<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\StocksHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GabunganExport;
use App\Imports\GabunganImport;

class GabunganController extends Controller
{
    public function index()
    {
        $product = Product::with(['prices', 'stocks', 'varieties', 'statuses' ])->where('user_id', Auth::id())->get();

        foreach ($product as $products) {
            $products->jumlah_stok = $this->hitungJumlahStok($products->stocks);
            $products->jumlah_pilihan = $this->hitungJumlahPilihan($products->varieties);
            $products->jumlah_harga = $this->hitungJumlahHarga($products->prices);
        }

        return view('admin.gabungan.index', compact('product'));
    }

    private function hitungJumlahStok($stocks)
    {

        $stok1 = !is_null($stocks) && !is_null($stocks->stock_1) ? 1 : 0;
        $stok2 = !is_null($stocks) && !is_null($stocks->stock_2) ? 1 : 0;
        $stok3 = !is_null($stocks) && !is_null($stocks->stock_3) ? 1 : 0;
        $stok4 = !is_null($stocks) && !is_null($stocks->stock_4) ? 1 : 0;
        $stok5 = !is_null($stocks) && !is_null($stocks->stock_5) ? 1 : 0;
        $stok6 = !is_null($stocks) && !is_null($stocks->stock_6) ? 1 : 0;
        $stok7 = !is_null($stocks) && !is_null($stocks->stock_7) ? 1 : 0;

        return $stok1 + $stok2 + $stok3 + $stok4 + $stok5 + $stok6 + $stok7;
    }

    private function hitungJumlahPilihan($varieties)
    {
        $pilihan1 = !is_null($varieties) && !is_null($varieties->option_1) ? 1 : 0;
        $pilihan2 = !is_null($varieties) && !is_null($varieties->option_2) ? 1 : 0;
        $pilihan3 = !is_null($varieties) && !is_null($varieties->option_3) ? 1 : 0;
        $pilihan4 = !is_null($varieties) && !is_null($varieties->option_4) ? 1 : 0;
        $pilihan5 = !is_null($varieties) && !is_null($varieties->option_5) ? 1 : 0;
        $pilihan6 = !is_null($varieties) && !is_null($varieties->option_6) ? 1 : 0;
        $pilihan7 = !is_null($varieties) && !is_null($varieties->option_7) ? 1 : 0;

        return $pilihan1 + $pilihan2 + $pilihan3 + $pilihan4 + $pilihan5 + $pilihan6 + $pilihan7;
    }

    private function hitungJumlahHarga($prices)
    {
        $harga1 = !is_null($prices) && !is_null($prices->price_1) ? 1 : 0;
        $harga2 = !is_null($prices) && !is_null($prices->price_2) ? 1 : 0;
        $harga3 = !is_null($prices) && !is_null($prices->price_3) ? 1 : 0;
        $harga4 = !is_null($prices) && !is_null($prices->price_4) ? 1 : 0;
        $harga5 = !is_null($prices) && !is_null($prices->price_5) ? 1 : 0;
        $harga6 = !is_null($prices) && !is_null($prices->price_6) ? 1 : 0;
        $harga7 = !is_null($prices) && !is_null($prices->price_7) ? 1 : 0;

        return $harga1 + $harga2 + $harga3 + $harga4 + $harga5 + $harga6 + $harga7;
    }

    private $attributeMap = [
        'Foto Produk' => 'path_photo',
        'Kode Barang' => 'product_code',
        'Nama Barang' => 'name',
        'Kategori' => 'category_id',
        'Deskripsi Produk' => 'product_desc',
        'Merek' => 'merk',
        'Variasi' => 'variety',
        'Jumlah Pilihan' => 'jumlah_pilihan',
        'Jumlah Harga' => 'jumlah_harga',
        'Jumlah Stok' => 'jumlah_stok',
        'Pilihan 1' => 'varieties.option_1',
        'Pilihan 2' => 'varieties.option_2',
        'Pilihan 3' => 'varieties.option_3',
        'Pilihan 4' => 'varieties.option_4',
        'Pilihan 5' => 'varieties.option_5',
        'Pilihan 6' => 'varieties.option_6',
        'Pilihan 7' => 'varieties.option_7',
        'Harga 1' => 'prices.price_1',
        'Harga 2' => 'prices.price_2',
        'Harga 3' => 'prices.price_3',
        'Harga 4' => 'prices.price_4',
        'Harga 5' => 'prices.price_5',
        'Harga 6' => 'prices.price_6',
        'Harga 7' => 'prices.price_7',
        'Stok 1' => 'stocks.stock_1',
        'Stok 2' => 'stocks.stock_2',
        'Stok 3' => 'stocks.stock_3',
        'Stok 4' => 'stocks.stock_4',
        'Stok 5' => 'stocks.stock_5',
        'Stok 6' => 'stocks.stock_6',
        'Stok 7' => 'stocks.stock_7',
        'Berat' => 'weight',
        'Ongkos Kirim' => 'ongkir',
        'Status' => 'statuses.status'
    ];

    public function export(Request $request)
    {
        $request->validate([
            'excel' => 'required|file|mimes:xls,xlsx'
        ]);

        $excelFile = $request->file('file');
        $excelPath = $excelFile->getRealPath();
        $excelData = Excel::toArray([], $excelFile);
        $products = Product::with(['prices', 'stocks', 'varieties', 'statuses'])->where('user_id', Auth::id())->get();

        // dd($excelFile, $excelPath, $excelData, $products);

        foreach ($products as $product)
        {
            $kodeProduk = $product->product_code;

            $excelRow = $this->findExcelRowByKodeBarang($excelData, $kodeProduk);

            if ($excelRow !== null)
            {
                $isDifferent = $this->checkForDifferences($excelRow, $products);

                if ($isDifferent == true)
                {
                    $this->updateExcelRow($excelRow, $product);
                }
            }
            else
            {
                $this->insertExcelRow($excelData, $product);
            }
        }

        $export = new GabunganExport($excelData, $excelPath);
        $export->exportData();
        return response()->json(['message' => 'Export berhasil.']);
    }

    private function findExcelRowByKodeBarang($excelData, $kodeProduk)
    {
        foreach ($excelData[0] as $index => $row) {
            if ($index === 0) {
                continue;
            }
            if ($row[$this->attributeMap['Kode Barang']] === $kodeProduk) {
                return $index;
            }
        }
        return null;
    }

    private function checkForDifferences($excelRow, $product)
    {
        if ($excelRow[$this->attributeMap['Foto Produk']] !== $product->path_photo) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Nama Barang']] !== $product->name) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Kategori']] !== $product->category_id) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Deskripsi Produk']] !== $product->product_desc) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Merek']] !== $product->merk) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Variasi']] !== $product->variety) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Jumlah Pilihan']] !== $product->jumlah_pilihan) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Jumlah Harga']] !== $product->jumlah_harga) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Jumlah Stok']] !== $product->jumlah_stok) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 1']] !== $product->varieties->option_1) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 2']] !== $product->varieties->option_2) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 3']] !== $product->varieties->option_3) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 4']] !== $product->varieties->option_4) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 5']] !== $product->varieties->option_5) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 6']] !== $product->varieties->option_6) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Pilihan 7']] !== $product->varieties->option_7) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 1']] !== $product->prices->price_1) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 2']] !== $product->prices->price_2) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 3']] !== $product->prices->price_3) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 4']] !== $product->prices->price_4) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 5']] !== $product->prices->price_5) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 6']] !== $product->prices->price_6) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Harga 7']] !== $product->prices->price_7) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 1']] !== $product->stocks->stock_1) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 2']] !== $product->stocks->stock_2) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 3']] !== $product->stocks->stock_3) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 4']] !== $product->stocks->stock_4) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 5']] !== $product->stocks->stock_5) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 6']] !== $product->stocks->stock_6) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Stok 7']] !== $product->stocks->stock_7) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Berat']] !== $product->weight) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Ongkos Kirim']] !== $product->ongkir) {
            return true;
        }
        if ($excelRow[$this->attributeMap['Status']] !== $product->statuses->status) {
            return true;
        }
        return false;
    }

    private function updateExcelRow(&$excelRow, $product)
    {
        $excelRow[$this->attributeMap['Foto Produk']] = $product->path_photo;
        $excelRow[$this->attributeMap['Nama Barang']] = $product->name;
        $excelRow[$this->attributeMap['Kategori']] = $product->category_id;
        $excelRow[$this->attributeMap['Deskripsi Produk']] = $product->product_desc;
        $excelRow[$this->attributeMap['Merek']] = $product->merk;
        $excelRow[$this->attributeMap['Variasi']] = $product->variety;
        $excelRow[$this->attributeMap['Jumlah Pilihan']] = $product->jumlah_pilihan;
        $excelRow[$this->attributeMap['Jumlah Harga']] = $product->jumlah_harga;
        $excelRow[$this->attributeMap['Jumlah Stok']] = $product->jumlah_stok;
        $excelRow[$this->attributeMap['Pilihan 1']] = $product->varieties->option_1;
        $excelRow[$this->attributeMap['Pilihan 2']] = $product->varieties->option_2;
        $excelRow[$this->attributeMap['Pilihan 3']] = $product->varieties->option_3;
        $excelRow[$this->attributeMap['Pilihan 4']] = $product->varieties->option_4;
        $excelRow[$this->attributeMap['Pilihan 5']] = $product->varieties->option_5;
        $excelRow[$this->attributeMap['Pilihan 6']] = $product->varieties->option_6;
        $excelRow[$this->attributeMap['Pilihan 7']] = $product->varieties->option_7;
        $excelRow[$this->attributeMap['Harga 1']] = $product->prices->price_1;
        $excelRow[$this->attributeMap['Harga 2']] = $product->prices->price_2;
        $excelRow[$this->attributeMap['Harga 3']] = $product->prices->price_3;
        $excelRow[$this->attributeMap['Harga 4']] = $product->prices->price_4;
        $excelRow[$this->attributeMap['Harga 5']] = $product->prices->price_5;
        $excelRow[$this->attributeMap['Harga 6']] = $product->prices->price_6;
        $excelRow[$this->attributeMap['Harga 7']] = $product->prices->price_7;
        $excelRow[$this->attributeMap['Stok 1']] = $product->stocks->stock_1;
        $excelRow[$this->attributeMap['Stok 2']] = $product->stocks->stock_2;
        $excelRow[$this->attributeMap['Stok 3']] = $product->stocks->stock_3;
        $excelRow[$this->attributeMap['Stok 4']] = $product->stocks->stock_4;
        $excelRow[$this->attributeMap['Stok 5']] = $product->stocks->stock_5;
        $excelRow[$this->attributeMap['Stok 6']] = $product->stocks->stock_6;
        $excelRow[$this->attributeMap['Stok 7']] = $product->stocks->stock_7;
        $excelRow[$this->attributeMap['Berat']] = $product->weight;
        $excelRow[$this->attributeMap['Ongkos Kirim']] = $product->ongkir;
        $excelRow[$this->attributeMap['Status']] = $product->statuses->status;
    }

    private function insertExcelRow(&$excelData, $product)
    {
        $newRow = [
            $this->attributeMap['Foto Produk']  => $product->path_photo,
            $this->attributeMap['Kode Produk']  => $product->product_code,
            $this->attributeMap['Nama Barang']  => $product->name,
            $this->attributeMap['Kategori']  => $product->category_id,
            $this->attributeMap['Deskripsi Produk']  => $product->product_desc,
            $this->attributeMap['Merek']  => $product->merk,
            $this->attributeMap['Variasi']  => $product->variety,
            $this->attributeMap['Jumlah Pilihan']  => $product->jumlah_pilihan,
            $this->attributeMap['Jumlah Harga']  => $product->jumlah_harga,
            $this->attributeMap['Jumlah Stok']  => $product->jumlah_stok,
            $this->attributeMap['Pilihan 1']  => $product->varieties->option_1,
            $this->attributeMap['Pilihan 2']  => $product->varieties->option_2,
            $this->attributeMap['Pilihan 3']  => $product->varieties->option_3,
            $this->attributeMap['Pilihan 4']  => $product->varieties->option_4,
            $this->attributeMap['Pilihan 5']  => $product->varieties->option_5,
            $this->attributeMap['Pilihan 6']  => $product->varieties->option_6,
            $this->attributeMap['Pilihan 7']  => $product->varieties->option_7,
            $this->attributeMap['Harga 1']  => $product->prices->price_1,
            $this->attributeMap['Harga 2']  => $product->prices->price_2,
            $this->attributeMap['Harga 3']  => $product->prices->price_3,
            $this->attributeMap['Harga 4']  => $product->prices->price_4,
            $this->attributeMap['Harga 5']  => $product->prices->price_5,
            $this->attributeMap['Harga 6']  => $product->prices->price_6,
            $this->attributeMap['Harga 7']  => $product->prices->price_7,
            $this->attributeMap['Stok 1']  => $product->stocks->stock_1,
            $this->attributeMap['Stok 2']  => $product->stocks->stock_2,
            $this->attributeMap['Stok 3']  => $product->stocks->stock_3,
            $this->attributeMap['Stok 4']  => $product->stocks->stock_4,
            $this->attributeMap['Stok 5']  => $product->stocks->stock_5,
            $this->attributeMap['Stok 6']  => $product->stocks->stock_6,
            $this->attributeMap['Stok 7']  => $product->stocks->stock_7,
            $this->attributeMap['Berat']  => $product->weight,
            $this->attributeMap['Ongkos Kirim']  => $product->ongkir,
            $this->attributeMap['Status']  => $product->statuses->status,
        ];

        $excelData[] = $newRow;
    }

    public function importUpdate(Request $request, Product $product, Stock $stock)
    {
        $file = $request->file('file');
        $path = $file->getRealPath();
        $excelData = Excel::toArray([], $file);

        // dd($file, $path, $excelData);

        // buat catet perubahan ke tabel histori produk
        $oldStockValues = $stock->getOriginal();

        Excel::import(new GabunganImport, $path);

        $product = Product::findOrFail($stock->product_id);
        $atributStokBerubah = array_keys($stock->getChanges());

        // buat catet perubahan ke tabel histori produk
        foreach ($atributStokBerubah as $atribut) {
            $oldValue = $oldStockValues[$atribut];
            $newValue = $stock->$atribut;

            StocksHistory::create([
                'stock_id' => $stock->id,
                'user_id' => auth()->user()->id,
                'product_id' => $stock->product_id,
                'product_name' => $product->name,
                'jenis_stock' => $atribut,
                'old_stock' => $oldValue,
                'new_stock' => $newValue,
                'selisih_stock' => $newValue - $oldValue,
                'jenis_pemakaian' => 'pengurangan dari penjualan',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'successfully updated via import',
            'alert-type' => 'success'
        ]);
    }
}
