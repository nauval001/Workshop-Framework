@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-format-list-bulleted"></i>
        </span> Data Kategori
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title">Daftar Kategori Buku</h4>
                        <p class="card-description"> Menampilkan kategori yang tersedia di sistem </p>
                    </div>
                    <a href="{{ route('kategori.create') }}" class="btn btn-gradient-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> Nama Kategori </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategori as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>
                                    <form action="{{ route('kategori.destroy', $item->idkategori) }}" method="POST">
                                        <a href="{{ route('kategori.edit', $item->idkategori) }}" class="btn btn-sm btn-info">Edit</a>
                                        
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                    </form>
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