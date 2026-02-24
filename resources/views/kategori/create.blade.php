@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Kategori Baru </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Majalah, Jurnal..." required>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection