<?php
// First, we include our essential dependencies
// TCPDF is needed for PDF generation, while the connection file gives us database access
require_once('../../tcpdf/tcpdf.php');
include('../../config/connection.php');

// Initialize our PDF document with proper settings
// We use portrait orientation (P) and A4 size, which are standard for formal documents
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set up the basic document properties 
// These properties help identify the document in PDF readers
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin Sekolah');
$pdf->SetTitle('Data Administrasi');

// We'll create our own header and footer, so disable the default ones
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Configure page margins to ensure our content fits well
// 15mm margins provide a professional look while maximizing usable space
$pdf->SetMargins(15, 15, 15);

// Enable automatic page breaks to handle overflow content gracefully
$pdf->SetAutoPageBreak(TRUE, 25);

// Create our first page
$pdf->AddPage();

// Generate our official letterhead section
// This maintains consistency with other school documents
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

// Create our report title section
// The academic year is included to provide temporal context
$title = '
<div style="text-align: center; line-height: 1.5;">
    <span style="font-size: 12pt; font-weight: bold;">LAPORAN DATA ADMINISTRASI</span><br>
    <span style="font-size: 12pt; font-weight: bold;">TAHUN AJARAN 2024/2025</span>
</div>
<br>
';

$pdf->writeHTML($title, true, false, true, false, '');

// Set up our data table structure
// Column widths are carefully calculated to accommodate the content
$html = '
<table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="font-weight: bold;">
            <td>No</td>
            <td>NISN</td>
            <td>Nama</td>
            <td>Status Pendaftaran</td>
            <td>Tanggal Update</td>
        </tr>
    </thead>
    <tbody>';

// Retrieve our data using the same query from the main page
// This ensures consistency between the web view and PDF report
$query = "SELECT a.*, b.NISN, b.Nama_Peserta_Didik 
          FROM administrasi a
          LEFT JOIN identitas_siswa b
          ON a.id_identitas_siswa = b.Id_Identitas_Siswa";
$data = mysqli_query($conn, $query) or die(mysqli_error($conn));
$no = 1;

// Process each row of data and add it to our table
while ($row = mysqli_fetch_array($data)) {
    // Format the date to match our standard format
    $tanggal_update = date('Y-m-d H:i:s', strtotime($row['tgl_ubah']));

    $html .= "
        <tr>
            <td style='text-align: center;'>{$no}</td>
            <td>{$row['NISN']}</td>
            <td>{$row['Nama_Peserta_Didik']}</td>
            <td>{$row['status']}</td>
            <td>{$tanggal_update}</td>
        </tr>";
    $no++;
}

$html .= '</tbody></table>';

// Add our completed table to the document
$pdf->writeHTML($html, true, false, true, false, '');

// Create the signature section
// This provides official authentication for the document
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

// Add the signature block to our document
$pdf->writeHTML($signature, true, false, true, false, '');

// Output the final PDF
// Using 'I' as the parameter displays the PDF directly in the browser
$pdf->Output('laporan-data-administrasi.pdf', 'I');
