<?php
require_once('../../tcpdf/tcpdf.php');
include('../../config/connection.php');

function formatTanggalIndonesia($tanggal) {
    $bulanIndo = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    $timestamp = strtotime($tanggal);
    if ($timestamp === false) {
        return "Format Salah";
    }

    $hari = date('d', $timestamp);
    $bulan = date('n', $timestamp) - 1;
    $tahun = date('Y', $timestamp);

    return $hari . " " . $bulanIndo[$bulan] . " " . $tahun;
}

// Tangkap Nama Kepala Sekolah & NIP dari URL
$kepala_sekolah = isset($_GET['kepala_sekolah']) ? $_GET['kepala_sekolah'] : "NAMA KEPALA SEKOLAH";
$nip = isset($_GET['nip']) ? $_GET['nip'] : "19XXXXXXXXX";

// Buat instance TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin Sekolah');
$pdf->SetTitle('Data Siswa');
$pdf->SetSubject('Laporan Data Siswa');

// Hapus header/footer bawaan
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('dejavusans', '', 10);
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
$title = '<h3 style="text-align: center;">LAPORAN DATA SISWA<br>TAHUN AJARAN 2024/2025</h3><br>';
$pdf->writeHTML($title, true, false, true, false, '');

// Tabel Data Siswa
$html = '<table border="1" cellpadding="5">
<thead>
    <tr style="background-color: #f0f0f0;">
        <th>No</th>
        <th>NISN</th>
        <th>Nama Lengkap</th>
        <th>Tanggal Lahir</th>
        <th>Umur</th>
        <th>Alamat</th>
    </tr>
</thead>
<tbody>';

$query = "SELECT NISN, Nama_Peserta_Didik, Tanggal_Lahir, 
                 TIMESTAMPDIFF(YEAR, Tanggal_Lahir, CURDATE()) AS Umur, 
                 Alamat_Tinggal, tgl_ubah 
          FROM identitas_siswa";

$data = mysqli_query($conn, $query);
$no = 1;

while ($row = mysqli_fetch_array($data)) {
    $tanggal_lahir_formatted = formatTanggalIndonesia($row['Tanggal_Lahir']);
    $umur = $row['Umur'];

    $html .= "<tr>
        <td style='text-align: center;'>{$no}</td>
        <td>{$row['NISN']}</td>
        <td>{$row['Nama_Peserta_Didik']}</td>
        <td>{$tanggal_lahir_formatted}</td>
        <td style='text-align: center;'>{$umur} Tahun</td>
        <td>{$row['Alamat_Tinggal']}</td>
    </tr>";
    $no++;
}

$html .= '</tbody></table>';

// Tambahkan tabel ke dalam PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Tambahkan bagian tanda tangan
$currentDate = formatTanggalIndonesia(date('Y-m-d'));
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
$pdf->Output('laporan-data-siswa.pdf', 'I');
