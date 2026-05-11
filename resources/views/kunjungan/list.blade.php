@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftarkan Toko Baru</h4>
                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    <div class="form-group"><label>ID/Barcode Toko</label><input type="text" name="barcode" class="form-control" maxlength="8" required></div>
                    <div class="form-group"><label>Nama Toko</label><input type="text" name="nama_toko" class="form-control" required></div>
                    <div class="form-group"><label>Latitude</label><input type="text" name="latitude" class="form-control" required></div>
                    <div class="form-group"><label>Longitude</label><input type="text" name="longitude" class="form-control" required></div>
                    <div class="form-group"><label>Accuracy</label><input type="number" name="accuracy" class="form-control" required></div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Toko</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Toko & Koordinat</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Nama Toko</th>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Acc</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tokos as $t)
                            <tr>
                                <td>{{ $t->barcode }}</td>
                                <td>{{ $t->nama_toko }}</td>
                                <td>{{ $t->latitude }}</td>
                                <td>{{ $t->longitude }}</td>
                                <td>{{ $t->accuracy }}m</td>
                                <td>
                                    <a href="{{ route('kunjungan.cetak', $t->barcode) }}" class="btn btn-sm btn-dark" target="_blank">
                                        <i class="mdi mdi-printer"></i> Cetak Barcode
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection