@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row mb-4 align-items-end">
        <div class="col-8 breadcrumbs">
            <p> <a href="/"><i class="fa fa-home"></i> home /</a> Kelola Produk</p>
            <h3>Kelola Produk</h3>
        </div>
    </div>

    <div class="py-3 d-flex">
        <div class="ml-auto">
            <a href="{{ route('products.create') }}" class="btn btn-add">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">{{ __('Tambah Data') }}</span>
            </a>
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
                                <th>Kode Produk</th>
                                <th>Foto Produk</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Deskrip Produk</th>
                                <th>Merek</th>
                                <th>Variasi</th>
                                <th>Berat</th>
                                <th>Ongkos Kirim</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr data-entry-id="{{ $product->id }}">
                                <td>

                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->path_photo }}</td>
                                <td>{{ $product->name }}</td>
                                <td><span class="badge badge-info">{{ $product->category->name }}</span></td>
                                <td>{{ $product->product_desc }}</td>
                                <td>{{ $product->merk }}</td>
                                <td>{{ $product->variety }}</td>
                                <td>{{ $product->weight }}</td>
                                <td>{{ $product->ongkir }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form onclick="return confirm('are you sure ? ')" class="d-inline" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
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
