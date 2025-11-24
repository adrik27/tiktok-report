@extends('admin.templates.app')

@section('link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
            @if ($RiwayatPerbandingan[0]->Perbandingan->files != null && $RiwayatPerbandingan[0]->Perbandingan->files != '-')
                <div class="bg-light rounded p-3 mb-3 border">
                    <div class="row gap-2 gap-sm-0 justify-content-center">
                        <div class="col-12 col-sm-4 text-center">
                            <img src="{{ asset($RiwayatPerbandingan[0]->Perbandingan->files) }}" class="img-fluid w-75"
                                alt="{{ $RiwayatPerbandingan[0]->Perbandingan->Brand->nama }}">
                        </div>
                    </div>
                </div>
            @else
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">TIKTOK -
                            {{ ucfirst($RiwayatPerbandingan[0]->Perbandingan->Brand->nama) }} </h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-wrapper table-responsive-lg">
                        <table id="TiktokTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Cost</th>
                                    <th>Impression</th>
                                    <th>Klik</th>
                                    <th>CTR</th>
                                    <th>CPC</th>
                                    <th>Page View</th>
                                    <th>CPV</th>
                                    <th>Initiate</th>
                                    <th>Cost/Initiate</th>
                                    <th>Convertion Rate</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">GMV MAX -
                            {{ ucfirst($RiwayatPerbandingan[0]->Perbandingan->Brand->nama) }} </h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-wrapper table-responsive-lg">
                        <table id="GmvMaxTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Cost</th>
                                    <th>Order</th>
                                    <th>Cost Per Order</th>
                                    <th>Gross Revenue</th>
                                    <th>ROI</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div> <!-- end row -->
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#TiktokTable').DataTable({
                orderable: false,
                searching: false,
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('perbandingan.detail.ajax') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.perbandingan_id = "{{ $RiwayatPerbandingan[0]->perbandingan_id }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'cost',
                        name: 'cost'
                    },
                    {
                        data: 'impression',
                        name: 'impression'
                    },
                    {
                        data: 'click',
                        name: 'click'
                    },
                    {
                        data: 'ctr',
                        name: 'ctr'
                    },
                    {
                        data: 'cpc',
                        name: 'cpc'
                    },
                    {
                        data: 'page_view',
                        name: 'page_view'
                    },
                    {
                        data: 'cpv',
                        name: 'cpv'
                    },
                    {
                        data: 'initiate',
                        name: 'initiate'
                    },
                    {
                        data: 'cost_initiate',
                        name: 'cost_initiate'
                    },
                    {
                        data: 'convertion_rate',
                        name: 'convertion_rate'
                    }
                ],
            });


            $('#GmvMaxTable').DataTable({
                orderable: false,
                searching: false,
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('perbandingan.detail_gmv.ajax') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.perbandingan_id = "{{ $RiwayatPerbandingan[0]->perbandingan_id }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'cost',
                        name: 'cost'
                    },
                    {
                        data: 'impression',
                        name: 'impression'
                    },
                    {
                        data: 'click',
                        name: 'click'
                    },
                    {
                        data: 'ctr',
                        name: 'ctr'
                    },
                    {
                        data: 'cpc',
                        name: 'cpc'
                    },
                    {
                        data: 'page_view',
                        name: 'page_view'
                    },
                    {
                        data: 'cpv',
                        name: 'cpv'
                    },
                    {
                        data: 'initiate',
                        name: 'initiate'
                    },
                    {
                        data: 'cost_initiate',
                        name: 'cost_initiate'
                    },
                    {
                        data: 'convertion_rate',
                        name: 'convertion_rate'
                    }
                ],
            });
        });
    </script>
@endsection
