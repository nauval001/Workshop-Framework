@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h4 class="card-title mb-4">Validasi QR Code Pesanan (Vendor)</h4>
        
        <!-- 1. Area Kamera Scanner khusus Html5-Qrcode -->
        <div id="kamera-container" style="width: 100%; max-width: 400px; margin: auto;">
            <!-- Div dengan ID "reader" ini HARUS ada untuk Html5-Qrcode -->
            <div id="reader" style="width: 100%; border: 3px solid #ddd; border-radius: 10px; overflow: hidden;"></div>
        </div>
        
        <!-- 2. Area Hasil Scan Struk Cantik (Awalnya Disembunyikan) -->
        <div id="hasil-scan" class="mt-4" style="display: none; max-width: 500px; margin: auto;">
            <div class="card border border-success rounded shadow-sm">
                <div class="card-body text-center p-5">
                    <!-- Ikon Sukses -->
                    <i class="mdi mdi-check-circle-outline text-success" style="font-size: 60px;"></i>
                    <h3 class="font-weight-bold text-dark mt-2">Pesanan Ditemukan</h3>
                    <p class="text-muted border-bottom pb-3">Validasi QR Code Berhasil</p>

                    <!-- Area Daftar Menu -->
                    <div class="text-left mt-4">
                        <h6 class="font-weight-bold text-secondary text-uppercase mb-3">Daftar Menu Dipesan:</h6>
                        <ul id="list-menu" class="list-group list-group-flush mb-4 border rounded">
                            <!-- Dimuat Otomatis oleh JS -->
                        </ul>
                    </div>

                    <!-- Area Status Pembayaran -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="font-weight-bold text-secondary text-uppercase mb-2">Status Pembayaran:</h6>
                        <span id="status-bayar" class="badge p-3" style="font-size: 1.1rem; width: 100%;">
                            <!-- Dimuat Otomatis oleh JS -->
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tombol Reset -->
            <button class="btn btn-gradient-primary btn-lg mt-4 w-100 shadow" onclick="location.reload()">
                <i class="mdi mdi-qrcode-scan btn-icon-prepend"></i> Scan Pesanan Lainnya
            </button>
        </div>

        <!-- 3. Audio Beep -->
        <audio id="audio-beep" src="{{ asset('audio/beep.mp3') }}" preload="auto"></audio>
    </div>
</div>

<!-- 4. Import Library Html5-Qrcode dan Axios -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- 5. Script Inti -->
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Dikeluarkan bunyi "beep" pendek
        document.getElementById('audio-beep').play();

        // Scanner berhenti scan
        html5QrcodeScanner.clear().then(() => {
            // Sembunyikan kotak kamera
            document.getElementById('kamera-container').style.display = 'none';
            
            // Mengambil data ke database (Menampilkan menu dan status)
            axios.get('/api/pesanan/' + decodedText)
                .then(function (response) {
                    let data = response.data;
                    
                    if(data && data.length > 0) {
                        let listMenu = '';
                        
                        // Render daftar menu ke dalam UI
                        data.forEach(item => {
                            listMenu += `
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold"><i class="mdi mdi-food text-warning mr-2"></i> ${item.nama_menu}</span>
                                    <i class="mdi mdi-check text-success"></i>
                                </li>`;
                        });
                        document.getElementById('list-menu').innerHTML = listMenu;
                        
                        // Render status bayar ke dalam Badge UI
                        let status = data[0].status_bayar;
                        let statusEl = document.getElementById('status-bayar');
                        statusEl.innerText = status.toUpperCase();
                        
                        if(status === 'Lunas') {
                            statusEl.className = "badge badge-success p-3";
                        } else {
                            statusEl.className = "badge badge-danger p-3";
                        }
                        
                        // Munculkan Struk
                        document.getElementById('hasil-scan').style.display = 'block';
                    } else {
                        alert("Data kosong! Pesanan dengan ID [" + decodedText + "] tidak ditemukan.");
                        location.reload();
                    }
                })
                .catch(function (error) {
                    console.error("Error Axios:", error);
                    alert("Terjadi kesalahan koneksi saat mencari data pesanan.");
                    location.reload();
                });
        });
    }

    // Menyalakan Kamera html5-qrcode
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection