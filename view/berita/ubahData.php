<!-- Header -->
<?php
$title = "Data Orang Tua"; // Judulnya
require "../template/header.php"; // include headernya

if (!isset($_GET['idberita'])) {
    echo "<script>window.location.href = 'tampilData.php';</script>";
}
?>



<!-- Isinya -->

<section class="section">
    <div class="section-header">
        <h1><?=$title;?></h1>
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
                        <a href="tampilData.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-primary text-white-all">
                                <li class="breadcrumb-item active" aria-current="page">Ubah Data Berita</li>
                            </ol>
                        </nav>

                        <?php
include '../../config/connection.php';
$data = mysqli_query($conn, "SELECT * FROM berita WHERE idberita = '$_GET[idberita]'") or die(mysqli_error($conn));

if (mysqli_num_rows($data) != 1) {
    echo "<script>window.location.href = 'tampilData.php';</script>";
}

foreach ($data as $row) {
    ?>



                            <!-- Ubah Data -->
                            <form class="needs-validation" novalidate="" action="../../controller/admin/berita.php" method="POST">
                                <div class="modal-body">
                                    <!-- Id data -->
                                    <input type="hidden" name="idberita" value="<?=$row['idberita'];?>">
                                    <div class="form-group">
                                        <label>Nama Berita</label>
                                        <input type="text" class="form-control" name="judul_berita" required="" value="<?=$row['judul_berita']?>">
                                        <!-- Validation -->
                                        <div class="valid-feedback">Bagus!</div>
                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                        <!-- End Validation -->
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Berita</label>
                                        <input type="text" class="form-control" name="isi_berita" required="" value="<?=$row['isi_berita']?>">
                                        <!-- Validation -->
                                        <div class="valid-feedback">Bagus!</div>
                                        <div class="invalid-feedback">Wajib Diisi!</div>
                                        <!-- End Validation -->
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" required="" value="<?=$row['tanggal']?>">
                                        <!-- Validation -->
                                        <div class="valid-feedback"> Baguss! </div>
                                        <div class="invalid-feedback"> Wajib Diisi! </div>
                                        <!-- End Validation -->
                                    </div>

                                    <br>
                                    <div class="modal-footer bg-whitesmoke br">
                                        <a href="tampilData.php" type="button" class="btn btn-secondary">Batal</a>
                                        <button class="btn btn-primary" name="ubahData">Simpan</button>
                                    </div>
                                </div>
                            </form>
                            <!-- penutup Tambah Data -->

                        <?php }?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Penutup Isinya -->



<!-- Footer -->
<?php require "../template/footer.php";?>
