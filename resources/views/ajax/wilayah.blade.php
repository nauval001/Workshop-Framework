@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Studi Kasus 1: Wilayah Administrasi </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card border-primary border">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0 text-white">Versi AJAX</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Level 1: Provinsi</label>
                    <select class="form-control" id="prov_ajax">
                        <option value="0">Pilih Provinsi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Level 2: Kota/Kabupaten</label>
                    <select class="form-control" id="kota_ajax" disabled>
                        <option value="0">Pilih Kota</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Level 3: Kecamatan</label>
                    <select class="form-control" id="kec_ajax" disabled>
                        <option value="0">Pilih Kecamatan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Level 4: Kelurahan</label>
                    <select class="form-control" id="kel_ajax" disabled>
                        <option value="0">Pilih Kelurahan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card border-info border">
            <div class="card-header bg-info text-white">
                <h4 class="card-title mb-0 text-white">Versi Axios</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Level 1: Provinsi</label>
                    <select class="form-control" id="prov_axios">
                        <option value="0">Pilih Provinsi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Level 2: Kota/Kabupaten</label>
                    <select class="form-control" id="kota_axios" disabled>
                        <option value="0">Pilih Kota</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Level 3: Kecamatan</label>
                    <select class="form-control" id="kec_axios" disabled>
                        <option value="0">Pilih Kecamatan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Level 4: Kelurahan</label>
                    <select class="form-control" id="kel_axios" disabled>
                        <option value="0">Pilih Kelurahan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api/';

    // Fungsi Pembantu: Mengosongkan Dropdown sesuai instruksi poin d dan e
    function resetDropdown(elementId, defaultText) {
        $(`#${elementId}`).empty().append(`<option value="0">${defaultText}</option>`).prop('disabled', true);
    }

    $(document).ready(function() {

        // ==========================================
        // SCRIPT UNTUK CARD 1 (JQUERY AJAX)
        // ==========================================
        
        // 1. Load Provinsi saat halaman dibuka
        $.ajax({
            url: baseUrl + 'provinces.json',
            type: 'GET',
            success: function(response) {
                response.forEach(item => {
                    $('#prov_ajax').append(`<option value="${item.id}">${item.name}</option>`);
                });
            }
        });

        // 2. Event: Saat Provinsi Berubah -> Load Kota, Kosongkan Kec & Kel (Poin d)
        $('#prov_ajax').change(function() {
            let id = $(this).val();
            resetDropdown('kec_ajax', 'Pilih Kecamatan');
            resetDropdown('kel_ajax', 'Pilih Kelurahan');
            
            if (id != 0) {
                $('#kota_ajax').prop('disabled', false).empty().append('<option value="0">Loading...</option>');
                $.ajax({
                    url: baseUrl + `regencies/${id}.json`,
                    type: 'GET',
                    success: function(response) {
                        $('#kota_ajax').empty().append('<option value="0">Pilih Kota</option>');
                        response.forEach(item => $('#kota_ajax').append(`<option value="${item.id}">${item.name}</option>`));
                    }
                });
            } else {
                resetDropdown('kota_ajax', 'Pilih Kota');
            }
        });

        // 3. Event: Saat Kota Berubah -> Load Kecamatan, Kosongkan Kel (Poin e)
        $('#kota_ajax').change(function() {
            let id = $(this).val();
            resetDropdown('kel_ajax', 'Pilih Kelurahan');

            if (id != 0) {
                $('#kec_ajax').prop('disabled', false).empty().append('<option value="0">Loading...</option>');
                $.ajax({
                    url: baseUrl + `districts/${id}.json`,
                    type: 'GET',
                    success: function(response) {
                        $('#kec_ajax').empty().append('<option value="0">Pilih Kecamatan</option>');
                        response.forEach(item => $('#kec_ajax').append(`<option value="${item.id}">${item.name}</option>`));
                    }
                });
            } else {
                resetDropdown('kec_ajax', 'Pilih Kecamatan');
            }
        });

        // 4. Event: Saat Kecamatan Berubah -> Load Kelurahan
        $('#kec_ajax').change(function() {
            let id = $(this).val();
            if (id != 0) {
                $('#kel_ajax').prop('disabled', false).empty().append('<option value="0">Loading...</option>');
                $.ajax({
                    url: baseUrl + `villages/${id}.json`,
                    type: 'GET',
                    success: function(response) {
                        $('#kel_ajax').empty().append('<option value="0">Pilih Kelurahan</option>');
                        response.forEach(item => $('#kel_ajax').append(`<option value="${item.id}">${item.name}</option>`));
                    }
                });
            } else {
                resetDropdown('kel_ajax', 'Pilih Kelurahan');
            }
        });


        // ==========================================
        // SCRIPT UNTUK CARD 2 (AXIOS)
        // Berbasis Promise (then / catch)
        // ==========================================

        // 1. Load Provinsi
        axios.get(baseUrl + 'provinces.json')
            .then(function(response) {
                // Axios menyimpan data utama di dalam response.data
                response.data.forEach(item => {
                    $('#prov_axios').append(`<option value="${item.id}">${item.name}</option>`);
                });
            })
            .catch(function(error) { console.log(error); });

        // 2. Event Provinsi Berubah (Axios)
        $('#prov_axios').change(function() {
            let id = $(this).val();
            resetDropdown('kec_axios', 'Pilih Kecamatan');
            resetDropdown('kel_axios', 'Pilih Kelurahan');
            
            if (id != 0) {
                $('#kota_axios').prop('disabled', false).empty().append('<option value="0">Loading...</option>');
                axios.get(baseUrl + `regencies/${id}.json`)
                    .then(function(response) {
                        $('#kota_axios').empty().append('<option value="0">Pilih Kota</option>');
                        response.data.forEach(item => $('#kota_axios').append(`<option value="${item.id}">${item.name}</option>`));
                    });
            } else {
                resetDropdown('kota_axios', 'Pilih Kota');
            }
        });

        // 3. Event Kota Berubah (Axios)
        $('#kota_axios').change(function() {
            let id = $(this).val();
            resetDropdown('kel_axios', 'Pilih Kelurahan');

            if (id != 0) {
                $('#kec_axios').prop('disabled', false).empty().append('<option value="0">Loading...</option>');
                axios.get(baseUrl + `districts/${id}.json`)
                    .then(function(response) {
                        $('#kec_axios').empty().append('<option value="0">Pilih Kecamatan</option>');
                        response.data.forEach(item => $('#kec_axios').append(`<option value="${item.id}">${item.name}</option>`));
                    });
            } else {
                resetDropdown('kec_axios', 'Pilih Kecamatan');
            }
        });

        // 4. Event Kecamatan Berubah (Axios)
        $('#kec_axios').change(function() {
            let id = $(this).val();
            if (id != 0) {
                $('#kel_axios').prop('disabled', false).empty().append('<option value="0">Loading...</option>');
                axios.get(baseUrl + `villages/${id}.json`)
                    .then(function(response) {
                        $('#kel_axios').empty().append('<option value="0">Pilih Kelurahan</option>');
                        response.data.forEach(item => $('#kel_axios').append(`<option value="${item.id}">${item.name}</option>`));
                    });
            } else {
                resetDropdown('kel_axios', 'Pilih Kelurahan');
            }
        });

    });
</script>
@endsection