@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->


    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!-- Content Row -->
        <div class="card shadow">
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{ __('Tambah Data') }}</h1>
                    <a href="{{ route('prices.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('prices.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="product_id">{{ __('Nama Produk') }}</label>
                        <select name="product_id" id="product_id" class="form-control">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_code }} - "{{ $product->name }}"</option>
                            {{--  <option value="{{ $v->product->id }}">{{ $v->product->name }}</option>  --}}
                            @endforeach
                        </select>
                        <small id="kode_produk_help" class="form-text text-muted">Apabila nama produk tidak ada, harap tambahkan produk terlebih dahulu di kelola produk.</small>
                    </div>
                    <div class="form-group">
                        <label for="price_1">{{ __('Harga 1') }}</label>
                        <input type="text" class="form-control" id="price_1" name="price_1" value="{{ old('price_1') }}" />
                    </div>
                    <div class="form-group">
                        <label for="price_2">{{ __('Harga 2') }}</label>
                        <input type="text" class="form-control" id="price_2" name="price_2" value="{{ old('price_2') }}" />
                    </div>
                    <div class="form-group">
                        <label for="price_3">{{ __('Harga 3') }}</label>
                        <input type="text" class="form-control" id="price_3" name="price_3" value="{{ old('price_3') }}" />
                    </div>
                    <div class="form-group">
                        <label for="price_4">{{ __('Harga 4') }}</label>
                        <input type="text" class="form-control" id="price_4" name="price_4" value="{{ old('price_4') }}" />
                    </div>
                    <div class="form-group">
                        <label for="price_5">{{ __('Harga 5') }}</label>
                        <input type="text" class="form-control" id="price_5" name="price_5" value="{{ old('price_5') }}" />
                    </div>
                    <div class="form-group">
                        <label for="price_6">{{ __('Harga 6') }}</label>
                        <input type="text" class="form-control" id="price_6" name="price_6" value="{{ old('price_6') }}" />
                    </div>
                    <div class="form-group">
                        <label for="price_7">{{ __('Harga 7') }}</label>
                        <input type="text" class="form-control" id="price_7" name="price_7" value="{{ old('price_7') }}" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>


    <!-- Content Row -->

</div>
@endsection


@push('style-alt')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

{{--  @push('script-alt')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
    Dropzone.options.imageDropzone = {
            url: "{{ route('products.storeImage') }}",
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').find('input[name="image"]').remove()
            $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="image"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if(isset($product) && $product->image)
                var file = {!! json_encode($product->image) !!}
                    this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, "{{ $product->image->getUrl() }}")
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }
            return _results
        }
    }
</script>
@endpush  --}}
