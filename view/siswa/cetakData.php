<?php
require_once('../../tcpdf/tcpdf.php');
include('../../config/connection.php');

// Create new TCPDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin Sekolah');
$pdf->SetTitle('Data Siswa');
$pdf->SetSubject('Laporan Data Siswa');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set font
$pdf->SetFont('dejavusans', '', 10);

// Add a page
$pdf->AddPage();

// Create letterhead content
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

// Add letterhead
$pdf->writeHTML($letterhead, true, false, true, false, '');

// Title
$title = '<h3 style="text-align: center;">LAPORAN DATA SISWA<br>TAHUN AJARAN 2024/2025</h3><br>';
$pdf->writeHTML($title, true, false, true, false, '');

// Table content
$html = '<table border="1" cellpadding="5">
<thead>
    <tr style="background-color: #f0f0f0;">
        <th>No</th>
        <th>NISN</th>
        <th>Nama Lengkap</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Tanggal Update</th>
    </tr>
</thead>
<tbody>';

$query = "SELECT NISN, Nama_Peserta_Didik, Tanggal_Lahir, Alamat_Tinggal, tgl_ubah FROM identitas_siswa";
$data = mysqli_query($conn, $query);
$no = 1;

while ($row = mysqli_fetch_array($data)) {
    $html .= "<tr>
        <td style='text-align: center;'>{$no}</td>
        <td>{$row['NISN']}</td>
        <td>{$row['Nama_Peserta_Didik']}</td>
        <td>{$row['Tanggal_Lahir']}</td>
        <td>{$row['Alamat_Tinggal']}</td>
        <td>{$row['tgl_ubah']}</td>
    </tr>";
    $no++;
}

$html .= '</tbody></table>';

// Add table
$pdf->writeHTML($html, true, false, true, false, '');

// Add signature section
$currentDate = date('d F Y');
$signature = "
<table style='width: 100%; margin-top: 30px;'>
    <tr>
        <td style='width: 60%;'></td>
        <td style='width: 40%; text-align: center;'>
            Gn. Padang Alai, {$currentDate}<br>
            Kepala SDN 14 V KOTO TIMUR<br><br><br><br><br>
            <u>NAMA KEPALA SEKOLAH</u><br>
            NIP. 19XXXXXXXXX
        </td>
    </tr>
</table>";

$pdf->writeHTML($signature, true, false, true, false, '');

// Output PDF
$pdf->Output('laporan-data-siswa.pdf', 'I');
?>