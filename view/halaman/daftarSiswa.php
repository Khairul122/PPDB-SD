<!-- Header -->
<?php
session_start();
$title = "Pendaftaran Peserta Didik Baru"; // Judulnya
// require("../template/header.php"); // include headernya
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title; ?> | PPDB</title>
    <link rel="icon" href="../../assets/img/avatar/icone.png">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="../../assets/bootstrap-4/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../assets/dataTables/css/dataTables.bootstrap4.min.css">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/components.css">

    <!-- General JS Scripts -->
    <script src="../../assets/bootstrap-4/js/jquery-3.3.1.min.js"></script>
    <script src="../../assets/bootstrap-4/js/popper.min.js"></script>
    <script src="../../assets/bootstrap-4/js/bootstrap.min.js"></script>
    <script src="../../assets/bootstrap-4/js/jquery.nicescroll.min.js"></script>
    <script src="../../assets/bootstrap-4/js/moment.min.js"></script>
    <script src="../../assets/js/stisla.js"></script>
    <script src="../../assets/dataTables/js/jquery.dataTables.js"></script>
    <script src="../../assets/dataTables/js/dataTables.bootstrap4.min.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="../../assets/js/scripts.js"></script>
    <script src="../../assets/js/custom.js"></script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <?php if (isset($_SESSION['namaPeserta'])) { ?>
                <nav class="navbar navbar-expand-lg main-navbar">
                    <form class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        </ul>
                    </form>
                    <ul class="navbar-nav navbar-right">
                        <!-- klo mau nambah menu notifikasi langsung ke websitenya aja (https://getstisla.com/) -->
                        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <img alt="image" src="../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                                <div class="d-sm-none d-lg-inline-block"><?= $_SESSION['namaPeserta']; ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- <div class="dropdown-title">Logged in 5 min ago</div> -->
                                <a href="../../controller/admin/daftar.php?logout" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- SIDEBAR -->
                <div class="main-sidebar">
                    <aside id="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href=""><img src="../../assets/img/avatar/icone.png" alt="LP" width="30px"> PPDB</a>
                        </div>
                        <div class="sidebar-brand sidebar-brand-sm">
                            <a href=""><img src="../../assets/img/avatar/icone.png" alt="LP" width="47px"></a>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="menu-header">Menu</li>
                            <li class="nav-item dropdown active">
                                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Pendatar</span></a>
                                <ul class="dropdown-menu">
                                    <li class="active"><a class="nav-link" href="daftarSiswa.php">Data Siswa</a></li>
                                    <li><a class="nav-link" href="daftarOrtu.php">Data Orang Tua</a></li>
                                    <li class="active"><a class="nav-link" href="Pengumuman.php">Pengumuman</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                            <button class="btn btn-primary btn-lg btn-block btn-icon-split" onclick="cetak(<?= $_SESSION['nisnPeserta']; ?>)">
                                <i class="fas fa-sign-out-alt"></i> Cetak Kartu Peserta
                            </button>
                        </div>
                    </aside>
                </div>
            <?php } else {
                echo '<style>.main-content { padding-left: 30px; } .navbar { left: 30px; }</style>';
            } ?>

            <!-- Main Content -->
            <div class="main-content">



                <!-- Isinya -->

                <section class="section">
                    <div class="section-header">
                        <h1><?= $title; ?></h1>
                    </div>

                    <?php
                    if (isset($_SESSION['alert'])) {
                        echo $_SESSION['alert'];
                        unset($_SESSION['alert']);
                    }
                    ?>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- <h4>Basic DataTables</h4> -->
                                        <a href="index.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
                                            <i class="fas fa-arrow-left"></i> Halaman Utama
                                        </a>
                                    </div>
                                    <div class="card-body">

                                        <!-- Jika ada session daftar -->
                                        <?php if (!isset($_SESSION['namaPeserta'])) { ?>

                                            <div class="section-title mt-0 ml-4">Data diri peserta</div>

                                            <!-- Form Tambah Data Siswa -->
                                            <form class="needs-validation" novalidate="" action="../../controller/admin/daftar.php" method="POST">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>NISN</label>
                                                        <input type="number" class="form-control" name="nisn" required=""
                                                            minlength="10" maxlength="10"
                                                            value="<?= isset($_SESSION['form_data']['nisn']) ? $_SESSION['form_data']['nisn'] : ''; ?>">
                                                        <div class="valid-feedback">Bagus!</div>
                                                        <div class="invalid-feedback">Wajib 10 karakter.</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No. KK</label>
                                                        <input type="number" class="form-control" name="no_kk" required="" minlength="16" maxlength="16"
                                                            value="<?= isset($_SESSION['form_data']['no_kk']) ? $_SESSION['form_data']['no_kk'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib 16 kata</div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>NIK</label>
                                                        <input type="number" class="form-control" name="nik" required="" minlength="16" maxlength="16"
                                                            value="<?= isset($_SESSION['form_data']['nik']) ? $_SESSION['form_data']['nik'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib 8 kata </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Panggilan</label>
                                                        <input type="text" class="form-control" name="nama_panggilan" required=""
                                                            value="<?= isset($_SESSION['form_data']['nama_panggilan']) ? $_SESSION['form_data']['nama_panggilan'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Lengkap Peserta Didik</label>
                                                        <input type="text" class="form-control" name="nama_lengkap" required=""
                                                            value="<?= isset($_SESSION['form_data']['nama_lengkap']) ? $_SESSION['form_data']['nama_lengkap'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" class="form-control" name="tempat_lahir" required=""
                                                            value="<?= isset($_SESSION['form_data']['tempat_lahir']) ? $_SESSION['form_data']['tempat_lahir'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggal_lahir" required=""
                                                            value="<?= isset($_SESSION['form_data']['tanggal_lahir']) ? $_SESSION['form_data']['tanggal_lahir'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="form-control" name="jenis_kelamin" required=""
                                                            value="<?= isset($_SESSION['form_data']['jenis_kelamin']) ? $_SESSION['form_data']['jenis_kelamin'] : ''; ?>">
                                                            <option value=""> ~~~ PILIH JENIS KELAMIN ~~~ </option>
                                                            <option value="Laki-Laki">Laki-Laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Agama</label>
                                                        <input type="text" class="form-control" name="agama" required=""
                                                        value="<?= isset($_SESSION['form_data']['agama']) ? $_SESSION['form_data']['agama'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gol Darah</label>
                                                        <input type="text" class="form-control" name="gol_darah" required=""
                                                        value="<?= isset($_SESSION['form_data']['gol_darah']) ? $_SESSION['form_data']['gol_darah'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tinggi Badan</label>
                                                        <input type="number" class="form-control" name="tinggi_badan" required=""
                                                        value="<?= isset($_SESSION['form_data']['tinggi_badan']) ? $_SESSION['form_data']['tinggi_badan'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Berat Badan</label>
                                                        <input type="number" class="form-control" name="berat_badan" required=""
                                                        value="<?= isset($_SESSION['form_data']['berat_badan']) ? $_SESSION['form_data']['berat_badan'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status Anak</label>
                                                        <input type="text" class="form-control" name="status_anak" required=""
                                                        value="<?= isset($_SESSION['form_data']['status_anak']) ? $_SESSION['form_data']['status_anak'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Anak Ke</label>
                                                        <input type="number" class="form-control" name="Anak_Ke" required=""
                                                        value="<?= isset($_SESSION['form_data']['Anak_Ke']) ? $_SESSION['form_data']['Anak_Ke'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jumlah Saudara</label>
                                                        <input type="number" class="form-control" name="jumlah_saudara" required=""
                                                        value="<?= isset($_SESSION['form_data']['jumlah_saudara']) ? $_SESSION['form_data']['jumlah_saudara'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis Tinggal</label>
                                                        <input type="text" class="form-control" name="jenis_tinggal" required=""
                                                        value="<?= isset($_SESSION['form_data']['jenis_tinggal']) ? $_SESSION['form_data']['jenis_tinggal'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Alamat Tinggal</label>
                                                        <textarea type="text" class="form-control" name="alamat_tinggal" required="" style="height:80px"
                                                        value="<?= isset($_SESSION['form_data']['alamat_tinggal']) ? $_SESSION['form_data']['alamat_tinggal'] : ''; ?>"></textarea>
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Provinsi Tinggal</label>
                                                        <input type="text" class="form-control" name="provinsi_tinggal" required=""
                                                        value="<?= isset($_SESSION['form_data']['provinsi_tinggal']) ? $_SESSION['form_data']['provinsi_tinggal'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kabupaten / Kota Tinggal</label>
                                                        <input type="text" class="form-control" name="kab_kota_tinggal" required=""
                                                        value="<?= isset($_SESSION['form_data']['kab_kota_tinggal']) ? $_SESSION['form_data']['kab_kota_tinggal'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kecamatan Tinggal</label>
                                                        <input type="text" class="form-control" name="kecamatan_tinggal" required=""
                                                        value="<?= isset($_SESSION['form_data']['kecamatan_tinggal']) ? $_SESSION['form_data']['kecamatan_tinggal'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kelurahan/Desa Tinggal</label>
                                                        <input type="text" class="form-control" name="kelurahan_tinggal" required=""
                                                        value="<?= isset($_SESSION['form_data']['kelurahan_tinggal']) ? $_SESSION['form_data']['kelurahan_tinggal'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kode POS</label>
                                                        <input type="number" class="form-control" name="kode_pos" required=""
                                                        value="<?= isset($_SESSION['form_data']['kode_pos']) ? $_SESSION['form_data']['kode_pos'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jarak Ke Sekolah (Meter)</label>
                                                        <input type="number" class="form-control" name="jarak_ke_sekolah" required=""
                                                        value="<?= isset($_SESSION['form_data']['jarak_ke_sekolah']) ? $_SESSION['form_data']['jarak_ke_sekolah'] : ''; ?>">
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Riwayat Penyakit</label>
                                                        <textarea type="text" class="form-control" name="riwayat_penyakit" required="" style="height:80px"
                                                        value="<?= isset($_SESSION['form_data']['riwayat_penyakit']) ? $_SESSION['form_data']['riwayat_penyakit'] : ''; ?>"></textarea>
                                                        <!-- Validation -->
                                                        <div class="valid-feedback"> Baguss! </div>
                                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                                        <!-- End Validation -->
                                                    </div>
                                                    <br>
                                                    <div class="modal-footer bg-whitesmoke br">
                                                        <button class="btn btn-primary" name="tambahDataSiswa">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- penutup Form Tambah Data -->

                                            <!-- jika tidak ada session data peserta -->
                                        <?php } else { ?>

                                            <?php
                                            $idne = "";
                                            if (!isset($_SESSION['nisnPeserta'])) {
                                                echo "<script>window.location.href = 'daftarSiswa.php';</script>";
                                            } else {
                                                $idne = $_SESSION['nisnPeserta'];
                                            }

                                            include('../../config/connection.php');
                                            $data = mysqli_query($conn, "SELECT * FROM identitas_siswa WHERE NISN = '$idne'") or die(mysqli_error($conn));

                                            if (mysqli_num_rows($data) != 1) {
                                                echo "<script>window.location.href = 'daftarSiswa.php';</script>";
                                            }

                                            foreach ($data as $row) {
                                            ?>

                                                <div class="section-title mt-0 ml-4">Ubah Data Peserta</div>

                                                <!-- Ubah Data -->
                                                <form class="needs-validation" novalidate="" action="../../controller/admin/daftar.php" method="POST">
                                                    <div class="modal-body">
                                                        <!-- Id data -->
                                                        <input type="hidden" name="id" value="<?= $row['Id_Identitas_Siswa']; ?>">

                                                        <div class="form-group">
                                                            <label>NISN</label>
                                                            <input type="number" class="form-control" name="nisn" required="" minlength="10" maxlength="10" value="<?= $row['NISN']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib 10 kata</div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>No. KK</label>
                                                            <input type="number" class="form-control" name="no_kk" required="" minlength="16" maxlength="16" value="<?= $row['No_KK']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib 16 kata</div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>NIK</label>
                                                            <input type="number" class="form-control" name="nik" required="" minlength="16" maxlength="16" value="<?= $row['NIK']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib 16 kata </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Panggilan</label>
                                                            <input type="text" class="form-control" name="nama_panggilan" required="" value="<?= $row['Nama_Panggilan']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Lengkap Peserta Didik</label>
                                                            <input type="text" class="form-control" name="nama_lengkap" required="" value="<?= $row['Nama_Peserta_Didik']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tempat Lahir</label>
                                                            <input type="text" class="form-control" name="tempat_lahir" required="" value="<?= $row['Tempat_Lahir']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Lahir</label>
                                                            <input type="date" class="form-control" name="tanggal_lahir" required="" value="<?= $row['Tanggal_Lahir']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jenis Kelamin</label>
                                                            <select class="form-control" name="jenis_kelamin" required="">
                                                                <option value=""> ~~~ PILIH JENIS KELAMIN ~~~ </option>
                                                                <option value="Laki-Laki" <?php if ($row['Jenis_Kelamin'] == 'Laki-Laki') {
                                                                                                echo 'selected';
                                                                                            } ?>>Laki-Laki</option>
                                                                <option value="Perempuan" <?php if ($row['Jenis_Kelamin'] == 'Perempuan') {
                                                                                                echo 'selected';
                                                                                            } ?>>Perempuan</option>
                                                            </select>
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Agama</label>
                                                            <input type="text" class="form-control" name="agama" required="" value="<?= $row['Agama']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gol Darah</label>
                                                            <input type="text" class="form-control" name="gol_darah" value="<?= $row['Gol_Darah']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tinggi Badan (Cm)</label>
                                                            <input type="number" class="form-control" name="tinggi_badan" required="" value="<?= $row['Tinggi_Badan']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Berat Badan (Kg)</label>
                                                            <input type="number" class="form-control" name="berat_badan" required="" value="<?= $row['Berat_badan']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Status Anak</label>
                                                            <input type="text" class="form-control" name="status_anak" required="" value="<?= $row['Status_Anak']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Anak Ke</label>
                                                            <input type="number" class="form-control" name="Anak_Ke" required="" value="<?= $row['Anak_Ke']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jumlah Saudara</label>
                                                            <input type="number" class="form-control" name="jumlah_saudara" required="" value="<?= $row['Jml_Saudara']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jenis Tinggal</label>
                                                            <input type="text" class="form-control" name="jenis_tinggal" required="" value="<?= $row['Jenis_Tinggal']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alamat Tinggal</label>
                                                            <textarea type="text" class="form-control" name="alamat_tinggal" required="" style="height:80px"><?= $row['Alamat_Tinggal']; ?></textarea>
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Provinsi Tinggal</label>
                                                            <input type="text" class="form-control" name="provinsi_tinggal" required="" value="<?= $row['Provinsi_Tinggal']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kabupaten / Kota Tinggal</label>
                                                            <input type="text" class="form-control" name="kab_kota_tinggal" required="" value="<?= $row['Kab_Kota_Tinggal']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kecamatan Tinggal</label>
                                                            <input type="text" class="form-control" name="kecamatan_tinggal" required="" value="<?= $row['Kec_Tinggal']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kelurahan Tinggal</label>
                                                            <input type="text" class="form-control" name="kelurahan_tinggal" required="" value="<?= $row['Kelurahan_Tinggal']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kode POS</label>
                                                            <input type="number" class="form-control" name="kode_pos" required="" value="<?= $row['Kode_POS']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jarak Ke Sekolah (Meter)</label>
                                                            <input type="number" class="form-control" name="jarak_ke_sekolah" required="" value="<?= $row['Jarak_Ke_Sekolah']; ?>">
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Riwayat Penyakit</label>
                                                            <textarea type="text" class="form-control" name="riwayat_penyakit" required="" style="height:80px"><?= $row['Riwayat_Penyakit']; ?></textarea>
                                                            <!-- Validation -->
                                                            <div class="valid-feedback"> Baguss! </div>
                                                            <div class="invalid-feedback"> Wajib Diisi! </div>
                                                            <!-- End Validation -->
                                                        </div>
                                                        <br>
                                                        <div class="modal-footer bg-whitesmoke br">
                                                            <button class="btn btn-primary" name="ubahDataSiswa">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- penutup Tambah Data -->
                                            <?php } ?>
                                            <!-- Penutup Data peserta -->
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>

            <!-- Penutup Isinya -->

            <!-- Fungsi untuk cetak -->
            <script type="text/javascript">
                function cetak(id) {
                    window.open("../cetak/index.php?id=" + id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=100,width=900,height=460");
                }
            </script>


            <!-- Footer -->

        </div>
        <footer class="main-footer">

        </footer>
    </div>
    </div>

</body>

</html>