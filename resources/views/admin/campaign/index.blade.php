@extends('admin.templates.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        /* Buat kolom menyesuaikan isi */
        #campaignTable {
            table-layout: auto !important;
            width: 100% !important;
        }

        /* Pastikan isi tabel tidak pecah ke baris baru */
        #campaignTable th,
        #campaignTable td {
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        /* Biar header tidak terlalu rapat */
        #campaignTable th {
            padding: 8px 12px;
        }

        /* Biar horizontal scroll aktif kalau isi panjang */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
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
                    <!-- Bagian atas: show entries + search -->
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                        <div id="campaignTable_length"></div>
                        <div id="campaignTable_filter"></div>
                    </div>

                    <!-- HANYA tabel yang di-scroll -->
                    <div class="table-wrapper" style="overflow-x: auto;">
                        <table id="campaignTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl Buat</th>
                                    <th>Jenis Campaign</th>
                                    <th>Nama Brand</th>
                                    <th>Platform</th>
                                    <th>Cost</th>
                                    <th>CPM</th>
                                    <th>Impression</th>
                                    <th>Klik</th>
                                    <th>CPC</th>
                                    <th>Page View</th>
                                    <th>CPV</th>
                                    <th>Initiate</th>
                                    <th>Cost/Initiate</th>
                                    <th>Result</th>
                                    <th>CPR</th>
                                    <th>Order</th>
                                    <th>Cost/Order</th>
                                    <th>Gross Revenue</th>
                                    <th>ROI</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- Bagian bawah: info + pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-2 flex-wrap">
                        <div id="campaignTable_info"></div>
                        <div id="campaignTable_paginate"></div>
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
                responsive: false,
                ajax: {
                    url: "{{ route('campaign.ajax') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'platform',
                        name: 'platform'
                    },
                    {
                        data: 'cost',
                        name: 'cost'
                    },
                    {
                        data: 'cpm',
                        name: 'cpm'
                    },
                    {
                        data: 'impression',
                        name: 'impression'
                    },
                    {
                        data: 'klik',
                        name: 'klik'
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
                        data: 'cost_per_initiate',
                        name: 'cost_per_initiate'
                    },
                    {
                        data: 'result',
                        name: 'result'
                    },
                    {
                        data: 'cpr',
                        name: 'cpr'
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
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
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
