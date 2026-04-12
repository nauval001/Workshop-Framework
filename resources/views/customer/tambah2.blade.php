@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Customer 2 (Simpan via File Path)</h4>
        <form action="{{ route('customer.store2') }}" method="POST">
            @csrf
            <div class="form-group"><label>Nama</label><input type="text" class="form-control" name="nama" required></div>
            <div class="form-group"><label>Alamat</label><input type="text" class="form-control" name="alamat"></div>
            <div class="form-group"><label>Provinsi</label><input type="text" class="form-control" name="provinsi"></div>
            <div class="form-group"><label>Kota</label><input type="text" class="form-control" name="kota"></div>
            <div class="form-group"><label>Kecamatan</label><input type="text" class="form-control" name="kecamatan"></div>
            <div class="form-group"><label>Kodepos</label><input type="text" class="form-control" name="kodepos"></div>
            
            <div class="form-group mt-3">
                <label>Foto</label>
                <div class="border p-2" style="width: 250px; height: 200px;">
                    <img id="hasil-foto" src="" style="width: 100%; height: 100%; object-fit: cover; display:none;">
                </div>
                <input type="hidden" id="foto_base64" name="foto_base64">
                
                <button type="button" class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#kameraModal" onclick="bukaKamera()">Ambil Foto</button>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Simpan Data</button>
        </form>
    </div>
</div>

<div class="modal fade" id="kameraModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal ambil Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="tutupKamera()"></button>
      </div>
      <div class="modal-body text-center">
        <div class="row">
            <div class="col-md-6">
                <h6>Video</h6>
                <video id="kamera-video" width="100%" autoplay></video>
                <button class="btn btn-secondary mt-2" onclick="gantiKamera()">Pilihan kamera</button>
            </div>
            <div class="col-md-6">
                <h6>Snapshot</h6>
                <canvas id="kamera-canvas" width="320" height="240" style="width:100%; border:1px solid #ccc;"></canvas>
                <button class="btn btn-warning mt-2" onclick="jepretFoto()">Ambil Foto</button>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="simpanKeForm()">Simpan Foto</button>
      </div>
    </div>
  </div>
</div>

<script>
    let video = document.getElementById('kamera-video');
    let canvas = document.getElementById('kamera-canvas');
    let context = canvas.getContext('2d');
    let streamActive = null;
    let fotoBase64Sementara = "";

    // Fungsi menyalakan kamera HTML5 
    function bukaKamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                streamActive = stream;
                video.srcObject = stream;
            })
            .catch(function(err) {
                alert("Kamera tidak diizinkan atau tidak ditemukan.");
            });
    }

    // Fungsi mematikan kamera
    function tutupKamera() {
        if (streamActive) {
            streamActive.getTracks().forEach(track => track.stop());
        }
    }

    // Mengambil gambar dari video ke canvas
    function jepretFoto() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        // Convert canvas ke teks Base64
        fotoBase64Sementara = canvas.toDataURL('image/png'); 
    }

    // Memindahkan foto dari modal ke form utama
    function simpanKeForm() {
        if(fotoBase64Sementara) {
            document.getElementById('hasil-foto').src = fotoBase64Sementara;
            document.getElementById('hasil-foto').style.display = 'block';
            document.getElementById('foto_base64').value = fotoBase64Sementara;
        }
        tutupKamera();
    }
</script>
@endsection