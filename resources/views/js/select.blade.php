@extends('layouts.master')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Menyesuaikan tinggi Select2 agar rapi dengan template Purple Admin */
    .select2-container .select2-selection--single {
        height: 46px; 
        padding: 10px;
        border: 1px solid #ebedf2;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px;
    }
</style>

<div class="page-header">
    <h3 class="page-title"> Studi Kasus JS: Select & Select2 </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-white pt-4 pb-0">
                <h4 class="card-title mb-0">Select</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kota:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputKota1" placeholder="Ketik nama kota...">
                        <button class="btn btn-sm btn-gradient-primary" type="button" onclick="tambahKota1()">Tambahkan</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Select Kota:</label>
                    <select class="form-control" id="selectKota1" onchange="updateTerpilih1()">
                        <option value="" disabled selected>-- Pilih Kota --</option>
                    </select>
                </div>
                
                <div class="mt-4">
                    <h6 class="font-weight-bold">Kota Terpilih: <span id="terpilih1" class="text-primary">-</span></h6>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-white pt-4 pb-0">
                <h4 class="card-title mb-0">select 2</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kota:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputKota2" placeholder="Ketik nama kota...">
                        <button class="btn btn-sm btn-gradient-info" type="button" onclick="tambahKota2()">Tambahkan</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Select Kota:</label>
                    <select class="form-control w-100" id="selectKota2">
                        <option value="" disabled selected>-- Pilih Kota --</option>
                    </select>
                </div>
                
                <div class="mt-4">
                    <h6 class="font-weight-bold">Kota Terpilih: <span id="terpilih2" class="text-info">-</span></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Inisialisasi Saat Halaman Dimuat
    $(document).ready(function() {
        // Nyalakan fitur Select2 pada Card 2
        $('#selectKota2').select2({
            placeholder: "-- Pilih Kota --"
        });

        // Event listener JQuery untuk menangkap perubahan di Select2
        $('#selectKota2').on('change', function() {
            let kota = $(this).val(); // $(this) merujuk pada element select itu sendiri
            if(kota) {
                $('#terpilih2').text(kota);
            }
        });
    });

    // FUNGSI CARD 1 (SELECT BIASA)
    function tambahKota1() {
        let kota = $('#inputKota1').val().trim();
        
        if(kota === '') {
            alert('Silakan ketik nama kota terlebih dahulu!');
            return;
        }

        // Tambahkan opsi baru. new Option(Text, Value)
        $('#selectKota1').append(new Option(kota, kota));
        
        // Kosongkan form input
        $('#inputKota1').val('');
    }

    // Fungsi dipanggil via atribut onchange="" di HTML
    function updateTerpilih1() {
        let kota = $('#selectKota1').val();
        if(kota) {
            $('#terpilih1').text(kota);
        }
    }

    // === FUNGSI CARD 2 (SELECT2) ===
    function tambahKota2() {
        let kota = $('#inputKota2').val().trim();
        
        if(kota === '') {
            alert('Silakan ketik nama kota terlebih dahulu!');
            return;
        }

        // Tambahkan opsi baru ke Select2
        let opsiBaru = new Option(kota, kota, false, false);
        
        // CATATAN PENTING: Untuk Select2, wajib menambahkan .trigger('change') 
        // agar tampilan visual dropdown-nya di-render ulang
        $('#selectKota2').append(opsiBaru).trigger('change'); 
        
        // Kosongkan form input
        $('#inputKota2').val('');
    }
</script>
@endsection