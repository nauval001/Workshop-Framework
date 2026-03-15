@extends('layouts.master')

@section('content')
<style>
    .table-hover tbody tr:hover {
        cursor: pointer;
        background-color: #f2e7fe;
    }
</style>

<div class="page-header">
    <h3 class="page-title"> HTML Table </h3>
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
                <h4 class="card-title">Daftar Barang Sementara</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tabelBarang">
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
                        <input type="text" class="form-control" id="editId" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" id="editNama" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Barang</label>
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

<script>
    let barisTerpilih = null;

    // TAMBAH DATA
    function tambahData() {
        let form = document.getElementById('formTambah');
        let btn = $('#btnSubmit');

        // Cek validasi HTML5
        if (!form.checkValidity()) {
            form.reportValidity(); // Memunculkan tooltip error bawaan browser
            return;
        }

        // Ubah tombol jadi Spinner
        let originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span> Menambahkan...');
        btn.prop('disabled', true);

        // Simulasi jeda waktu (misal proses jaringan lambat)
        setTimeout(() => {
            // Generate ID Random
            let id = 'BRG-' + Math.floor(Math.random() * 90000 + 10000);
            let nama = $('#inputNama').val();
            let harga = $('#inputHarga').val();

            // Buat HTML Baris Baru dengan event onclick memanggil Modal
            let row = `
                <tr id="${id}" onclick="bukaModal('${id}')">
                    <td>${id}</td>
                    <td class="col-nama">${nama}</td>
                    <td class="col-harga">${harga}</td>
                </tr>
            `;

            // Masukkan ke dalam tabel
            $('#tabelBarang tbody').append(row);

            // Kosongkan form kembali
            $('#inputNama').val('');
            $('#inputHarga').val('');

            // Kembalikan tombol seperti semula
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 800); // jeda 0.8 detik
    }

    // BUKA MODAL SAAT BARIS DIKLIK
    function bukaModal(id) {
        barisTerpilih = id; // Simpan ID baris ke variabel global
        
        // Ambil data langsung dari kolom tabel berdasarkan ID
        let nama = $(`#${id} .col-nama`).text();
        let harga = $(`#${id} .col-harga`).text();

        // Lempar data ke dalam inputan Modal
        $('#editId').val(id);
        $('#editNama').val(nama);
        $('#editHarga').val(harga);

        // Tampilkan Modal
        $('#modalAksi').modal('show');
    }

    // UBAH DATA
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
            // Ambil nilai baru dari input Modal
            let namaBaru = $('#editNama').val();
            let hargaBaru = $('#editHarga').val();

            // Timpa teks di dalam kolom tabel dengan nilai baru
            $(`#${barisTerpilih} .col-nama`).text(namaBaru);
            $(`#${barisTerpilih} .col-harga`).text(hargaBaru);

            // Tutup modal dan kembalikan tombol
            $('#modalAksi').modal('hide');
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 800);
    }

    // HAPUS DATA
    function hapusData() {
        let btn = $('#btnHapus');
        let originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm"></span>');
        btn.prop('disabled', true);

        setTimeout(() => {
            // Hapus elemen baris tabel secara utuh
            $(`#${barisTerpilih}`).remove();
            
            // Tutup modal
            $('#modalAksi').modal('hide');
            btn.html(originalText);
            btn.prop('disabled', false);
        }, 500);
    }
</script>
@endsection