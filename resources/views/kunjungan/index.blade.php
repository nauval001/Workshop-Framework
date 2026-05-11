@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Geolocation Sales</h4>
                <p class="text-muted">Ambil lokasi posisi Anda saat ini.</p>
                
                <button class="btn btn-info w-100 mb-3" id="btn-lokasi" onclick="ambilLokasi()">
                    <i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi
                </button>
                
                <div class="form-group">
                    <label>Latitude</label>
                    <input type="text" id="sales_lat" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="text" id="sales_lng" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Accuracy (meter)</label>
                    <input type="text" id="sales_acc" class="form-control" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">Barcode Scanner Toko</h4>
                <p class="text-muted">Arahkan barcode toko ke kamera setelah lokasi Anda terisi.</p>
                
                <div id="reader" style="width: 100%; border: 3px solid #ddd; border-radius: 10px; margin: auto;"></div>
                <audio id="audio-beep" src="{{ asset('audio/beep.mp3') }}" preload="auto"></audio>

                <div id="hasil-kunjungan" class="mt-4 text-left" style="display: none;">
                    <div class="alert alert-secondary">
                        <h5 class="font-weight-bold" id="res-nama-toko"></h5>
                        <hr>
                        <p class="mb-1">Jarak Aktual: <strong id="res-jarak"></strong> meter</p>
                        <p class="mb-1">Batas Maksimal Jarak (Threshold): <strong id="res-batas"></strong> meter</p>
                        <div class="mt-3 text-center">
                            <h3 id="res-status" class="font-weight-bold p-2 text-white rounded"></h3>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100" onclick="location.reload()">Scan Kunjungan Lain</button>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
        return new Promise((resolve, reject) => {
            let bestResult = null;
            const startTime = Date.now();
            const watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const acc = position.coords.accuracy;
                    if (!bestResult || acc < bestResult.coords.accuracy) {
                        bestResult = position;
                    }
                    if (acc <= targetAccuracy) {
                        navigator.geolocation.clearWatch(watchId);
                        resolve(bestResult);
                    }
                    if (Date.now() - startTime >= maxWait) {
                        navigator.geolocation.clearWatch(watchId);
                        if (bestResult) resolve(bestResult);
                        else reject(new Error("Timeout, tidak dapat posisi"));
                    }
                },
                (error) => reject(error),
                { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
            );
        });
    }

    // Tombol Ambil Lokasi
    async function ambilLokasi() {
        let btn = document.getElementById('btn-lokasi');
        btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Sedang melacak presisi tinggi...';
        btn.disabled = true;

        try {
            const pos = await getAccuratePosition(50);
            document.getElementById('sales_lat').value = pos.coords.latitude;
            document.getElementById('sales_lng').value = pos.coords.longitude;
            document.getElementById('sales_acc').value = pos.coords.accuracy;
            
            btn.innerHTML = '<i class="mdi mdi-check"></i> Lokasi Berhasil Dikunci';
            btn.classList.replace('btn-info', 'btn-success');
        } catch (error) {
            alert("Gagal mengambil lokasi GPS: " + error.message);
            btn.innerHTML = '<i class="mdi mdi-crosshairs-gps"></i> Coba Lagi Ambil Lokasi';
            btn.disabled = false;
        }
    }

    // Scanner
    function onScanSuccess(decodedText, decodedResult) {
        let lat = document.getElementById('sales_lat').value;
        let lng = document.getElementById('sales_lng').value;
        let acc = document.getElementById('sales_acc').value;

        if(!lat || !lng || !acc) {
            alert("Harap ambil lokasi Anda (Geolocation) terlebih dahulu sebelum memindai barcode toko!");
            return;
        }

        document.getElementById('audio-beep').play();
        html5QrcodeScanner.clear().then(() => {
            document.getElementById('reader').style.display = 'none';

            axios.post('/api/kunjungan/validasi', {
                barcode: decodedText,
                lat: lat,
                lng: lng,
                acc: acc
            }).then(function (response) {
                let data = response.data;
                if(data.status === 'success') {
                    document.getElementById('res-nama-toko').innerText = "Toko: " + data.toko.nama_toko;
                    document.getElementById('res-jarak').innerText = data.jarak_aktual;
                    document.getElementById('res-batas').innerText = data.threshold_efektif;
                    
                    let statusEl = document.getElementById('res-status');
                    statusEl.innerText = data.hasil;
                    statusEl.className = `font-weight-bold p-2 text-white rounded bg-${data.warna}`;
                    
                    document.getElementById('hasil-kunjungan').style.display = 'block';
                } else {
                    alert(data.message);
                    location.reload();
                }
            }).catch(err => {
                alert("Kesalahan koneksi sistem.");
            });
        });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 250, height: 100} }, false);
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection