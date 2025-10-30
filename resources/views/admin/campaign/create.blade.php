@extends('admin.templates.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <div class="card">

                <form action="{{ isset($campaign) ? url('/campaign/' . $campaign->id) : url('/campaign/create') }}"
                    method="POST" id="campaignForm">
                    @csrf
                    @if (isset($campaign))
                        @method('PUT')
                    @endif

                    <input type="hidden" id="campaign-id" name="id">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control brand-select" required>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ isset($campaign) && $campaign->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ strtoupper($brand->nama) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="platform" id="platform" class="form-control platform-select" required
                                        onchange="Platform()">
                                        <option disabled {{ !isset($campaign) ? 'selected' : '' }}>-- Pilih Platform Dahulu
                                            --</option>
                                        <option value="tiktok"
                                            {{ isset($campaign) && $campaign->platform == 'tiktok' ? 'selected' : '' }}>
                                            Tiktok</option>
                                        <option value="gmvmax"
                                            {{ isset($campaign) && $campaign->platform == 'gmvmax' ? 'selected' : '' }}>GMV
                                            MAX</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- TIKTOK --}}
                        <div class="row tiktok">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">COST</label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror"
                                        name="cost" placeholder="COST" value="{{ $campaign->cost ?? '' }}" required>
                                    @error('cost')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPM</label>
                                    <input type="number" class="form-control tiktok @error('cpm') is-invalid @enderror"
                                        name="cpm" placeholder="CPM" value="{{ $campaign->cpm ?? '' }}" required>
                                    @error('cpm')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Impression</label>
                                    <input type="number"
                                        class="form-control tiktok @error('impression') is-invalid @enderror"
                                        name="impression" placeholder="Impression"
                                        value="{{ $campaign->impression ?? '' }}" required>
                                    @error('impression')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Klik</label>
                                    <input type="number" class="form-control tiktok @error('klik') is-invalid @enderror"
                                        name="klik" placeholder="Klik" value="{{ $campaign->klik ?? '' }}" required>
                                    @error('klik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPC</label>
                                    <input type="number" class="form-control tiktok @error('cpc') is-invalid @enderror"
                                        name="cpc" placeholder="CPC" value="{{ $campaign->cpc ?? '' }}" required>
                                    @error('cpc')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Page View</label>
                                    <input type="number"
                                        class="form-control tiktok @error('page_view') is-invalid @enderror"
                                        name="page_view" placeholder="Page View" value="{{ $campaign->page_view ?? '' }}"
                                        required>
                                    @error('page_view')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">CPV</label>
                                    <input type="number" class="form-control tiktok @error('cpv') is-invalid @enderror"
                                        name="cpv" placeholder="CPV" value="{{ $campaign->cpv ?? '' }}" required>
                                    @error('cpv')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Initiate</label>
                                    <input type="number"
                                        class="form-control tiktok @error('initiate') is-invalid @enderror" name="initiate"
                                        placeholder="Initiate" value="{{ $campaign->initiate ?? '' }}" required>
                                    @error('initiate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cost/Initiate</label>
                                    <input type="number"
                                        class="form-control tiktok @error('cost_per_initiate') is-invalid @enderror"
                                        name="cost_per_initiate" value="{{ $campaign->cost_per_initiate ?? '' }}"
                                        placeholder="Cost/Initiate" required>
                                    @error('cost_per_initiate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Result</label>
                                    <input type="number"
                                        class="form-control purchase @error('result') is-invalid @enderror" name="result"
                                        value="{{ $campaign->result ?? '' }}" placeholder="Result">
                                    @error('result')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPR</label>
                                    <input type="number"
                                        class="form-control purchase @error('cpr') is-invalid @enderror" name="cpr"
                                        value="{{ $campaign->cpr ?? '' }}" placeholder="CPR">
                                    @error('cpr')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- GMV MAX --}}
                        <div class="row gmvmax">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">COST</label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror"
                                        name="cost" placeholder="COST" value="{{ $campaign->cost ?? '' }}" required>
                                    @error('cost')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number"
                                        class="form-control gmvmax @error('order') is-invalid @enderror" name="order"
                                        placeholder="Order" value="{{ $campaign->order ?? '' }}" required>
                                    @error('order')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cost/Order</label>
                                    <input type="number"
                                        class="form-control gmvmax @error('cost_per_order') is-invalid @enderror"
                                        name="cost_per_order" placeholder="Cost/Order"
                                        value="{{ $campaign->cost_per_order ?? '' }}" required>
                                    @error('cost_per_order')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gross Revenue</label>
                                    <input type="number"
                                        class="form-control gmvmax @error('gross_revenue') is-invalid @enderror"
                                        name="gross_revenue" placeholder="Gross Revenue"
                                        value="{{ $campaign->gross_revenue ?? '' }}" required>
                                    @error('gross_revenue')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ROI</label>
                                    <input type="number" class="form-control gmvmax @error('roi') is-invalid @enderror"
                                        name="roi" placeholder="ROI" value="{{ $campaign->roi ?? '' }}" required>
                                    @error('roi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-center">
                                    <button type="submit" id="saveCampaignBtn" class="btn btn-primary">
                                        {{ isset($campaign) ? 'Update Campaign' : 'Save Campaign' }}
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end row -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.brand-select').select2();
            $('.platform-select').select2();

            Platform(); // Pastikan kondisi awal sesuai pilihan
            $('#platform').on('change', Platform);

            // Modal create/update
            const form = $('#campaignForm');
            const btn = $('#saveCampaignBtn');

            // Submit form (create & update)
            form.on('submit', function(e) {
                e.preventDefault();
                var platform = $('#platform').val();

                if (platform == 'tiktok') {
                    $('.gmvmax input.gmvmax').val('');
                } else {
                    $('.tiktok input.tiktok').val('');
                    $('.tiktok input.purchase').val('');
                }

                let url = form.attr('action');
                let type = 'POST';
                const formData = new FormData(this);

                btn.prop('disabled', true).html(
                    `<span class="spinner-border spinner-border-sm"></span> Proses...`);

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        btn.prop('disabled', false).html('Save Campaign');
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success');
                            $('#campaignForm')[0].reset();
                            $('#campaign-id').val('');
                            window.location.href = '/campaign';
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    },

                    error: function() {
                        btn.prop('disabled', false).html('Save Campaign');
                        Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                    }
                });
            });
        });

        function Platform() {
            var platform = $('#platform').val();

            if (platform == 'gmvmax') {
                // Tampilkan GMV MAX, sembunyikan TIKTOK
                $('.gmvmax').show();
                $('.tiktok').hide();

                // Nonaktifkan required di TikTok
                $('.tiktok input.tiktok').prop('required', false);
                // Aktifkan required di GMV MAX
                $('.gmvmax input').prop('required', true);

            } else {
                // Tampilkan TIKTOK, sembunyikan GMV MAX
                $('.gmvmax').hide();
                $('.tiktok').show();

                // Aktifkan required di TikTok
                $('.tiktok input.tiktok').prop('required', true);
                // Nonaktifkan required di GMV MAX
                $('.gmvmax input').prop('required', false);
            }
        }
    </script>
@endsection
