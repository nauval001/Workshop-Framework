@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Kategori </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection