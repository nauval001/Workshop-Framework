@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Barang UMKM </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Form Input Data Barang</h4>
                
                <form class="forms-sample" action="{{ route('barang.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Contoh: Buku Tulis Sidu 38 Lembar" value="{{ old('nama') }}" required maxlength="50">
                        @error('nama')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga Barang (Rp)</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Contoh: 3500" value="{{ old('harga') }}" required min="0">
                        @error('harga')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection