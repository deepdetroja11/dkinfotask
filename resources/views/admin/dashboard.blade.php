@extends('layout.app')
@section('body')

<!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title">Admin<span class="font-weight-normal text-muted ml-2">Dashboard</span></h4>
        </div>
        <div class="page-rightheader ml-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto right-content breadcrumb-right">
                <div class="d-flex">
                    <div class="header-datepicker mr-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="feather feather-calendar"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" placeholder="19 Feb 2020" type="text">
                        </div>
                    </div>
                    <div class="header-datepicker mr-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">img
                                    <i class="feather feather-clock"></i>
                                </div>
                            </div><!-- input-group-prepend -->
                            <input id="tpBasic" type="text" placeholder="09:30am" class="form-control input-small">
                        </div>
                    </div><!-- wd-150 -->
                </div>
                <div class="d-lg-flex d-block">
                    <div class="btn-list">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#clockinmodal">Clock In</button>
                        <button class="btn btn-light" data-toggle="tooltip" data-placement="top" title="E-mail"> <i
                                class="feather feather-mail"></i> </button>
                        <button class="btn btn-light" data-placement="top" data-toggle="tooltip" title="Contact"> <i
                                class="feather feather-phone-call"></i> </button>
                        <button class="btn btn-primary" data-placement="top" data-toggle="tooltip" title="Info"> <i
                                class="feather feather-info"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Page header-->


    <!--Row-->
    <div class="row">
        <div class="col-xl-9 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-left"> <span class="fs-14 font-weight-semibold">Total
                                            User</span>
                                        <h3 class="mb-0 mt-1 mb-2">0</h3>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="icon1 bg-success my-auto  float-right"> <i
                                            class="feather feather-users"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
