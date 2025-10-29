@extends('admin.templates.app')

@section('css')
@endsection

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">{{ $title }}</h4>
        </div>
    </div>

    <!-- start row -->
    <div class="row">
        <!-- Start Earning Reports -->
        <div class="col-md-12 col-xl-12">

            <div class="bg-light rounded p-3 mb-3 border">
                <div class="row gap-2 gap-sm-0 justify-content-center">
                    <div class="col-12 col-sm-4">
                        <a class="btn btn-primary w-100" href="{{ url('/campaign/create') }}">
                            Create Campaign
                        </a>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">List Brand</h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="responsive-table">
                        <table id="brandsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Brand</th>
                                    <th>Dibuat Pada</th>
                                    <th>Impression Tiktok</th>
                                    <th>Reach Tiktok</th>
                                    <th>Klik Tiktok</th>
                                    <th>CTR Tiktok</th>
                                    <th>CPC Tiktok</th>
                                    <th>ATC Tiktok</th>
                                    <th>COST ATC Tiktok</th>
                                    <th>IC Tiktok</th>
                                    <th>Purchase Tiktok</th>
                                    <th>Conversion Rate Tiktok</th>
                                    <th>Total Spend Tiktok</th>
                                    <th>ROAS Tiktok</th>
                                    <th>Impression GMVMAX</th>
                                    <th>Reach GMVMAX</th>
                                    <th>Klik GMVMAX</th>
                                    <th>CTR GMVMAX</th>
                                    <th>CPC GMVMAX</th>
                                    <th>ATC GMVMAX</th>
                                    <th>COST ATC GMVMAX</th>
                                    <th>IC GMVMAX</th>
                                    <th>Purchase GMVMAX</th>
                                    <th>Conversion Rate GMVMAX</th>
                                    <th>Total Spend GMVMAX</th>
                                    <th>ROAS GMVMAX</th>
                                    <th>ROI GMVMAX</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- end row -->
@endsection

@section('js')
@endsection
