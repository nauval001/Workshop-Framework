<!DOCTYPE html>
<html>
<head>
    <title>Cetak Barcode - {{ $toko->nama_toko }}</title>
    <style>
        body { text-align: center; font-family: sans-serif; padding: 50px; }
        .label-box { border: 2px dashed #000; display: inline-block; padding: 30px; border-radius: 10px; }
        h1 { margin-top: 20px; text-transform: uppercase; }
        .barcode-img { margin: 20px 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="label-box">
        <p>IDENTITAS TOKO FISIK</p>
        <div class="barcode-img">
            {!! QrCode::size(250)->generate($toko->barcode) !!}
        </div>
        <h1>{{ $toko->nama_toko }}</h1>
        <p>ID: {{ $toko->barcode }}</p>
        <small>Koordinat: {{ $toko->latitude }}, {{ $toko->longitude }}</small>
    </div>
</body>
</html>