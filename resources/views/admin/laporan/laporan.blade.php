@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row mb-4 align-items-end">
            <div class="col-8 breadcrumbs">
                <p> <a href="/"><i class="fa fa-home"></i>home/</a> Laporan</p>
                <h3>Rincian Laporan</h3>
            </div>
            <div class="col text-right align-items-center">
                <form action="{{ route('laporan.export') }}" method="post">
                    @csrf
                    <input type="hidden" name="dari" id="exportDari"
                        value="{{ isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-d') }}">
                    <input type="hidden" name="ke" id="exportKe"
                        value="{{ isset($_GET['ke']) ? $_GET['ke'] : date('Y-m-d') }}">
                    <button class="btn btn-add" type="submit">Export to PDF</button>
                </form>
            </div>
        </div>

        <div class="card">
            
            <div class="card-body">
                <form action="{{ route('transaksis.laporan') }}" method="GET">
                    <div class="form-group row">
                        <div class="col-sm-1">
                            <label for="dari" class="mt-2">Dari</label>
                        </div>
                        <div class="col-sm-2 mb-3 mb-sm-0">
                            <input type="date" name="dari" class="form-control form-control-user" id="dari"
                                placeholder="Masukan Tanggal"
                                value="{{ isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-1">
                            <label for="ke" class="mt-2">Ke</label>
                        </div>
                        <div class="col-sm-2 mb-3 mb-sm-0">
                            <input type="date" name="ke" class="form-control form-control-user" id="ke"
                                placeholder="Masukan Tanggal"
                                value="{{ isset($_GET['dari']) ? $_GET['ke'] : date('Y-m-d') }}">
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-add float-right">Cari</button>
                        </div>
                    </div>
                </form>
                <h5 class="m-0 font-weight-bold text-success">Ringkasan Penghasilan</h5>
                <table class="table table-bordered table-striped table-hover datatable datatable-transaction"
                    cellspacing="0" width="100%">
                    <thead>
                        <tr class="bg-success">
                            <th class="d-flex justify-content-between text-white"><span>Total
                                    Pendapatan</span><span>Rp{{ number_format($count_harga, 0, ',', '.') }}</span>
                            </th>
                        </tr>
                        <tr style="background-color: #e0fdea">
                            <th class="d-flex justify-content-between text-success"><span>Total
                                    Produk</span><span>Rp{{ number_format($count_harga, 0, ',', '.') }}</span>
                            </th>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Harga Asli
                                    Produk</span><span>Rp{{ number_format($count_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr class="bg-success">
                            <th class="d-flex justify-content-between text-white"><span>Total
                                    Pengeluaran</span><span>Rp{{ number_format($count_ongkir_pembeli + $count_ongkir_kekurir + $count_gratis_ongkir + $biaya_admin + $biaya_layanan - $biaya_transaksi + $pajak, 0, ',', '.') }}</span>
                            </th>
                        </tr>
                        <tr style="background-color: #e0fdea">
                            <th class="d-flex justify-content-between text-success"><span>Total
                                    Biaya
                                    Pengiriman</span><span>Rp{{ number_format($count_ongkir_pembeli + $count_ongkir_kekurir + $count_gratis_ongkir, 0, ',', '.') }}</span>
                            </th>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Ongkir Dibayar
                                    Pembeli</span><span>Rp{{ number_format($count_ongkir_pembeli, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Ongkir Dari
                                    Shopee</span><span>Rp{{ number_format($count_gratis_ongkir, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Ongkir yang Diteruskan Oleh
                                    Shopee ke Jasa
                                    Kirim</span><span>Rp{{ number_format($count_ongkir_kekurir, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr style="background-color: #e0fdea">
                            <th class="d-flex justify-content-between text-success"><span>Biaya Admin &
                                    Layanan</span><span>Rp{{ number_format($biaya_admin + $biaya_layanan - $biaya_transaksi + $pajak, 0, ',', '.') }}</span>
                            </th>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Biaya
                                    Administrasi</span><span>Rp{{ number_format($biaya_admin, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Biaya Layanan (termasuk PPN
                                    11%)</span><span>Rp{{ number_format($biaya_layanan, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="d-flex pl-5 justify-content-between text-success">
                                <span>Premium</span><span>Rp{{ number_format(0, 0, ',', '.') }}</span>
                            </td>
                        </tr> --}}
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Biaya
                                    Transaksi</span><span>Rp{{ number_format($biaya_transaksi, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex pl-5 justify-content-between text-success"><span>Bea Masuk, PPN &
                                    PPh</span><span>Rp{{ number_format($pajak, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr class="bg-success">
                            <th class="d-flex justify-content-between text-white"><span>Total
                                    Penghasilan</span><span>Rp{{ number_format($count_harga - ($count_ongkir_pembeli + $count_ongkir_kekurir + $count_gratis_ongkir + $biaya_admin + $biaya_layanan - $biaya_transaksi + $pajak), 0, ',', '.') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Content Row -->

    </div>
@endsection

@push('script-alt')
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            let deleteButtonTrans = 'delete selected'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });
                    if (ids.length === 0) {
                        alert('zero selected')
                        return
                    }
                    if (confirm('are you sure ?')) {
                        $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'asc']
                ],
                pageLength: 50,
            });
            $('.datatable-transaksi:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

        $('#dari').on('change', function() {
            var dari = $(this).val();
            $('#exportDari').val(dari)
        });

        $('#ke').on('change', function() {
            var ke = $(this).val();
            $('#exportKe').val(ke)
        });
    </script>
@endpush

<!-- resources/views/transaksis/index.blade.php -->
