<!DOCTYPE html>
<html>
<head>
    <title>Label Harga TnJ 108</title>
    <style>
        /* Margin kertas A4, disesuaikan dengan pinggiran kertas TnJ 108 asli */
        @page { margin: 10mm 5mm 10mm 5mm; } 
        body { font-family: sans-serif; margin: 0; padding: 0; }
        
        /* Pengaturan 1 Kotak Label */
        .label-box {
            width: 37mm;       /* Lebar label ~3.8cm */
            height: 33mm;      /* Tinggi label ~3.4cm */
            float: left;       /* Jejerkan ke kanan */
            margin: 1mm;       /* Jarak antar stiker */
            padding: 2mm;
            box-sizing: border-box;
            text-align: center;
            border: 1px dotted #ccc;
            border-radius: 5px;
        }

        .empty-box {
            border: none;
        }

        .nama-toko { font-size: 8px; font-weight: bold; margin-bottom: 2px; }
        .nama-barang { font-size: 10px; height: 12px; overflow: hidden; margin-bottom: 5px; }
        .harga { font-size: 14px; font-weight: bold; }
        .barcode { font-size: 8px; margin-top: 5px; }

        /* Paksa pindah halaman jika lebih dari 40 label */
        .page-break { clear: both; page-break-after: always; }
    </style>
</head>
<body>
    @php $count = 0; @endphp

    @for($i = 0; $i < $skip; $i++)
        <div class="label-box empty-box"></div>
        @php $count++; @endphp
    @endfor

    @foreach($barangs as $b)
        <div class="label-box">
            <div class="nama-toko">UMKM BERSAMA</div>
            <div class="nama-barang">{{ substr($b->nama, 0, 20) }}</div> <div class="harga">Rp {{ number_format($b->harga, 0, ',', '.') }}</div>
            <div class="barcode">ID: {{ $b->id_barang }}</div>
        </div>
        
        @php
            $count++;
            // Jika sudah mencapai 40 (5x8), potong ke halaman baru
            if($count % 40 == 0) {
                echo '<div class="page-break"></div>';
            }
        @endphp
    @endforeach

</body>
</html>