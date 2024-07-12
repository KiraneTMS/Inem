@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row mb-4 align-items-end">
        <div class="col-8 breadcrumbs">
            <p> <a href="/"><i class="fa fa-home"></i> home /</a> List Produk</p>
            <h3>List Produk</h3>
        </div>
    </div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Ekspor Data ke Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('gabungan.export') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="excelFile">Pilih File Excel:</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xls,.xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Impor</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Via Import -->
<div class="modal fade" id="importUpdateModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Select File Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('gabungan.importUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="excelFile">Pilih File Excel:</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xls,.xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Impor</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Content Row -->
        <div class="card">
            <a class="btn btn-add" data-toggle="modal" data-target="#exportModal">
                <span class="icon text-white-50">
                    <i class="fa fa-file-excel"></i>
                </span>
                <span class="text">{{ __('Export Data ke Excel') }}</span>
            </a>
            <br>
            <a class="btn btn-add" data-toggle="modal" data-target="#importUpdateModal">
                <span class="icon text-white-50">
                    <i class="fa fa-file-excel"></i>
                </span>
                <span class="text">{{ __('Update Via Import Excel') }}</span>
            </a>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable datatable-product" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th>No</th>
                                <th>Foto Produk</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Deksripsi Produk</th>
                                <th>Merek</th>
                                <th>Variasi</th>
                                <th>Jumlah Pilihan</th>
                                <th>Jumlah Harga</th>
                                <th>Jumlah Stok</th>
                                <th>Pilihan 1</th>
                                <th>Pilihan 2</th>
                                <th>Pilihan 3</th>
                                <th>Pilihan 4</th>
                                <th>Pilihan 5</th>
                                <th>Pilihan 6</th>
                                <th>Pilihan 7</th>
                                <th>Harga 1</th>
                                <th>Harga 2</th>
                                <th>Harga 3</th>
                                <th>Harga 4</th>
                                <th>Harga 5</th>
                                <th>Harga 6</th>
                                <th>Harga 7</th>
                                <th>Stok 1</th>
                                <th>Stok 2</th>
                                <th>Stok 3</th>
                                <th>Stok 4</th>
                                <th>Stok 5</th>
                                <th>Stok 6</th>
                                <th>Stok 7</th>
                                <th>Berat</th>
                                <th>Ongkos Kirim</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product as $p)
                            <tr data-entry-id="{{ $p->id }}">
                                <td>

                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->path_photo }}</td>
                                <td>{{ $p->product_code }}</td>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->category->id }}</td>
                                <td>{{ $p->product_desc }}</td>
                                <td>{{ $p->merk }}</td>
                                <td>{{ $p->variety }}</td>
                                <td>{{ $p->jumlah_pilihan }}</td>
                                <td>{{ $p->jumlah_harga }}</td>
                                <td>{{ $p->jumlah_stok }}</td>
                                <td>{{ $p->varieties->option_1 ?? '' }}</td>
                                <td>{{ $p->varieties->option_2 ?? ''  }}</td>
                                <td>{{ $p->varieties->option_3 ?? ''  }}</td>
                                <td>{{ $p->varieties->option_4 ?? '' }}</td>
                                <td>{{ $p->varieties->option_5 ?? '' }}</td>
                                <td>{{ $p->varieties->option_6 ?? '' }}</td>
                                <td>{{ $p->varieties->option_7 ?? '' }}</td>
                                <td>{{ $p->prices->price_1 ?? '' }}</td>
                                <td>{{ $p->prices->price_2 ?? '' }}</td>
                                <td>{{ $p->prices->price_3 ?? '' }}</td>
                                <td>{{ $p->prices->price_4 ?? '' }}</td>
                                <td>{{ $p->prices->price_5 ?? '' }}</td>
                                <td>{{ $p->prices->price_6 ?? '' }}</td>
                                <td>{{ $p->prices->price_7 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_1 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_2 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_3 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_4 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_5 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_6 ?? '' }}</td>
                                <td>{{ $p->stocks->stock_7 ?? '' }}</td>
                                <td>{{ $p->weight }}</td>
                                <td>{{ $p->ongkir }}</td>
                                <td>{{ $p->statuses->status }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="34" class="text-center">{{ __('Data Empty') }}</td>
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
