<?php
require_once('../../tcpdf/tcpdf.php');
include('../../config/connection.php');

// Tangkap Nama Kepala Sekolah & NIP dari URL
$kepala_sekolah = isset($_GET['kepala_sekolah']) ? $_GET['kepala_sekolah'] : "NAMA KEPALA SEKOLAH";
$nip = isset($_GET['nip']) ? $_GET['nip'] : "19XXXXXXXXX";

// Buat instance TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin Sekolah');
$pdf->SetTitle('Data Administrasi');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->AddPage();

// Kop Surat
$letterhead = '
<table style="width: 100%;">
    <tr>
        <td style="width: 15%; text-align: center;">
            <img src="logo_padang_pariaman.png" style="width: 60px;">
        </td>
        <td style="width: 70%; text-align: center;">
            <span style="font-size: 24pt; font-weight: bold;">SDN 14 V KOTO TIMUR</span><br>
            <span style="font-size: 9pt;">Gn. Padang Alai, Kec. V Koto Tim, Kabupaten Padang Pariaman <br> Sumatera Barat</span><br>
        </td>
        <td style="width: 15%; text-align: center;">
            <img src="logo_sekolah.png" style="width: 60px;">
        </td>
    </tr>
</table>
<hr style="border-top: 1px solid black;">
<hr style="border-top: 1px solid black; margin-top: -3px;">
<br>
';

$pdf->writeHTML($letterhead, true, false, true, false, '');

// Judul Laporan
$title = '
<div style="text-align: center; line-height: 1.5;">
    <span style="font-size: 12pt; font-weight: bold;">LAPORAN PENERIMAAN SISWA BARU</span><br>
    <span style="font-size: 12pt; font-weight: bold;">TAHUN AJARAN 2024/2025</span>
</div>
<br>
';

$pdf->writeHTML($title, true, false, true, false, '');

// Tabel Data Siswa
$html = '
<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="font-weight: bold;">
            <td>No</td>
            <td>NISN</td>
            <td>Nama</td>
            <td>Umur</td>
            <td>Status Pendaftaran</td>
        </tr>
    </thead>
    <tbody>';

// Query ke database
$query = "SELECT a.*, b.NISN, b.Nama_Peserta_Didik, 
                 TIMESTAMPDIFF(YEAR, b.Tanggal_Lahir, CURDATE()) AS Umur
          FROM administrasi a
          LEFT JOIN identitas_siswa b
          ON a.id_identitas_siswa = b.Id_Identitas_Siswa";

$data = mysqli_query($conn, $query) or die(mysqli_error($conn));
$no = 1;

while ($row = mysqli_fetch_array($data)) {
    $html .= "
        <tr>
            <td style='text-align: center;'>{$no}</td>
            <td>{$row['NISN']}</td>
            <td>{$row['Nama_Peserta_Didik']}</td>
            <td style='text-align: center;'>{$row['Umur']} Tahun</td>
            <td>{$row['status']}</td>
        </tr>";
    $no++;
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Bagian Tanda Tangan
$currentDate = date('d F Y');
$signature = "
<table style='width: 100%; margin-top: 30px;'>
    <tr>
        <td style='width: 60%;'></td>
        <td style='width: 40%; text-align: center;'>
            Gn. Padang Alai, {$currentDate}<br>
            Kepala SDN 14 V KOTO TIMUR<br><br><br><br><br>
            <u>{$kepala_sekolah}</u><br>
            NIP. {$nip}
        </td>
    </tr>
</table>";

$pdf->writeHTML($signature, true, false, true, false, '');
$pdf->Output('laporan-data-administrasi.pdf', 'I');
