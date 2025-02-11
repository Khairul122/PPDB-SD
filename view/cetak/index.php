<?php
include('../../config/connection.php');

// Pastikan parameter NISN ada sebelum digunakan
if (isset($_GET['nisn'])) {
    $NISN = $_GET['nisn'];

    // Query ke database
    $query = mysqli_query($conn, "SELECT a.NISN, a.Nama_Peserta_Didik, a.Tanggal_Lahir, a.Alamat_Tinggal, 
        b.Nama_Ayah, b.Telepon_Ayah, b.Nama_Ibu, b.Telepon_Ibu, c.status 
        FROM identitas_siswa a
        LEFT JOIN orang_tua_wali b ON a.Id_Identitas_Siswa = b.Id_Identitas_Siswa
        LEFT JOIN administrasi c ON a.Id_Identitas_Siswa = c.id_identitas_siswa
        WHERE a.NISN = '$NISN'");

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
        } else {
            echo "<div class='alert alert-warning'>Data tidak ditemukan untuk NISN: " . htmlspecialchars($NISN) . "</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Query error: " . mysqli_error($conn) . "</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>Parameter NISN tidak ditemukan di URL.</div>";
    exit;
}

// Tangkap Nama Kepala Sekolah & NIP dari URL
$kepala_sekolah = isset($_GET['kepala_sekolah']) ? $_GET['kepala_sekolah'] : "NAMA KEPALA SEKOLAH";
$nip = isset($_GET['nip']) ? $_GET['nip'] : "19XXXXXXXXX";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Pendaftaran Siswa</title>
    <link rel="stylesheet" href="../../assets/style/css/bootstrap.min.css">
    <style>
        body {
            width: 900px;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0 auto;
            padding: 20px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
        }

        .kop-surat h2 {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .kop-surat p {
            font-size: 14px;
            margin: 5px 0;
        }

        .status-box {
            border: 2px double #333;
            text-align: center;
            padding: 10px;
            width: 280px;
            font-size: 18px;
            margin: 20px 0;
            background-color: #f8f9fa;
        }

        .signature {
            float: right;
            text-align: center;
            margin-top: 50px;
        }

        .signature .title {
            font-weight: bold;
            margin-bottom: 80px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h2>SDN 14 V Koto Timur</h2>
        <p>Gn. Padang Alai, Kec. V Koto Tim., Kabupaten Padang Pariaman, Sumatera Barat</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4>Identitas Calon Siswa Baru:</h4>
            <table class="table">
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['NISN']) ?></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Nama_Peserta_Didik']) ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Tanggal_Lahir']) ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Alamat_Tinggal']) ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Identitas Orang Tua:</h4>
            <table class="table">
                <tr>
                    <td>Nama Ayah</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Nama_Ayah']) ?></td>
                </tr>
                <tr>
                    <td>Telepon Ayah</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Telepon_Ayah']) ?></td>
                </tr>
                <tr>
                    <td>Nama Ibu</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Nama_Ibu']) ?></td>
                </tr>
                <tr>
                    <td>Telepon Ibu</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($row['Telepon_Ibu']) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="status-box">
        <?= ($row['status'] === NULL) ? 'Belum Konfirmasi' : htmlspecialchars($row['status']) ?>
    </div>

    <div class="signature" style="text-align: left; margin-top: 50px;">
    <p style="margin-bottom: 5px;">Padang Alai, <?= date('j F Y') ?></p>
    <p style="font-weight: bold; margin-bottom: 60px;">Kepala Sekolah</p>
    <p style="font-weight: bold; text-decoration: underline; margin-bottom: 5px;">
        <?= htmlspecialchars($kepala_sekolah) ?>
    </p>
    <p>NIP. <?= htmlspecialchars($nip) ?></p>
</div>


    <script>
        window.print();
    </script>
</body>

</html>