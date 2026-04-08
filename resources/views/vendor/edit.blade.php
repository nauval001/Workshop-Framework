@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Menu Kantin </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Edit Menu</h4>
                
                <form action="{{ route('vendor.menu.update', $menu->idmenu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" class="form-control" name="nama_menu" value="{{ $menu->nama_menu }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" value="{{ $menu->harga }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto Menu (Kosongkan jika tidak ingin ganti)</label>
                        <input type="file" class="form-control" name="foto_menu" accept="image/png, image/jpeg">
                        <small class="text-muted mt-2 d-block">Foto saat ini: {{ $menu->path_gambar }}</small>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">Update Menu</button>
                    <a href="{{ route('vendor.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection