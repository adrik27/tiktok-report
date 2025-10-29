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

                <form action="{{ url('/campaign/create') }}" method="post" id="campaignForm">
                    @csrf

                    <div class="card-header">
                        <ul class="nav nav-pills nav-justified justify-content-center bg-light" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-tiktok" role="tab">
                                    <span class="">Tiktok Shop</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#navpills2-gmvmax" role="tab">
                                    <span class="">GMV Max</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-header">
                        <label class="form-label">Brand</label>
                        <select name="Brand_id" id="brand_id" class="form-control brand-select" required>
                            <option disabled selected>-- Pilih Brand Dahulu --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ strtoupper($brand->nama) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card-body">
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active show" id="navpills2-tiktok" role="tabpanel">
                                {{-- <input type="hidden" name="platform[tiktok]" value="tiktok"> --}}

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Impression</label>
                                            <input type="number"
                                                class="form-control @error('impression') is-invalid @enderror"
                                                name="impression" placeholder="Impression" required>
                                            @error('impression')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Reach</label>
                                            <input type="number" class="form-control @error('reach') is-invalid @enderror"
                                                name="reach" placeholder="Reach" required>
                                            @error('reach')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Clicks</label>
                                            <input type="number" class="form-control @error('klik') is-invalid @enderror"
                                                name="klik" placeholder="Clicks" required>
                                            @error('klik')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ctr</label>
                                            <input type="number" class="form-control @error('ctr') is-invalid @enderror"
                                                name="ctr" placeholder="Ctr" required>
                                            @error('ctr')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">CPC</label>
                                            <input type="number" class="form-control @error('cpc') is-invalid @enderror"
                                                name="cpc" placeholder="CPC" required>
                                            @error('cpc')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ATC</label>
                                            <input type="number" class="form-control @error('atc') is-invalid @enderror"
                                                name="atc" placeholder="ATC" required>
                                            @error('atc')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Cost ATC</label>
                                            <input type="number"
                                                class="form-control @error('cost_atc') is-invalid @enderror" name="cost_atc"
                                                placeholder="Cost ATC" required>
                                            @error('cost_atc')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">IC</label>
                                            <input type="number" class="form-control @error('ic') is-invalid @enderror"
                                                name="ic" placeholder="IC" required>
                                            @error('ic')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Purchase</label>
                                            <input type="number"
                                                class="form-control @error('purchase') is-invalid @enderror"
                                                name="purchase" placeholder="Purchase" required>
                                            @error('purchase')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Conversion Rate</label>
                                            <input type="number"
                                                class="form-control @error('conversion_rate') is-invalid @enderror"
                                                name="conversion_rate" placeholder="Conversion Rate" required>
                                            @error('conversion_rate')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Total Spend</label>
                                            <input type="number"
                                                class="form-control @error('total_spend') is-invalid @enderror"
                                                name="total_spend" placeholder="Total Spend" required>
                                            @error('total_spend')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ROAS</label>
                                            <input type="number"
                                                class="form-control @error('roas') is-invalid @enderror" name="roas"
                                                placeholder="ROAS" required>
                                            @error('roas')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="navpills2-gmvmax" role="tabpanel">
                                {{-- <input type="hidden" name="platform[gmvmax]" value="gmvmax"> --}}

                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Impression</label>
                                            <input type="number"
                                                class="form-control @error('impression_gmvmax') is-invalid @enderror"
                                                name="impression_gmvmax" placeholder="Impression" required>
                                            @error('impression_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Reach</label>
                                            <input type="number"
                                                class="form-control @error('reach_gmvmax') is-invalid @enderror"
                                                name="reach_gmvmax" placeholder="Reach" required>
                                            @error('reach_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Clicks</label>
                                            <input type="number"
                                                class="form-control @error('klik_gmvmax') is-invalid @enderror"
                                                name="klik_gmvmax" placeholder="Clicks" required>
                                            @error('klik_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ctr</label>
                                            <input type="number"
                                                class="form-control @error('ctr_gmvmax') is-invalid @enderror"
                                                name="ctr_gmvmax" placeholder="Ctr" required>
                                            @error('ctr_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">CPC</label>
                                            <input type="number"
                                                class="form-control @error('cpc_gmvmax') is-invalid @enderror"
                                                name="cpc_gmvmax" placeholder="CPC" required>
                                            @error('cpc_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ATC</label>
                                            <input type="number"
                                                class="form-control @error('atc_gmvmax') is-invalid @enderror"
                                                name="atc_gmvmax" placeholder="ATC" required>
                                            @error('atc_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Cost ATC</label>
                                            <input type="number"
                                                class="form-control @error('cost_atc_gmvmax') is-invalid @enderror"
                                                name="cost_atc_gmvmax" placeholder="Cost ATC" required>
                                            @error('cost_atc_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">IC</label>
                                            <input type="number"
                                                class="form-control @error('ic_gmvmax') is-invalid @enderror"
                                                name="ic_gmvmax" placeholder="IC" required>
                                            @error('ic_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Purchase</label>
                                            <input type="number"
                                                class="form-control @error('purchase_gmvmax') is-invalid @enderror"
                                                name="purchase_gmvmax" placeholder="Purchase" required>
                                            @error('purchase_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Conversion Rate</label>
                                            <input type="number"
                                                class="form-control @error('conversion_rate_gmvmax') is-invalid @enderror"
                                                name="conversion_rate_gmvmax" placeholder="Conversion Rate" required>
                                            @error('conversion_rate_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Total Spend</label>
                                            <input type="number"
                                                class="form-control @error('total_spend_gmvmax') is-invalid @enderror"
                                                name="total_spend_gmvmax" placeholder="Total Spend" required>
                                            @error('total_spend_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ROAS</label>
                                            <input type="number"
                                                class="form-control @error('roas_gmvmax') is-invalid @enderror"
                                                name="roas_gmvmax" placeholder="ROAS" required>
                                            @error('roas_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ROI</label>
                                            <input type="number"
                                                class="form-control @error('roi_gmvmax') is-invalid @enderror"
                                                name="roi_gmvmax" placeholder="ROI" required>
                                            @error('roi_gmvmax')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-center">
                                    <button type="submit" id="saveCampaignBtn" class="btn btn-primary">Save
                                        Campaign</button>
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

            // Modal create/update
            const form = $('#campaignForm');
            const btn = $('#saveCampaignBtn');

            // Submit form (create & update)
            form.on('submit', function(e) {
                e.preventDefault();
                let url = form.attr('action');
                let type = 'POST';
                const formData = new FormData(this);

                // url = `/campaign/create`;
                // type = 'POST';
                // formData.append('_method', 'PUT');

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
                            form[0].reset();
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
    </script>
@endsection
