@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-success text-white me-2">
            <i class="mdi mdi-cart"></i>
        </span> Point of Sales (Kasir)
    </h3>
</div>

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cari Barang</h4>
                <p class="card-description">Ketik ID dan tekan <b>Enter</b></p>
                
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" class="form-control" id="kode_barang" placeholder="Ketik ID lalu tekan Enter..." autofocus>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control bg-light" id="nama_barang" readonly>
                </div>
                <div class="form-group">
                    <label>Harga Barang</label>
                    <input type="number" class="form-control bg-light" id="harga_barang" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" value="1" min="1">
                </div>
                
                <button type="button" class="btn btn-gradient-success w-100" id="btn-tambah" onclick="tambahKeKeranjang()" disabled>
                    <i class="mdi mdi-plus"></i> Tambahkan
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Keranjang Belanja</h4>
                
                <div class="table-responsive" style="min-height: 250px;">
                    <table class="table table-bordered" id="tabel-keranjang">
                        <thead class="bg-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th width="15%">Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>

                <hr>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2 class="mb-0">Total: <span id="teks-total" class="text-danger font-weight-bold">Rp 0</span></h2>
                    <button type="button" class="btn btn-lg btn-gradient-info" onclick="prosesBayar()">
                        <i class="mdi mdi-cash-multiple"></i> Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let keranjang = [];
    let tokenCsrf = '{{ csrf_token() }}';

    $(document).ready(function() {
        $('#kode_barang').keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                let kode = $(this).val();

                if(kode === '') return;

                axios.post('{{ route("ajax.pos.cari") }}', { 
                    kode: kode, 
                    _token: tokenCsrf 
                })
                .then(function(response) {
                    if(response.data.status === 'success') {
                        let brg = response.data.data;
                        $('#nama_barang').val(brg.nama);
                        $('#harga_barang').val(brg.harga);
                        $('#jumlah').val(1);
                        $('#btn-tambah').prop('disabled', false);
                        $('#jumlah').focus();
                    } else {
                        Swal.fire('Oops!', response.data.message, 'error');
                        resetFormBarang();
                    }
                })
                .catch(function(error) {
                    console.error(error);
                    Swal.fire('Error', 'Terjadi kesalahan koneksi!', 'error');
                });
            }
        });
    });

    // FUNGSI: Memasukkan barang ke keranjang array
    function tambahKeKeranjang() {
        let kode = $('#kode_barang').val();
        let nama = $('#nama_barang').val();
        let harga = parseInt($('#harga_barang').val());
        let jumlah = parseInt($('#jumlah').val());

        if(jumlah <= 0) {
            Swal.fire('Peringatan', 'Jumlah barang minimal 1!', 'warning');
            return;
        }

        let indexAda = keranjang.findIndex(item => item.id_barang === kode);

        if(indexAda !== -1) {
            keranjang[indexAda].jumlah += jumlah;
            keranjang[indexAda].subtotal = keranjang[indexAda].jumlah * harga;
        } else {
            keranjang.push({
                id_barang: kode,
                nama: nama,
                harga: harga,
                jumlah: jumlah,
                subtotal: harga * jumlah
            });
        }

        renderTabel();
        resetFormBarang();
        $('#kode_barang').focus();
    }

    // FUNGSI: Menggambar ulang tabel keranjang & menghitung Total
    function renderTabel() {
        let tbody = $('#tabel-keranjang tbody');
        tbody.empty();
        
        let total = 0;

        keranjang.forEach((item, index) => {
            total += item.subtotal;
            
            let row = `
                <tr>
                    <td><strong>${item.id_barang}</strong></td>
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm" min="1" 
                               value="${item.jumlah}" onchange="updateJumlah(${index}, this.value)">
                    </td>
                    <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="hapusItem(${index})"><i class="mdi mdi-delete"></i></button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        $('#teks-total').text('Rp ' + total.toLocaleString('id-ID'));
    }

    // FUNGSI: Update jumlah barang langsung dari tabel
    function updateJumlah(index, nilaiBaru) {
        let jumlah = parseInt(nilaiBaru);
        if(jumlah < 1) jumlah = 1;

        keranjang[index].jumlah = jumlah;
        keranjang[index].subtotal = jumlah * keranjang[index].harga;
        renderTabel();
    }

    // FUNGSI: Hapus item dari tabel
    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderTabel();
    }

    // FUNGSI: Mengosongkan form input kiri
    function resetFormBarang() {
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#harga_barang').val('');
        $('#jumlah').val(1);
        $('#btn-tambah').prop('disabled', true);
    }

    // FUNGSI: Proses Bayar (Simpan ke Database via Axios)
    function prosesBayar() {
        if(keranjang.length === 0) {
            Swal.fire('Peringatan', 'Keranjang masih kosong!', 'warning');
            return;
        }

        let totalAkhir = keranjang.reduce((sum, item) => sum + item.subtotal, 0);

        // Tampilkan loading SWAL
        Swal.fire({
            title: 'Memproses Pembayaran...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        // Tembak API Pembayaran
        axios.post('{{ route("ajax.pos.bayar") }}', {
            keranjang: keranjang,
            total: totalAkhir,
            _token: tokenCsrf
        })
        .then(function(response) {
            if(response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.data.message
                });
                
                keranjang = [];
                renderTabel();
                resetFormBarang();
            } else {
                Swal.fire('Gagal', response.data.message, 'error');
            }
        })
        .catch(function(error) {
            console.error(error);
            Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data!', 'error');
        });
    }
</script>
@endsection