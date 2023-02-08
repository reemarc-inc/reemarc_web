@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ url('admin/create_qr_code')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Form Request</h4>
                            </div>
                            <div class="card-body">
                                QR Code
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="">
                    <div class="card card-statistic-1">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Form Request</h4>
                            </div>
                            <div class="card-body">
                                Coupon Code
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="">
                    <div class="card card-statistic-1">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-server" aria-hidden="true"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Form Request</h4>
                            </div>
                            <div class="card-body">
                                Analytic Report
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </section>




@endsection
