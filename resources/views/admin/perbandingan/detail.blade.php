@extends('admin.templates.app')

@section('link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">{{ $title }}</h4>
        </div>
        <div class="">
            <a href="{{ route('perbandingan.index') }}" class="btn btn-secondary"><i
                    class="ri-arrow-go-back-line me-1"></i>Kembali</a>
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
                            {{ strtoupper($RiwayatPerbandingan[0]->Perbandingan->Brand->nama) }} </h5>

                        {{-- cek summary dan planning --}}
                        <div class="ms-2">
                            <button class="btn btn-primary w-100" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Cek Summary & Planning
                            </button>

                            {{-- modal --}}
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="add-brand-label">Detail Summary & Planning</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="summary">Summary</label>
                                                <textarea name="summary" id="summary" class="form-control">
                                                     {{ $RiwayatPerbandingan[0]->Perbandingan->summary }} 
                                                </textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="planning">Planning</label>
                                                <textarea name="planning" id="planning" class="form-control">
                                                      {{ $RiwayatPerbandingan[0]->Perbandingan->planning }} 
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-wrapper table-responsive-lg">
                        <table id="TiktokTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Campaign</th>
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
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Perubahan (%)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">GMV MAX -
                            {{ strtoupper($RiwayatPerbandingan[0]->Perbandingan->Brand->nama) }} </h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-wrapper table-responsive-lg">
                        <table id="GmvMaxTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Campaign</th>
                                    <th>Cost</th>
                                    <th>Order</th>
                                    <th>Cost Per Order</th>
                                    <th>Gross Revenue</th>
                                    <th>ROI</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Perubahan (%)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
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
                searching: true,
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
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'jenis_campaign',
                        name: 'jenis_campaign',
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
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();
                    let json = api.ajax.json();

                    if (!json || !json.footer) return; // cegah error

                    let footer = json.footer;

                    $(api.column(3).footer()).html(formatFooter(footer.cost));
                    $(api.column(4).footer()).html(formatFooter(footer.impression));
                    $(api.column(5).footer()).html(formatFooter(footer.click));
                    $(api.column(6).footer()).html(formatFooter(footer.ctr));
                    $(api.column(7).footer()).html(formatFooter(footer.cpc));
                    $(api.column(8).footer()).html(formatFooter(footer.page_view));
                    $(api.column(9).footer()).html(formatFooter(footer.cpv));
                    $(api.column(10).footer()).html(formatFooter(footer.initiate));
                    $(api.column(11).footer()).html(formatFooter(footer.cost_initiate));
                    $(api.column(12).footer()).html(formatFooter(footer.convertion_rate));
                }
            });

            $('#GmvMaxTable').DataTable({
                orderable: false,
                searching: true,
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
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'jenis_campaign',
                        name: 'jenis_campaign'
                    },
                    {
                        data: 'cost',
                        name: 'cost'
                    },
                    {
                        data: 'order',
                        name: 'order'
                    },
                    {
                        data: 'cost_per_order',
                        name: 'cost_per_order'
                    },
                    {
                        data: 'gross_revenue',
                        name: 'gross_revenue'
                    },
                    {
                        data: 'roi',
                        name: 'roi'
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();
                    let json = api.ajax.json();

                    if (!json || !json.footer) return; // cegah error

                    let footer = json.footer;

                    $(api.column(3).footer()).html(formatFooter(footer.cost));
                    $(api.column(4).footer()).html(formatFooter(footer.order));
                    $(api.column(5).footer()).html(formatFooter(footer.cost_per_order));
                    $(api.column(6).footer()).html(formatFooter(footer.gross_revenue));
                    $(api.column(7).footer()).html(formatFooter(footer.roi));
                }
            });

            function formatFooter(val) {
                if (val === null || val === undefined || val === '') return '0%';

                let num = parseFloat(val);

                if (isNaN(num)) return '0%';

                return (num >= 0 ? '+' : '') + num.toFixed(1) + '%';
            }
        });
    </script>
@endsection
