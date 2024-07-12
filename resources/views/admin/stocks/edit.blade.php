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
                    <h1 class="h3 mb-0 text-gray-800">{{ __('edit product')}}</h1>
                    <a href="{{ route('stocks.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="stock_1">{{ __('Stok 1') }}</label>
                        <input type="text" class="form-control" id="stock_1" name="stock_1" value="{{ old('stock_1', $stock->stock_1) }}" />
                    </div>
                    <div class="form-group">
                        <label for="stock_2">{{ __('Stok 2') }}</label>
                        <input type="text" class="form-control" id="stock_2" name="stock_2" value="{{ old('stock_2', $stock->stock_2) }}" />
                    </div>
                    <div class="form-group">
                        <label for="stock_3">{{ __('Stok 3') }}</label>
                        <input type="text" class="form-control" id="stock_3" name="stock_3" value="{{ old('stock_3', $stock->stock_3) }}" />
                    </div>
                    <div class="form-group">
                        <label for="stock_4">{{ __('Stok 4') }}</label>
                        <input type="text" class="form-control" id="stock_4" name="stock_4" value="{{ old('stock_4', $stock->stock_4) }}" />
                    </div>
                    <div class="form-group">
                        <label for="stock_5">{{ __('Stok 5') }}</label>
                        <input type="text" class="form-control" id="stock_5" name="stock_5" value="{{ old('stock_5', $stock->stock_5) }}" />
                    </div>
                    <div class="form-group">
                        <label for="stock_6">{{ __('Stok 6') }}</label>
                        <input type="text" class="form-control" id="stock_6" name="stock_6" value="{{ old('stock_6', $stock->stock_6) }}" />
                    </div>
                    <div class="form-group">
                        <label for="stock_7">{{ __('Stok 7') }}</label>
                        <input type="text" class="form-control" id="stock_7" name="stock_7" value="{{ old('stock_7', $stock->stock_7) }}" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save')}}</button>
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