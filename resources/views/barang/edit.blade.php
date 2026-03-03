@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Barang </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Form Edit Data Barang</h4>
                
                <form class="forms-sample" action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="id_barang">ID Barang (Otomatis)</label>
                        <input type="text" class="form-control text-muted bg-light" id="id_barang" value="{{ $barang->id_barang }}" readonly>
                        <small class="form-text text-muted">ID Barang tidak dapat diubah.</small>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $barang->nama) }}" required maxlength="50">
                        @error('nama')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga Barang (Rp)</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" required min="0">
                        @error('harga')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection