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

            <div class="bg-light rounded p-3 mb-3 border">
                <div class="row gap-2 gap-sm-0 justify-content-center">
                    <div class="col-12 col-sm-4">
                        @if (session('error'))
                            <div class="alert alert-danger text-dark">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success text-dark">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                {{ session('success') }}
                            </div>
                        @endif

                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Bandingkan Campaign
                        </button>

                        {{-- modal --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="add-brand-label">Bandingkan Campaign</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="brandForm" action="{{ url('/perbandingan') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="modal-body">
                                            @csrf
                                            {{-- <input type="hidden" id="brand-id" name="id"> --}}

                                            <div class="mb-3">
                                                <label class="form-label">Brand</label>
                                                <select name="brand_id" id="brand_id" class="form-control brand-select"
                                                    required>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->brand_id }}">
                                                            {{ strtoupper($brand->Brand->nama) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal-awal" class="form-label">Tanggal Awal</label>
                                                <input type="date" class="form-control" id="tanggal-awal"
                                                    name="tanggal_awal" max="{{ date('Y-m-d') }}" format="d-m-Y" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal-akhir" class="form-label">Tanggal Akhir</label>
                                                <input type="date" class="form-control" id="tanggal-akhir"
                                                    name="tanggal_akhir" max="{{ date('Y-m-d') }}" format="d-m-Y" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bukti Foto</label>
                                                <input type="file" name="files" id="files" class="form-control"
                                                    accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="summary">Summary</label>
                                                <textarea name="summary" id="summary" class="form-control"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="planning">Planning</label>
                                                <textarea name="planning" id="planning" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="saveBrandBtn" class="btn btn-primary">
                                                Buat Perbandingan
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">List Perbandingan</h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-wrapper" style="overflow-x: auto;">
                        <table id="perbandinganTable" class="table table-striped table-bordered"
                            style="min-width: 1500px;">
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
            const table = $('#perbandinganTable').DataTable({
                serverSide: true,
                responsive: false,
                ajax: {
                    url: "{{ route('perbandingan.ajax') }}",
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
                        data: 'files',
                        name: 'files'
                    },
                    {
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        data: 'tanggal_awal',
                        name: 'tanggal_awal'
                    },
                    {
                        data: 'tanggal_akhir',
                        name: 'tanggal_akhir'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
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
