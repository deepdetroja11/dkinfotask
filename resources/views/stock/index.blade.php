@extends('layout.app')
@section('body')

@section('style')
    <link href="{{ asset('assets') }}/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection

@if (session('success'))
    <div class="alert alert-success mt-2" id="successMessage">
        {{ session('success') }}
    </div>
@endif
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Stock<span class="font-weight-normal text-muted ml-2">Information</span></h4>
    </div>
    <div class="page-rightheader ml-md-auto">
        <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
            <div class="d-lg-flex">
                <div class="header-datepicker mr-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="{{ route('admin.stock.create') }}"><button class="btn btn-primary" type="submit">+
                                    Add
                                    Stock </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="table-wrapper">
                    <div id="table-scroll">
                        <table class="table table-vcenter text-nowrap table-bordered border-bottom" id="stockTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Stock No</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatable/js/dataTables.bootstrap4.js"></script>
<script src="{{ asset('assets') }}/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatable/responsive.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $('#stockTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.stock.index') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'stock_no',
                    name: 'stock_no'
                },
                {
                    data: 'item_code',
                    name: 'item_code'
                },
                {
                    data: 'item_name',
                    name: 'item_name'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'in_stock_date',
                    name: 'in_stock_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);
    });

    $(document).ready(function() {
        $(document).on('click', '.deleteBtn', function(e) {
            e.preventDefault();
            var formId = $(this).data('form-id');
            var form = $('#' + formId);

            // Confirm deletion
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form
                .serialize(),
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#stockTable').DataTable().ajax.reload();
                            alert('Record deleted successfully!');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting record. Please try again.');
                    }
                });
            }
        });


    });
</script>
@endsection
