@extends('layouts.master')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="page-header">
    <h3 class="page-title"> Pemesanan Kantin Online </h3>
</div>

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Menu</h4>
                
                <div class="form-group">
                    <label>Pilih Vendor</label>
                    <select class="form-control" id="select_vendor">
                        <option value="0" disabled selected>-- Pilih Vendor --</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Pilih Menu</label>
                    <select class="form-control" id="select_menu" disabled>
                        <option value="0" disabled selected>-- Pilih Menu --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" class="form-control bg-light" id="harga_menu" readonly>
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" value="1" min="1">
                </div>
                
                <button type="button" class="btn btn-gradient-primary w-100" id="btn-tambah" onclick="tambahKeKeranjang()" disabled>
                    Tambahkan ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Keranjang Belanja</h4>
                <div class="table-responsive">
                    <table class="table" id="tabel-keranjang">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h3 class="mb-0">Total: <span id="teks-total" class="text-danger">Rp 0</span></h3>
                    <button type="button" class="btn btn-lg btn-success" id="btn-checkout" onclick="prosesCheckout()" disabled>
                        Checkout & Bayar
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
        // Event 1: Dropdown berjenjang Vendor -> Menu
        // Event 1: Dropdown berjenjang Vendor -> Menu
    $('#select_vendor').change(function() {
        let idvendor = $(this).val();
        
        // Set ke mode loading
        $('#select_menu').prop('disabled', false).empty().append('<option value="0" disabled selected>Loading...</option>');
        $('#harga_menu').val('');
        $('#btn-tambah').prop('disabled', true);
        
        let targetUrl = "{{ route('customer.getMenus', ':id') }}";
        targetUrl = targetUrl.replace(':id', idvendor);

        axios.get(targetUrl)
            .then(function(response) {
                // Cek jika response data kosong (vendor belum punya menu)
                if(response.data.length === 0) {
                    $('#select_menu').empty().append('<option value="0" disabled selected>-- Menu Kosong --</option>');
                    return;
                }

                // Jika ada menu, masukkan ke dropdown
                $('#select_menu').empty().append('<option value="0" disabled selected>-- Pilih Menu --</option>');
                response.data.forEach(menu => {
                    $('#select_menu').append(`<option value="${menu.idmenu}" data-nama="${menu.nama_menu}" data-harga="${menu.harga}">${menu.nama_menu}</option>`);
                });
            })
            .catch(function(error) {
                // Tangkap error agar tidak stuck di "Loading..."
                console.error("Terjadi error Axios:", error);
                $('#select_menu').empty().append('<option value="0" disabled selected>-- Gagal Memuat --</option>');
                Swal.fire('Oops!', 'Gagal memuat data menu. Cek Console Browser!', 'error');
            });
    });

        // Event 2: Saat Menu dipilih, otomatis isi form harga
        $('#select_menu').change(function() {
            let harga = $(this).find(':selected').data('harga');
            $('#harga_menu').val(harga);
            $('#btn-tambah').prop('disabled', false);
        });
    });

    // Fungsi Tambah Keranjang
    function tambahKeKeranjang() {
        let select = $('#select_menu').find(':selected');
        let idmenu = select.val();
        let nama = select.data('nama');
        let harga = parseInt(select.data('harga'));
        let jumlah = parseInt($('#jumlah').val());

        let indexAda = keranjang.findIndex(item => item.idmenu === idmenu);
        if(indexAda !== -1) {
            keranjang[indexAda].jumlah += jumlah;
            keranjang[indexAda].subtotal = keranjang[indexAda].jumlah * harga;
        } else {
            keranjang.push({ idmenu: idmenu, nama_menu: nama, harga: harga, jumlah: jumlah, subtotal: harga * jumlah });
        }
        
        renderTabel();
    }

    // Fungsi Render Tabel
    function renderTabel() {
        let tbody = $('#tabel-keranjang tbody');
        tbody.empty();
        let total = 0;

        keranjang.forEach((item, index) => {
            total += item.subtotal;
            tbody.append(`
                <tr>
                    <td>${item.nama_menu}</td>
                    <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="hapusItem(${index})">X</button></td>
                </tr>
            `);
        });

        $('#teks-total').text('Rp ' + total.toLocaleString('id-ID'));
        $('#btn-checkout').prop('disabled', keranjang.length === 0);
    }

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderTabel();
    }

    // FUNGSI UTAMA: Checkout ke Midtrans
    function prosesCheckout() {
        let totalAkhir = keranjang.reduce((sum, item) => sum + item.subtotal, 0);

        Swal.fire({ title: 'Memproses Order...', didOpen: () => Swal.showLoading() });

        axios.post('{{ route("customer.checkout") }}', {
            keranjang: keranjang, total: totalAkhir, _token: tokenCsrf
        })
        .then(function(response) {
            if(response.data.status === 'success') {
                Swal.close();
                // 1. PANGGIL POPUP MIDTRANS SNAP!
                window.snap.pay(response.data.snap_token, {
                    onSuccess: function(result) {
                        axios.post('{{ route("customer.paymentSuccess") }}', {
                            snap_token: response.data.snap_token,
                            _token: tokenCsrf
                        }).then(function() {
                            Swal.fire('Lunas!', 'Pembayaran berhasil. Pesanan Anda segera diproses!', 'success')
                            .then(() => location.reload());
                        });
                    },
                    onPending: function(result) {
                        Swal.fire('Pending', 'Silakan selesaikan pembayaran Anda.', 'info').then(() => location.reload());
                    },
                    onError: function(result) {
                        Swal.fire('Gagal', 'Pembayaran ditolak atau gagal.', 'error');
                    },
                    onClose: function () {
                        Swal.fire('Oops', 'Anda menutup layar sebelum membayar!', 'warning');
                    }
                });
            } else {
                Swal.fire('Error', response.data.message, 'error');
            }
        });
    }
</script>
@endsection