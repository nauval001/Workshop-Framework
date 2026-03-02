<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function sertifikat()
    {
        $data = [
            'nama' => 'Nauval Putra Dika Ramadhani',
            'sebagai' => 'Ketua Panitia'
        ];

        $pdf = Pdf::loadView('pdf.sertifikat', $data)->setPaper('a4', 'landscape');
        
        return $pdf->stream('Sertifikat.pdf');
    }

    public function undangan()
    {
        $data = [
            'nomor' => '001/A/DST/UN2.FV/TI.02.00/2026',
            'tanggal' => '3 Maret 2026'
        ];

        $pdf = Pdf::loadView('pdf.undangan', $data)->setPaper('a4', 'portrait');        
        return $pdf->stream('Undangan_Fakultas.pdf');
    }
}