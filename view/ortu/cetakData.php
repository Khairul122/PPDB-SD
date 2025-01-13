<?php
// Include necessary files for PDF generation and database connection
require_once('../../tcpdf/tcpdf.php');
include('../../config/connection.php');

// Create new TCPDF instance with A4 portrait orientation
// This ensures our document maintains a consistent professional format
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Configure basic document settings
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin Sekolah');
$pdf->SetTitle('Data Orang Tua');

// Remove default header/footer as we'll create our own custom header
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set document margins (left, top, right) in millimeters
$pdf->SetMargins(15, 15, 15);

// Enable automatic page breaks with a margin at the bottom
$pdf->SetAutoPageBreak(TRUE, 25);

// Add the first page to our document
$pdf->AddPage();

// Create the official letterhead section
// This includes the school's official header text with proper formatting
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

// Add the header to our document
$pdf->writeHTML($letterhead, true, false, true, false, '');

// Add the report title section
$title = '
<div style="text-align: center; line-height: 1.5;">
    <span style="font-size: 12pt; font-weight: bold;">LAPORAN DATA ORANG TUA</span><br>
    <span style="font-size: 12pt; font-weight: bold;">TAHUN AJARAN 2024/2025</span>
</div>
<br>
';

$pdf->writeHTML($title, true, false, true, false, '');

// Create the table structure for our data
// Note the careful width allocation to ensure all data fits properly
$html = '
<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="font-weight: bold;">
            <td>No</td>
            <td>NISN</td>
            <td>Nama Peserta</td>
            <td>Nama Ayah</td>
            <td>Nama Ibu</td>
            <td>Nama Wali</td>
            <td>Tanggal Update</td>
        </tr>
    </thead>
    <tbody>';

// Fetch data from database using the same query from the main page
$query = "SELECT NISN, Nama_Peserta_Didik, Nama_Ayah, Nama_Ibu, Nama_Wali, a.tgl_ubah 
          FROM orang_tua_wali a 
          LEFT JOIN identitas_siswa b ON a.Id_Identitas_Siswa = b.Id_Identitas_Siswa";
$data = mysqli_query($conn, $query) or die(mysqli_error($conn));
$no = 1;

// Loop through each row of data and add it to our table
while ($row = mysqli_fetch_array($data)) {
    // Format the date to maintain consistency
    $tanggal_update = date('Y-m-d H:i:s', strtotime($row['tgl_ubah']));
    
    $html .= "
        <tr>
            <td style='text-align: center;'>{$no}</td>
            <td>{$row['NISN']}</td>
            <td>{$row['Nama_Peserta_Didik']}</td>
            <td>{$row['Nama_Ayah']}</td>
            <td>{$row['Nama_Ibu']}</td>
            <td>{$row['Nama_Wali']}</td>
            <td>{$tanggal_update}</td>
        </tr>";
    $no++;
}

$html .= '</tbody></table>';

// Add the completed table to our document
$pdf->writeHTML($html, true, false, true, false, '');

// Add the signature section at the bottom of the document
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

// Add the signature section to our document
$pdf->writeHTML($signature, true, false, true, false, '');

// Output the PDF file
// 'I' parameter means the file will be sent to browser inline (opened in browser)
$pdf->Output('laporan-data-orang-tua.pdf', 'I');
?>