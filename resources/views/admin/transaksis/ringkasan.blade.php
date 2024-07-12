@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->


        <!-- Content Row -->
        <!-- resources/views/transaksis/index.blade.php -->
        <div class="row mb-4 align-items-end">
            <div class="col-8 breadcrumbs">
                <p> <a href="/"><i class="fa fa-home"></i>home/</a> ringkasan transaksi</p>
                <h3>Ringkasan Transaksi</h3>
            </div>
        </div>
        
       

        <div class="card">
            
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-dark bg-dark text-light border-0 alert-dismissible fade show" role="alert">
                        {{ $errors->first() }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="dataTable"
                        class="table table-bordered  datatable datatable-transaction"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>no_invoice</th>
                                <th>ecommerce</th>
                                <th>nama_pembeli</th>
                                <th>tanggal_pesanan</th>
                                {{-- <th>nama_produk</th> --}}
                                {{-- <th>jumlah</th>
                                <th>total_harga</th> --}}
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->no_invoice}}</td>
                                    <td>{{ $transaksi->ecommerce}}</td>
                                    <td>{{ $transaksi->nama_pembeli}}</td>
                                    <td>{{ $transaksi->tanggal_pesanan}}</td>
                                    {{-- <td>{{ $transaksi->nama_produk}}</td> --}}
                                    {{-- <td>{{ $transaksi->jumlah}}</td>
                                    <td>{{ $transaksi->total_harga}}</td> --}}
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('transaksis.show', $transaksi->no_invoice) }}" class="btn btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
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
    </script>
@endpush

<!-- resources/views/transaksis/index.blade.php -->
