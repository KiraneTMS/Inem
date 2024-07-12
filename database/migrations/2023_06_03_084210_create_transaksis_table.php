<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable();
            $table->string('no_invoice')->nullable();
            $table->string('ecommerce');
            $table->string('nama_pembeli');
            $table->date('tanggal_pesanan');
            $table->string('nama_produk');
            $table->decimal('jumlah', 8, 2);
            $table->decimal('harga_jual', 8, 2);
            $table->string('berat');
            $table->decimal('voucher_penjual', 8, 2);
            $table->decimal('voucher_ecommerce', 8, 2);
            $table->decimal('diskon_dari_penjual', 8, 2);
            $table->decimal('diskon_dari_ecommerce', 8, 2);
            $table->decimal('ongkir', 8, 2);
            $table->decimal('biaya_pengiriman', 8, 2);
            $table->decimal('biaya_asuransi', 8, 2);
            $table->string('kurir');
            $table->decimal('total_harga', 8, 2);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
