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
                <div class="row gap-2 gap-sm-0">
                    <div class="col-12 col-sm-4">
                        <div class="earnings-section">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="bg-success-subtle rounded-2 p-1 me-2 border border-dashed border-success">
                                    <i data-feather="shopping-bag" class="align-middle center-icon text-success fs-20"></i>
                                </div>
                                <h6 class="mb-0 fw-normal fs-16">Total Data Brand (BULAN)</h6>
                            </div>
                            <h4 class="my-2 text-dark">{{ $count['brand'] }}</h4>
                            <div class="progress w-75" style="height:6px">
                                <?php
                                $percentase = ($count['brand'] / 100) * 100;
                                ?>
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentase }}%"
                                    aria-valuenow="{{ $percentase }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <div class="earnings-profit border-start border-dashed border-primary-subtle mt-md-0 mt-2">
                            <div class="ms-md-3">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="bg-primary-subtle rounded-2 p-1 me-2 border border-dashed border-primary">
                                        <i data-feather="pie-chart" class="align-middle center-icon text-primary fs-20"></i>
                                    </div>
                                    <h6 class="mb-0 fw-normal fs-16">Total Data Campaign (BULAN)</h6>
                                </div>
                                <h4 class="my-2 text-dark">{{ $count['campaign'] }}</h4>
                                <div class="progress w-75" style="height:6px">
                                    <?php
                                    $percentase = ($count['campaign'] / 100) * 100;
                                    ?>
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $percentase }}%" aria-valuenow="{{ $percentase }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <div class="earnings-expense border-start border-dashed border-primary-subtle mt-md-0 mt-2">
                            <div class="ms-md-3">
                                <div class="d-flex gap-2 align-items-center">
                                    <div
                                        class="bg-secondary-subtle rounded-2 p-1 me-2 border border-dashed border-secondary">
                                        <i data-feather="trending-up"
                                            class="align-middle center-icon text-secondary fs-20"></i>
                                    </div>
                                    <h6 class="mb-0 fw-normal fs-16">Total Data Perbandingan (BULAN)</h6>
                                </div>
                                <h4 class="my-2 text-dark">{{ $count['perbandingan'] }}</h4>
                                <div class="progress w-75" style="height:6px">
                                    <?php
                                    $percentase = ($count['perbandingan'] / 100) * 100;
                                    ?>
                                    <div class="progress-bar bg-secondary" role="progressbar"
                                        style="width: {{ $percentase }}%" aria-valuenow="{{ $percentase }}"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- brand --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Brand</h5>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Brand</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $brand->nama }}</td>
                                    <td>{{ formatTanggal($brand->created_at->format('d-m-Y')) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- campaign --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Campaign</h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
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
                            <tbody>
                                @forelse ($campaigns as $campaign)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ formatTanggal($campaign->tanggal) }}</td>
                                        <td>{{ strtoupper($campaign->jenis_campaign ?? '-') }}</td>
                                        <td>{{ strtoupper($campaign->Brand->nama) }}</td>
                                        <td>{{ strtoupper($campaign->platform) }}</td>
                                        <td>{{ formatAngka($campaign->cost ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->cpm ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->impression ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->klik ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->cpc ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->page_view ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->cpv ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->initiate ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->cost_initiate ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->result ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->cpr ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->order ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->cost_per_order ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->gross_revenue ?? 0) }}</td>
                                        <td>{{ formatAngka($campaign->roi ?? 0) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ url('/campaign/' . $campaign->id . '/edit') }}"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger deleteCampaignBtn"
                                                    data-id="{{ $campaign->id }}">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="21" class="text-center">Data Kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- perbandingan --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Perbandingan</h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bukti</th>
                                    <th>Nama Brand</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perbandingans as $perbandingan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($perbandingan->files !== null)
                                                <a href="{{ asset($perbandingan->files) }}" target="_blank">
                                                    {{ $perbandingan->Brand->nama }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ strtoupper($perbandingan->Brand->nama) }}</td>
                                        <td>{{ formatTanggal($perbandingan->tanggal_awal) }}</td>
                                        <td>{{ formatTanggal($perbandingan->tanggal_akhir) }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start gap-1">

                                                <a href="{{ url('/perbandingan/' . $perbandingan->id . '/detail') }}"
                                                    class="btn btn-sm btn-primary">Detail</a>

                                                <a href="{{ url('/perbandingan/' . $perbandingan->id . '/cetak') }}"
                                                    class="btn btn-sm btn-success">Cetak</a>

                                                <a href="javascript:void(0)" class="btn btn-sm btn-warning"
                                                    onclick="shareLink('Perbandingan', 'Bagikan link perbandingan', '{{ url('/perbandingan/' . $perbandingan->id . '/share') }}')">
                                                    <i data-feather="share-2" class="align-middle"></i>
                                                </a>

                                                <button class="btn btn-sm btn-danger deletePerbandinganBtn"
                                                    data-id="{{ $perbandingan->id }}">Hapus</button>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data Kosong</td>
                                    </tr>
                                @endforelse
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
                                    window.location.reload();
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

            // Delete Perbandingan
            $(document).on('click', '.deletePerbandinganBtn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    icon: 'warning',
                    title: 'Hapus Perbandingan?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/perbandingan/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: $('input[name="_token"]').val()
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire('Terhapus!', data.message, 'success');
                                    window.location.reload();
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


        function shareLink(title, text, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: text,
                    url: url
                });
            } else {
                alert("Share tidak didukung di perangkat ini");
            }
        }
    </script>
@endsection
