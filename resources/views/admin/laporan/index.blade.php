@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->
    <!-- resources/views/transaksis/index.blade.php -->

        <div class="card">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('transaksis') }}
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable datatable-transaction" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>Total Pendapatan: </td>
                            </tr>
                            <tr>
                                <td>harga Asli Produk: </td>
                            </tr>
                            <tr>
                                <td>Diskon Produk</td>
                            </tr>
                            <tr>
                                <td>Total Pengeluaran : </td>  
                            </tr>
                            <tr>
                                <td>Total Biaya Pengiriman</td>
                            </tr>
                            <tr>
                                <td>Ongkir Dibayar Pembeli</td>
                            </tr>
                            <tr>
                                <td>Gratis Ongkir dari Shopee</td>
                            </tr>
                            <tr>
                                <td>Ongkir yang Diteruskan oleh Shopee ke Jasa Kirim</td>
                            </tr>
                            <tr>
                                <td>Biaya Admin dan Layanan</td>
                            </tr>
                            <tr>
                                <td>Biaya Administrasi</td>
                            </tr>
                            <tr>
                                <td>Biaya Layanan (termasuk PPN 11%)</td>
                            </tr>
                            <tr>
                                <td>Biaya Transaksi</td>
                            </tr>
                            <tr>
                                <td>Bea Masuk, PPN & PPh</td>
                            </tr>

                            @forelse($transaksis as $transaksi)
                            
                            <tr>
                                
                                <td>{{ $transaksi->order_number }}</td>
                                <td>{{ $transaksi->ecommerce }}</td>
                                <td>{{ $transaksi->username }}</td>
                                <td>{{ $transaksi->date }}</td>
                                <td>{{ $transaksi->original_price }}</td>
                                <td>{{ $transaksi->shipping_cost }}</td>
                                <td>{{ $transaksi->free_ongkir }}</td>
                                <td>{{ $transaksi->ongkir_ke_kurir }}</td>
                                <td>{{ $transaksi->admin_cost}}</td>
                                <td>{{ $transaksi->service_cost }}</td>
                                <td>{{ $transaksi->transaction_cost }}</td>
                                <td>{{ $transaksi->tax }}</td>
                                <td>{{ $transaksi->total }}</td>
                                <td>{{ $transaksi->kurir}} </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">{{ __('Data Empty') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- Content Row -->

</div>
@endsection

@push('script-alt')
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = 'delete selected'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });
      if (ids.length === 0) {
        alert('zero selected')
        return
      }
      if (confirm('are you sure ?')) {
        $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'asc' ]],
    pageLength: 50,
  });
  $('.datatable-transaksi:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>
@endpush

<!-- resources/views/transaksis/index.blade.php -->


