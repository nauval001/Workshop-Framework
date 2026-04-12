@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-warning text-white me-2">
            <i class="mdi mdi-store"></i>
        </span> Panel Vendor: {{ $vendor->nama_vendor }}
    </h3>
</div>

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Menu Baru</h4>
                <p class="card-description"> Masukkan menu Anda! </p>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form class="forms-sample" action="{{ route('vendor.storeMenu') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Nasi Goreng Spesial" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 15000" required>
                    </div>
                    <div class="form-group">
                        <label>Foto Menu</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                    </div>
                    <button type="submit" class="btn btn-gradient-warning w-100">Simpan Menu</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Menu</h4>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Foto </th>
                                <th> Nama Menu </th>
                                <th> Harga </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $menu)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $menu->path_gambar) }}" alt="foto" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;">
                                </td>
                                <td><strong>{{ $menu->nama_menu }}</strong></td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>
    <a href="{{ route('vendor.menu.edit', $menu->idmenu) }}" class="btn btn-sm btn-warning mb-1">
        <i class="mdi mdi-pencil"></i> Edit
    </a>

    <form action="{{ route('vendor.menu.destroy', $menu->idmenu) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
            <i class="mdi mdi-delete"></i> Hapus
        </button>
    </form>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada menu yang ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 grid-margin stretch-card">
        <div class="card border-success">
            <div class="card-body">
                <h4 class="card-title text-success"><i class="mdi mdi-bell-ring"></i> Pesanan Masuk (LUNAS)</h4>
                <p class="card-description">Daftar makanan yang sudah dibayar dan harus segera dibuat.</p>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-success text-white">
                            <tr>
                                <th>Waktu Pemesanan</th>
                                <th>Nama Customer</th>
                                <th>QR Code</th>
                                <th>Menu Dipilih</th>
                                <th>Jumlah</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesananMasuk as $order)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}</td>
                                <td><strong>{{ $order->nama_pembeli }}</strong></td>
                                <td>
    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($order->idpesanan) !!}
</td>
                                <td>{{ $order->nama_menu }}</td>
                                <td>{{ $order->jumlah }} Porsi</td>
                                <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada pesanan yang lunas hari ini.</td>
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