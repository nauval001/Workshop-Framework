<!DOCTYPE html>
<html>
<head>
    <title>Undangan Fakultas</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 14px; line-height: 1.5; padding: 30px; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .kop-surat h4 { margin: 0; font-size: 18px; }
        .kop-surat p { margin: 0; font-size: 12px; }
        .detail-surat table { width: 100%; margin-bottom: 30px; }
        .content { text-align: justify; }
        .signature { width: 300px; float: right; text-align: center; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>UNIVERSITAS AIRLANGGA</h2>
        <h4>FAKULTAS VOKASI</h4>
        <p>Kampus B Jl. Dharmawangsa Dalam Surabaya 60286 Telp. (031) 5033869</p>
    </div>

    <div class="detail-surat">
        <table>
            <tr>
                <td width="15%">Nomor</td>
                <td width="2%">:</td>
                <td width="53%">{{ $nomor }}</td>
                <td width="30%" style="text-align: right;">{{ $tanggal }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td colspan="2">-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td colspan="2"><b>Undangan</b></td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p>Yth. <br>Bapak/Ibu Dosen<br>Fakultas Vokasi Universitas Airlangga</p>
        <p>Dalam rangka mempererat tali silaturahmi serta mengawali kegiatan tahun 2026, Fakultas Vokasi akan menyelenggarakan kegiatan Silaturahmi Awal Tahun. Sehubungan dengan hal tersebut, kami mengundang Bapak/Ibu untuk hadir pada:</p>
        
        <table style="margin: 20px 0; margin-left: 20px;">
            <tr><td width="100">Hari, Tanggal</td><td>: Selasa, 3 Maret 2026</td></tr>
            <tr><td>Waktu</td><td>: 13.00 - 15.00 WIB</td></tr>
            <tr><td>Tempat</td><td>: Aula Gedung A Fakultas Vokasi</td></tr>
        </table>

        <p>Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>

    <div class="signature">
        <p>Dekan,</p>
        <img src="{{ public_path('assets/images/ttd.png') }}" alt="TTD" style="width: 100px; margin: 15px 0;">
        <p><b>Prof. Nauval Putra Dika Ramadhani, S.ST., M.M., Ph.D</b></p>
    </div>
</body>
</html>