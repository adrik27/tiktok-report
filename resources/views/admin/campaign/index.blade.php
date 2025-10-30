@extends('admin.templates.app')

@section('css')
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
                        <h5 class="card-title mb-0">List Campaign</h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="campaignTable" class="table table-striped table-bordered table-responsive-lg"
                            style="width:100%">
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
                            </tbody>
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
            const table = $('#campaignTable').DataTable({
                serverSide: true,
                responsive: true,
                ajax: "{{ route('campaign.ajax') }}", // route untuk data AJAX
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'impression',
                        name: 'impression'
                    },
                    {
                        data: 'reach',
                        name: 'reach'
                    },
                    {
                        data: 'klik',
                        name: 'klik'
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
                        data: 'atc',
                        name: 'atc'
                    },
                    {
                        data: 'cost_atc',
                        name: 'cost_atc'
                    },
                    {
                        data: 'ic',
                        name: 'ic'
                    },
                    {
                        data: 'purchase',
                        name: 'purchase'
                    },
                    {
                        data: 'conversion_rate',
                        name: 'conversion_rate'
                    },
                    {
                        data: 'total_spend',
                        name: 'total_spend'
                    },
                    {
                        data: 'roas',
                        name: 'roas'
                    },
                    {
                        data: 'impression_gmvmax',
                        name: 'impression_gmvmax'
                    },
                    {
                        data: 'reach_gmvmax',
                        name: 'reach_gmvmax'
                    },
                    {
                        data: 'klik_gmvmax',
                        name: 'klik_gmvmax'
                    },
                    {
                        data: 'ctr_gmvmax',
                        name: 'ctr_gmvmax'
                    },
                    {
                        data: 'cpc_gmvmax',
                        name: 'cpc_gmvmax'
                    },
                    {
                        data: 'atc_gmvmax',
                        name: 'atc_gmvmax'
                    },
                    {
                        data: 'cost_atc_gmvmax',
                        name: 'cost_atc_gmvmax'
                    },
                    {
                        data: 'ic_gmvmax',
                        name: 'ic_gmvmax'
                    },
                    {
                        data: 'purchase_gmvmax',
                        name: 'purchase_gmvmax'
                    },
                    {
                        data: 'conversion_rate_gmvmax',
                        name: 'conversion_rate_gmvmax'
                    },
                    {
                        data: 'total_spend_gmvmax',
                        name: 'total_spend_gmvmax'
                    },
                    {
                        data: 'roas_gmvmax',
                        name: 'roas_gmvmax'
                    },
                    {
                        data: 'roi_gmvmax',
                        name: 'roi_gmvmax'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

             // Delete Campaign
            $(document).on('click', '.deleteCampaignBtn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    icon: 'warning',
                    title: 'Hapus Campaign?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/campaign/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: $('input[name="_token"]').val()
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire('Terhapus!', data.message, 'success');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire('Gagal!', data.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
