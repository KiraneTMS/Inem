<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print PDF</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {}

        .total {
            background-color: #198754;
            color: white;
            padding: 10px;
            font-weight: bold
        }

        .sub-total {
            background-color: #e0fdea;
            color: #198754;
            padding: 10px;
            font-weight: bold
        }

        .item {
            color: #198754;
            padding: 10px;
        }

        .item-name {
            margin-left: 30px
        }
    </style>

</head>

<body>
    <h2 align="center">Laporan Transaksi</h2>
    <p align="center" style="margin-bottom: 30px">Dari tanggal {{ $range_tanggal }}</p>
    <div class="total">
        <span>Total Pendapatan</span>
        <span style="float: right">Rp{{ number_format($count_harga, 0, ',', '.') }}</span>
    </div>
    <div class="sub-total">
        <span>Total Produk</span>
        <span style="float: right">Rp{{ number_format($count_harga, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Harga Asli Produk</span>
        <span style="float: right">Rp{{ number_format($count_harga, 0, ',', '.') }}</span>
    </div>
    <div class="total">
        <span>Total Pengeluaran</span>
        <span
            style="float: right">Rp{{ number_format($count_ongkir_pembeli + $count_ongkir_kekurir + $count_gratis_ongkir + $biaya_admin + $biaya_layanan + $biaya_transaksi + $pajak, 0, ',', '.') }}</span>
    </div>
    <div class="sub-total">
        <span>Total Biaya Pengiriman</span>
        <span
            style="float: right">Rp{{ number_format($count_ongkir_pembeli + $count_ongkir_kekurir + $count_gratis_ongkir, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Ongkir Dibayar Pembeli</span>
        <span style="float: right">Rp{{ number_format($count_ongkir_pembeli, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Ongkir Dari Shopee</span>
        <span style="float: right">Rp{{ number_format($count_gratis_ongkir, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Ongkir yang Diteruskan Oleh Shopee ke Jasa Kirim</span>
        <span style="float: right">Rp{{ number_format($count_ongkir_kekurir, 0, ',', '.') }}</span>
    </div>
    <div class="sub-total">
        <span>Biaya Admin & Layanan</span>
        <span
            style="float: right">Rp{{ number_format($biaya_admin + $biaya_layanan + $biaya_transaksi + $pajak, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Biaya Administrasi</span>
        <span style="float: right">Rp{{ number_format($biaya_admin, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Biaya Layanan (termasuk PPN 11%)</span>
        <span style="float: right">Rp{{ number_format($biaya_layanan, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Biaya Transaksi</span>
        <span style="float: right">Rp{{ number_format($biaya_transaksi, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span class="item-name">Bea Masuk, PPN & PPh</span>
        <span style="float: right">Rp{{ number_format($pajak, 0, ',', '.') }}</span>
    </div>
    <div class="total">
        <span>Total Penghasilan</span>
        <span
            style="float: right">Rp{{ number_format($count_harga - ($count_ongkir_pembeli + $count_ongkir_kekurir + $count_gratis_ongkir + $biaya_admin + $biaya_layanan + $biaya_transaksi + $pajak), 0, ',', '.') }}</span>
    </div>
</body>

</html>
