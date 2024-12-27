@extends('layout.app')
@section('body')
    <style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"><link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />.error {
            color: #FF0000;
        }
    </style>

    <body>
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">Add<span class="font-weight-normal text-muted ml-2">Stock</span></h4>
            </div>
        </div>
        <div class="container" role="document">
            <form method="POST" id="stockForm">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="stock-items">
                            <div class="stock-item-row">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Store</label>
                                            <select class="form-control @error('store_id') is-invalid @enderror"
                                                name="store_id[]" id="store_id_1">
                                                <option value="" selected disabled>Select Store</option>
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}"
                                                        {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                                        {{ $store->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="store_id_1"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Item Name</label>
                                            <input type="text"
                                                class="form-control @error('item_name.*') is-invalid @enderror"
                                                name="item_name[]" placeholder="Item Name" id="item_name_1"
                                                value="{{ old('item_name.0') }}">
                                            <small class="text-danger" id="item_name_1"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Quantity</label>
                                            <input type="number"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                name="quantity[]" placeholder="Quantity" id="quantity_1">
                                            <small class="text-danger" id="quantity_1"></small>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Location</label>
                                            <input type="text"
                                                class="form-control @error('location') is-invalid @enderror"
                                                name="location[]" placeholder="Location" id="location_1">
                                            <small class="text-danger" id="location_1"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Stock No</label>
                                            <input type="text"
                                                class="form-control @error('stock_no') is-invalid @enderror"
                                                name="stock_no[]" placeholder="Stock No" id="stock_no_1">
                                            <small class="text-danger" id="stock_no_1"></small>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Item Code</label>
                                            <input type="text"
                                                class="form-control @error('item_code') is-invalid @enderror"
                                                name="item_code[]" placeholder="Item Code" id="item_code_1">
                                            <small class="text-danger" id="item_code_1"></small>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">In Stock Date</label>
                                            <input type="date"
                                                class="form-control @error('in_stock_date') is-invalid @enderror"
                                                name="in_stock_date[]" value="{{ old('in_stock_date') }}"
                                                id="in_stock_date_1">
                                            <small class="text-danger" id="in_stock_date_1"></small>

                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger removeRowBtn"
                                    style="display:none;">Remove</button>
                                <hr>
                            </div>
                        </div>
                        <div class="text-right mt-4">
                            <button class="btn btn-primary" type="button" id="addMoreBtn">Add More</button>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script src="{{ asset('assets') }}/admin/plugins/js-validation/jquery.validate.min.js"></script>
        {{-- <script src="{{ asset('assets') }}/stock/create-stock.js"></script> --}}

        <script>
            $(document).ready(function() {
                let i = 1;
                $('#addMoreBtn').click(function() {
                    i++;
                    let newRow = `
        <div class="stock-item-row">
            <div class="row" id="row_${i}">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Store</label>
                        <select class="form-control" name="store_id[]" id="store_id_${i}">
                            <option value="" selected disabled>Select Store</option>
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="store_id_1"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="item_name[]" id="item_name_${i}" placeholder="Item Name">
                        <small class="text-danger" id="item_name_1"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label" for="quantity_${i}">Quantity</label>
                        <input type="number" class="form-control" name="quantity[]" id="quantity_${i}" placeholder="Quantity">
                        <small class="text-danger" id="quantity_1"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="location[]"  id="location_${i}" placeholder="Location">
                                                <small class="text-danger" id="location_1"></small>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Stock No</label>
                        <input type="text" class="form-control" name="stock_no[]" id="stock_no_${i}" placeholder="Stock No">
                        <small class="text-danger" id="stock_no_1"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Item Code</label>
                        <input type="text" class="form-control" name="item_code[]" id="item_code_${i}" placeholder="Item Code">
                        <small class="text-danger" id="item_code_1"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">In Stock Date</label>
                        <input type="date" class="form-control" id="in_stock_date_${i}" name="in_stock_date[]">
                        <small class="text-danger" id="in_stock_date_1"></small>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger removeRowBtn">Remove</button>
            <hr>
        </div>
    `;

                    $('#stock-items').append(newRow);
                });

                $('#stock-items').on('click', '.removeRowBtn', function() {
                    $(this).closest('.stock-item-row').remove();
                });

                $('#stockForm').on('submit', function(e) {
                    e.preventDefault();

                    const formData = $(this).serialize();
                    console.log(formData);

                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    $.ajax({
                        url: "{{ route('admin.stock.store') }}",
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            window.location.href = response.redirect_url;
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $('.text-danger').text('');

                                for (let key in errors) {
                                    console.log(key, "key");

                                    if (key === "store_id") {
                                        $(`#store_id_1`).parent().find('.text-danger').text(errors[
                                            key][0]);
                                    } else {
                                        let match = key.match(/^(\w+)\.(\d+)$/);
                                        if (match) {
                                            let fieldName = match[1];
                                            let index = parseInt(match[2]) + 1;
                                            let fieldId = `${fieldName}_${index}`;

                                            $(`#${fieldId}`).parent().find('.text-danger').text(
                                                errors[key][0]);
                                        }
                                    }
                                }
                            } else {
                                alert('Something went wrong! Please try again.');
                            }
                        }

                    });
                });

            });
        </script>
    @endsection
