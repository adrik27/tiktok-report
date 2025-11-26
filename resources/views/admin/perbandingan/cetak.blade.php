<style>
    @page {
        size: A4 landscape;
        margin: 15px;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    .container {
        width: 100%;
        margin: 0 auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        border: 1px solid #555;
        padding: 5px;
        font-size: 11px;
        text-align: center;
    }

    table thead th {
        background: #f0f0f0;
        font-weight: bold;
    }

    img.img-fluid {
        height: 40%;
        max-height: 55%;
    }

    .section-title {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0 5px 0;
    }

    .positive {
        color: green;
        font-weight: bold;
    }

    .negative {
        color: red;
        font-weight: bold;
    }
</style>

<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <center>
                    <h3 class="section-title">PERBANDINGAN - {{ strtoupper($perbandingan->Brand->nama) }}</h3>
                </center>
            </div>
        </div>

        {{-- BUKTI --}}
        {{-- @dd(asset($perbandingan->files)) --}}
        {{-- @if ($perbandingan->files !== null) --}}
        <div class="row">
            <div class="col-12">
                <center>
                    {{-- <h3 class="section-title">BUKTI</h3> --}}
                    <img src="{{ public_path($perbandingan->files) }}" class="img-fluid"
                        alt="{{ $perbandingan->Brand->nama }}">
                </center>
            </div>
        </div>
        {{-- @endif --}}

        {{-- TIKTOK && INITIATE --}}
        @if ($data_count['initiate'] > 0)
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title">TIKTOK - INITIATE</h3>
                    <table>
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
                                <th>Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($initiate as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ formatTanggal($item->tanggal) }}</td>
                                    <td>{{ strtoupper($item->jenis_campaign) }}</td>
                                    <td>{{ formatAngka($item->cost) }}</td>
                                    <td>{{ formatAngka($item->impression) }}</td>
                                    <td>{{ formatAngka($item->klik) }}</td>
                                    <td>{{ formatPercentase($item->ctr) }}</td>
                                    <td>{{ formatAngka($item->cpc) }}</td>
                                    <td>{{ formatAngka($item->page_view) }}</td>
                                    <td>{{ formatAngka($item->cpv) }}</td>
                                    <td>{{ formatAngka($item->initiate) }}</td>
                                    <td>{{ formatAngka($item->cost_initiate) }}</td>
                                    <td>{{ formatPercentase($item->convertion_rate) }}</td>
                                </tr>
                            @endforeach

                            <tr class="footer-row">
                                <td colspan="3">Perubahan (%)</td>
                                <td class="{{ $footer['initiate']['cost'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['cost'] }}%
                                </td>
                                <td class="{{ $footer['initiate']['impression'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['impression'] }}%
                                </td>
                                <td class="{{ $footer['initiate']['click'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['click'] }}%
                                </td>
                                <td class="{{ $footer['initiate']['ctr'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['ctr'] }}%</td>
                                <td class="{{ $footer['initiate']['cpc'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['cpc'] }}%</td>
                                <td class="{{ $footer['initiate']['page_view'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['page_view'] }}%</td>
                                <td class="{{ $footer['initiate']['cpv'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['cpv'] }}%</td>
                                <td class="{{ $footer['initiate']['initiate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['initiate'] }}%</td>
                                <td class="{{ $footer['initiate']['cost_initiate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['cost_initiate'] }}%</td>
                                <td
                                    class="{{ $footer['initiate']['convertion_rate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['initiate']['convertion_rate'] }}%</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- TIKTOK && REACH --}}
        @if ($data_count['reach'] > 0)
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title">TIKTOK - REACH</h3>
                    <table>
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
                                <th>Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reach as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ formatTanggal($item->tanggal) }}</td>
                                    <td>{{ strtoupper($item->jenis_campaign) }}</td>
                                    <td>{{ formatAngka($item->cost) }}</td>
                                    <td>{{ formatAngka($item->impression) }}</td>
                                    <td>{{ formatAngka($item->click) }}</td>
                                    <td>{{ formatPercentase($item->ctr) }}</td>
                                    <td>{{ formatAngka($item->cpc) }}</td>
                                    <td>{{ formatAngka($item->page_view) }}</td>
                                    <td>{{ formatAngka($item->cpv) }}</td>
                                    <td>{{ formatAngka($item->initiate) }}</td>
                                    <td>{{ formatAngka($item->cost_initiate) }}</td>
                                    <td>{{ formatPercentase($item->convertion_rate) }}</td>
                                </tr>
                            @endforeach
                            <tr class="footer-row">
                                <td colspan="3">Perubahan (%)</td>
                                <td class="{{ $footer['reach']['cost'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['cost'] }}%
                                </td>
                                <td class="{{ $footer['reach']['impression'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['impression'] }}%
                                </td>
                                <td class="{{ $footer['reach']['click'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['click'] }}%
                                </td>
                                <td class="{{ $footer['reach']['ctr'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['ctr'] }}%</td>
                                <td class="{{ $footer['reach']['cpc'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['cpc'] }}%</td>
                                <td class="{{ $footer['reach']['page_view'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['page_view'] }}%</td>
                                <td class="{{ $footer['reach']['cpv'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['cpv'] }}%</td>
                                <td class="{{ $footer['reach']['initiate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['initiate'] }}%</td>
                                <td class="{{ $footer['reach']['cost_initiate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['cost_initiate'] }}%</td>
                                <td class="{{ $footer['reach']['convertion_rate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['reach']['convertion_rate'] }}%</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- TIKTOK && VIDEO VIEW --}}
        @if ($data_count['videoview'] > 0)
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title">TIKTOK - VIDEO VIEW</h3>
                    <table>
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
                                <th>Conversion Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($videoview as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ formatTanggal($item->tanggal) }}</td>
                                    <td>{{ strtoupper($item->jenis_campaign) }}</td>
                                    <td>{{ formatAngka($item->cost) }}</td>
                                    <td>{{ formatAngka($item->impression) }}</td>
                                    <td>{{ formatAngka($item->click) }}</td>
                                    <td>{{ formatPercentase($item->ctr) }}</td>
                                    <td>{{ formatAngka($item->cpc) }}</td>
                                    <td>{{ formatAngka($item->page_view) }}</td>
                                    <td>{{ formatAngka($item->cpv) }}</td>
                                    <td>{{ formatAngka($item->initiate) }}</td>
                                    <td>{{ formatAngka($item->cost_initiate) }}</td>
                                    <td>{{ formatPercentase($item->convertion_rate) }}</td>
                                </tr>
                            @endforeach
                            <tr class="footer-row">
                                <td colspan="3">Perubahan (%)</td>
                                <td class="{{ $footer['videoview']['cost'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['cost'] }}%
                                </td>
                                <td class="{{ $footer['videoview']['impression'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['impression'] }}%
                                </td>
                                <td class="{{ $footer['videoview']['click'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['click'] }}%
                                </td>
                                <td class="{{ $footer['videoview']['ctr'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['ctr'] }}%</td>
                                <td class="{{ $footer['videoview']['cpc'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['cpc'] }}%</td>
                                <td class="{{ $footer['videoview']['page_view'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['page_view'] }}%</td>
                                <td class="{{ $footer['videoview']['cpv'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['cpv'] }}%</td>
                                <td class="{{ $footer['videoview']['initiate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['initiate'] }}%</td>
                                <td class="{{ $footer['videoview']['cost_initiate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['cost_initiate'] }}%</td>
                                <td
                                    class="{{ $footer['videoview']['convertion_rate'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['videoview']['convertion_rate'] }}%</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- TIKTOK && GMV MAX --}}
        @if ($data_count['gmvmax'] > 0)
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title">TIKTOK - GMV MAX</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Cost</th>
                                <th>Order</th>
                                <th>Cost Per Order</th>
                                <th>Gross Revenue</th>
                                <th>ROI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gmv as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ formatTanggal($item->tanggal) }}</td>
                                    <td>{{ formatAngka($item->cost) }}</td>
                                    <td>{{ formatAngka($item->order) }}</td>
                                    <td>{{ formatAngka($item->cost_per_order) }}</td>
                                    <td>{{ formatAngka($item->gross_revenue) }}</td>
                                    <td>{{ formatAngka($item->roi) }}</td>
                                </tr>
                            @endforeach
                            <tr class="footer-row">
                                <td colspan="2">Perubahan (%)</td>
                                <td class="{{ $footer['gmv']['cost'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['gmv']['cost'] }}%
                                </td>
                                <td class="{{ $footer['gmv']['order'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['gmv']['order'] }}%
                                </td>
                                <td class="{{ $footer['gmv']['cost_per_order'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['gmv']['cost_per_order'] }}%
                                </td>
                                <td class="{{ $footer['gmv']['gross_revenue'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['gmv']['gross_revenue'] }}%
                                </td>
                                <td class="{{ $footer['gmv']['roi'] >= 0 ? 'positive' : 'negative' }}">
                                    {{ $footer['gmv']['roi'] }}%
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- SUMMARY --}}
        @if ($perbandingan->summary)
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title">SUMMARY</h3>

                    <div class="row">
                        <p style="text-align: justify">
                            {!! $perbandingan->summary !!}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- PLANNING --}}
        @if ($perbandingan->planning)
            <div class="row">
                <div class="col-12">
                    <h3 class="section-title">PLANNING</h3>

                    <div class="row">
                        <p style="text-align: justify">
                            {!! $perbandingan->planning !!}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

</body>
