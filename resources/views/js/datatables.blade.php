@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    #tabelBarangDT tbody tr {
        cursor: pointer;
    }
    #tabelBarangDT tbody tr:hover {
        background-color: #f2e7fe !important;
    }
</style>

<div class="page-header">
    <h3 class="page-title"> DataTables </h3>
</div>

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Barang</h4>
                <form id="formTambah">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" id="inputNama" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Barang</label>
                        <input type="number" class="form-control" id="inputHarga" required min="1">
                    </div>
                </form>
                <button type="button" class="btn btn-gradient-primary w-100" id="btnSubmit" onclick="tambahData()">
                    Submit
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Barang (DataTables)</h4>
                <div class="table-responsive">
                    <table class="table table-striped" id="tabelBarangDT">
                        <thead class="bg-light">
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah / Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit">
                    <div class="form-group">
                        <label>ID Barang</label>
                        <input type="text" class="form-control text-muted bg-light" id="editId" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" id="editNama" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Barang (Rp)</label>
                        <input type="number" class="form-control" id="editHarga" required min="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnHapus" onclick="hapusData()">Hapus</button>
                <button type="button" class="btn btn-success" id="btnUbah" onclick="ubahData()">Ubah</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    let tabelDT; // Variabel untuk menyimpan instance DataTables
    let barisTerpilih = null; // Menyimpan objek baris DataTables yang diklik

    // Inisialisasi DataTables saat halaman selesai diload
    $(document).ready(function() {
        tabelDT = $('#tabelBarangDT').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' }
        });

        // Event listener saat baris tabel diklik
        $('#tabelBarangDT tbody').on('click', 'tr', function () {
            // Cegah error jika mengklik baris kosong (DataTables empty message)
            if ($(this).find('.dataTables_empty').length > 0) return;

            // Ambil objek baris dari API DataTables
            barisTerpilih = tabelDT.row(this);
            let data = barisTerpilih.data(); // Mengambil array data: [ID, Nama, Harga]

            // Masukkan data ke dalam Modal
            $('#editId').val(data[0]);
            $('#editNama').val(data[1]);
            $('#editHarga').val(data[2]);

            // Tampilkan Modal
            $('#modalAksi').modal('show');
        });
    });

    // TAMBAH DATA KE DATATABLES
    function tambahData() {
        let form = document.getElementById('formTambah');
        let btn = $('#btnSubmit');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span> Menambahkan...');
        btn.prop('disabled', true);

        setTimeout(() => {
            let id = 'DT-' + Math.floor(Math.random() * 90000 + 10000); // Prefix khusus untuk membedakan
            let nama = $('#inputNama').val();
            let harga = $('#inputHarga').val();

            // Tambah baris menggunakan API DataTables
            tabelDT.row.add([id, nama, harga]).draw(false);

            // Bersihkan form
            $('#inputNama').val('');
            $('#inputHarga').val('');

            btn.html(originalText);
            btn.prop('disabled', false);
        }, 800);
    }

    // UBAH DATA DI DATATABLES
    function ubahData() {
        let form = document.getElementById('formEdit');
        let btn = $('#btnUbah');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span>');
        btn.prop('disabled', true);

        setTimeout(() => {
            let id = $('#editId').val(); // ID tetap tidak berubah
            let namaBaru = $('#editNama').val();
            let hargaBaru = $('#editHarga').val();

            // Ubah data pada baris yang terpilih menggunakan API DataTables
            barisTerpilih.data([id, namaBaru, hargaBaru]).draw(false);

            $('#modalAksi').modal('hide');
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 800);
    }

    // HAPUS DATA DARI DATATABLES
    function hapusData() {
        let btn = $('#btnHapus');
        let originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span>');
        btn.prop('disabled', true);

        setTimeout(() => {
            // Hapus baris menggunakan API DataTables
            barisTerpilih.remove().draw(false);
            
            $('#modalAksi').modal('hide');
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 500);
    }
</script>
@endsection