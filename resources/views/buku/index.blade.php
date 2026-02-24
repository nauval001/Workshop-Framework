@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-open-page-variant"></i>
        </span> Data Buku
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title">Daftar Koleksi Buku</h4>
                        <p class="card-description"> Menampilkan semua koleksi buku perpustakaan </p>
                    </div>
                    <a href="{{ route('buku.create') }}" class="btn btn-gradient-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Buku
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
                                <th> Kode </th>
                                <th> Judul </th>
                                <th> Pengarang </th>
                                <th> Kategori </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->pengarang }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('buku.destroy', $item->idbuku) }}" method="POST">
                                        <a href="{{ route('buku.edit', $item->idbuku) }}" class="btn btn-sm btn-info">Edit</a>
                                        
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</button>
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