<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        .title { font-size: 50px; font-weight: bold; color: #4a148c; letter-spacing: 10px; margin-bottom: 10px; }
        .subtitle { font-size: 20px; color: #666; letter-spacing: 5px; margin-bottom: 50px; }
        .name { font-size: 40px; font-weight: bold; color: #333; margin: 20px 0; border-bottom: 2px solid #ccc; display: inline-block; padding-bottom: 5px; }
        .role { font-size: 30px; font-weight: bold; color: #4a148c; margin-top: 10px; }
        .desc { margin-top: 30px; font-size: 14px; line-height: 1.5; padding: 0 50px; }
    </style>
</head>
<body>
    <div style="border: 10px solid #f2e7fe; padding: 50px; height: 80%;">
        <div class="title">SERTIFIKAT</div>
        <div class="subtitle">P E N G H A R G A A N</div>
        
        <p>Diberikan kepada :</p>
        <div class="name">{{ $nama }}</div>
        
        <p>Atas Partisipasinya Sebagai :</p>
        <div class="role">{{ $sebagai }}</div>
        
        <div class="desc">
            Dalam acara: Seminar Nasional yang diselenggarakan oleh Program Studi Kesehatan Masyarakat Universitas Airlangga pada Selasa, 3 Maret 2026.
        </div>
    </div>
</body>
</html>