@extends('layout.app')
@section('body')

@section('style')
    <link href="https://unpkg.com/tabulator-tables@5.4.4/dist/css/tabulator.min.css" rel="stylesheet">
@endsection

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
                <div id="stock-table"></div>
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
<script src="https://unpkg.com/tabulator-tables@5.4.4/dist/js/tabulator.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const authToken = "{{ $authToken }}";

            const table = new Tabulator("#stock-table", {
                ajaxURL: "http://127.0.0.1:8000/api/stocks",
                ajaxSorting: true,
                ajaxFiltering: true,
                pagination: "remote",
                paginationSize: 5,
                paginationSizeSelector: [5, 10, 20, 50],
                layout: "fitColumns",

                ajaxConfig: {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${authToken}`,
                        "Content-Type": "application/json",
                    },
                },

                ajaxResponse: function(url, params, response) {
                    console.log("API Response:", response);

                    return response.data;
                },

                columns: [{
                        title: "ID",
                        field: "id",
                        sorter: "number"
                    },
                    {
                        title: "Stock Number",
                        field: "stock_no",
                        sorter: "number"
                    },
                    {
                        title: "Item Code",
                        field: "item_code",
                        sorter: "string"
                    },
                    {
                        title: "Item Name",
                        field: "item_name",
                        sorter: "string"
                    },
                    {
                        title: "Quantity",
                        field: "quantity",
                        sorter: "number"
                    },
                    {
                        title: "Location",
                        field: "location",
                        sorter: "string"
                    },
                    {
                        title: "Stock Status",
                        field: "stock_status",
                        sorter: "string"
                    },
                    {
                        title: "In Stock Date",
                        field: "in_stock_date",
                        sorter: "date"
                    },
                    {
                        title: "Created At",
                        field: "created_at",
                        sorter: "date"
                    },
                ],
            });
        });
</script>
@endsection
