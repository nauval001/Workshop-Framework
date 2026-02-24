@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Buku Baru </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('buku.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="kode">Kode Buku</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Contoh: NV-03" required>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul buku" required>
                    </div>
                    <div class="form-group">
                        <label for="pengarang">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan nama pengarang" required>
                    </div>
                    <div class="form-group">
                        <label for="idkategori">Kategori</label>
                        <select class="form-control" id="idkategori" name="idkategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection