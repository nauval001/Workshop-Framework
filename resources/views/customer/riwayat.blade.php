@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Riwayat Pesanan </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Pesanan & QR Code</h4>
                <p class="card-description">
                    Tunjukkan QR Code di bawah ini kepada Vendor Kantin untuk memvalidasi dan mengambil pesanan Anda.
                </p>

                <div class="table-responsive mt-4">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Waktu Pemesanan</th>
                                <th>ID Pesanan</th>
                                <th>QR Code (Untuk Scan Vendor)</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $pesanan)
                            <tr>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($pesanan->created_at)->translatedFormat('d M Y, H:i') }}</td>
                                <td class="align-middle font-weight-bold">{{ $pesanan->idpesanan }}</td>
                                <td class="align-middle">
                                    <div class="p-2 bg-white d-inline-block border">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(2)->generate($pesanan->idpesanan) !!}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if($pesanan->status_bayar == 'Lunas')
                                        <label class="badge badge-success">Lunas</label>
                                    @else
                                        <label class="badge badge-danger">{{ $pesanan->status_bayar }}</label>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-muted">Belum ada riwayat pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection