@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-package-variant"></i>
        </span> Data Barang
    </h3>
</div>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <h4 class="card-title text-white">Cetak Label Harga (Tom & Jerry No. 108)</h4>
                <p>Silakan centang barang pada tabel di bawah, lalu tentukan posisi awal kertas label yang kosong.</p>
                
                <form id="printForm" action="{{ route('barang.cetak') }}" method="POST" target="_blank" class="d-flex align-items-center gap-3">
                    @csrf
                    <div>
                        <label class="form-label text-white">Mulai Kolom (X: 1-5)</label>
                        <input type="number" name="start_x" class="form-control text-dark" value="1" min="1" max="5" required>
                    </div>
                    <div>
                        <label class="form-label text-white">Mulai Baris (Y: 1-8)</label>
                        <input type="number" name="start_y" class="form-control text-dark" value="1" min="1" max="8" required>
                    </div>
                    <div class="mt-4">
                        <button type="button" onclick="submitPrint()" class="btn btn-success btn-lg">
                            <i class="mdi mdi-printer"></i> Cetak Label
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Daftar Barang</h4>
                    <a href="{{ route('barang.create') }}" class="btn btn-gradient-primary btn-sm">Tambah Barang</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped" id="table-barang">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th> ID Barang </th>
                                <th> Nama </th>
                                <th> Harga </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $item)
                            <tr>
                                <td><input type="checkbox" class="check-item" value="{{ $item->id_barang }}"></td>
                                <td><strong>{{ $item->id_barang }}</strong></td>
                                <td>{{ $item->nama }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST">
                                        <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-sm btn-info">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang ini?')">Hapus</button>
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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table-barang').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
            columnDefs: [{ orderable: false, targets: 0 }] // Matikan sorting di kolom checkbox
        });

        // Fitur Check/Uncheck Semua
        $('#checkAll').click(function() {
            $('.check-item').prop('checked', this.checked);
        });
    });

    // Fungsi untuk mengirim data Checkbox ke Form Cetak
    function submitPrint() {
        let form = $('#printForm');
        $('.hidden-id').remove(); // Bersihkan ID lama jika ada

        let checked = $('.check-item:checked');
        if (checked.length === 0) {
            alert('Silakan centang minimal 1 barang pada tabel untuk dicetak!');
            return false;
        }

        // Pindahkan value checkbox yang dicentang ke dalam form print
        checked.each(function() {
            $('<input>').attr({
                type: 'hidden', name: 'barang_ids[]', value: $(this).val(), class: 'hidden-id'
            }).appendTo(form);
        });

        form.submit();
    }
</script>
@endsection