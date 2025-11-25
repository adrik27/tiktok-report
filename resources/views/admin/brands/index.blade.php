@extends('admin.templates.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        #perbandinganTable {
            width: 100% !important;
            table-layout: auto !important;
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
                        <button class="btn btn-primary w-100" type="button" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Create Brand
                        </button>

                        {{-- modal --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="add-brand-label">Add Brand</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="brandForm" action="{{ url('/brands') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" id="brand-id" name="id">

                                            <div class="mb-3">
                                                <label for="brand-name" class="form-label">Brand Name</label>
                                                <input type="text" class="form-control" id="brand-name" name="nama"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="saveBrandBtn" class="btn btn-primary">
                                                Save Brand
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
                        <h5 class="card-title mb-0">List Brand</h5>
                    </div>
                </div>

                <div class="card-body">
                    <table id="brandsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Brand</th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
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
            $('#toggleSidebar').on('click', function() {
                setTimeout(function() {
                    table.columns.adjust().draw();
                }, 300);
            });

            const table = $('#brandsTable').DataTable({
                serverSide: true,
                scrollX: true, // 👈 ADD INI
                autoWidth: false,
                ajax: "{{ route('brands.ajax') }}",
                columnDefs: [{
                        width: "40px !important",
                        targets: 0
                    }, // No
                    {
                        width: "150px !important",
                        targets: 1
                    }, // nama
                    {
                        width: "150px !important",
                        targets: 2
                    }, // tanggal
                    {
                        width: "100px !important",
                        targets: 3
                    }, // Aksi
                ],
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Modal create/update
            const form = $('#brandForm');
            const btn = $('#saveBrandBtn');

            // open edit
            $(document).on('click', '.editBrandBtn', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                // Isi data ke form
                $('#brand-id').val(id);
                $('#brand-name').val(name);

                // Ubah judul dan teks tombol
                $('#add-brand-label').text('Edit Brand');
                $('#saveBrandBtn').text('Update Brand');

                // Buka modal
                $('#exampleModal').modal('show');
            });

            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#brandForm')[0].reset();
                $('#brand-id').val('');
                $('#add-brand-label').text('Add Brand');
                $('#saveBrandBtn').text('Save Brand');
            });

            // Delete brand
            $(document).on('click', '.deleteBrandBtn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    icon: 'warning',
                    title: 'Hapus Brand?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/brands/${id}`,
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

            // Submit form (create & update)
            $('#brandForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#brand-id').val();
                const formData = new FormData(this);
                let url = '/brands';
                let type = 'POST';

                if (id) {
                    url = `/brands/${id}`;
                    formData.append('_method', 'PUT');
                }

                const btn = $('#saveBrandBtn');
                btn.prop('disabled', true).html(
                    `<span class="spinner-border spinner-border-sm"></span> Proses...`
                );

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        btn.prop('disabled', false).html('Save Brand');
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success');
                            $('#exampleModal').modal('hide');
                            $('#brandForm')[0].reset();
                            $('#brand-id').val('');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('Save Brand');
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    }
                });
            });

        });
    </script>
@endsection
