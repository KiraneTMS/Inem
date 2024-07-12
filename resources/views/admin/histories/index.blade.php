@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row mb-4 align-items-end">
        <div class="col-8 breadcrumbs">
            <p> <a href="/"><i class="fa fa-home"></i> home /</a> Kelola Harga</p>
            <h3>Histori Perubahan Stok</h3>
        </div>
    </div>

    <!-- Content Row -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable datatable-product" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jenis Stok</th>
                                <th>Stok Dulu</th>
                                <th>Selisih</th>
                                <th>Stok Baru</th>
                                <th>Jenis Pemakaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histories as $history)
                            <tr data-entry-id="{{ $history->id }}">
                                <td>

                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $history->product->name }}</td>
                                <td>{{ $history->jenis_stock }}</td>
                                <td>{{ $history->old_stock }}</td>
                                <td>{{ $history->selisih_stock }}</td>
                                <td>{{ $history->new_stock }}</td>
                                <td>{{ $history->jenis_pemakaian }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">{{ __('Data Empty') }}</td>
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
    url: "{{ route('products.mass_destroy') }}",
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
//   dtButtons.push(deleteButton)
//   $.extend(true, $.fn.dataTable.defaults, {
//     order: [[ 1, 'asc' ]],
//     pageLength: 50,
//   });
  $('.datatable-product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})
</script>
@endpush
