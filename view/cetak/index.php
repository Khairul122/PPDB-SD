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

        .section-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 16px;
        }

        .data-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .data-table td {
            padding: 8px 0;
            vertical-align: top;
        }

        .data-table td:first-child {
            width: 130px;
            font-weight: 500;
        }

        .data-table td:nth-child(2) {
            width: 20px;
            text-align: center;
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

        .signature p {
            margin: 5px 0;
        }

        .signature .title {
            font-weight: bold;
            margin-bottom: 80px;
        }

        @media print {
            body {
                width: 100%;
                padding: 20px;
            }
            
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

    <?php
    include('../../config/connection.php');
    $NISN = $_GET['id'];
    $query = mysqli_query($conn, "SELECT a.NISN, a.Nama_Peserta_Didik, a.Tanggal_Lahir, a.Alamat_Tinggal, 
        b.Nama_Ayah, b.Telepon_Ayah, b.Nama_Ibu, b.Telepon_Ibu, c.status 
        FROM identitas_siswa a
        LEFT JOIN orang_tua_wali b ON a.Id_Identitas_Siswa = b.Id_Identitas_Siswa
        LEFT JOIN administrasi c ON a.Id_Identitas_Siswa = c.id_identitas_siswa
        WHERE a.NISN = '$NISN'");

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
    ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="section-title">Identitas Calon Siswa Baru:</div>
                    <table class="data-table">
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
                    <div class="section-title">Identitas Orang Tua Calon Siswa Baru:</div>
                    <table class="data-table">
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

    <?php
        }
    } else {
        echo "<div class='alert alert-danger'>Query error: " . mysqli_error($conn) . "</div>";
    }
    ?>

    <div class="signature">
        <p>Padang Alai, <?= date('j F Y') ?></p>
        <p class="title">Kepala Sekolah</p>
        <p>___________________</p>
        <p>NIP. .....................</p>
    </div>
</body>
<script>
    window.print();
</script>
</html>