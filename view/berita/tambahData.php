<!-- Header -->
<?php
$title = "Data Siswa"; // Judulnya
require "../template/header.php"; // include headernya
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

                        <div class="section-title mt-0 ml-4">Tambah Data Berita</div>

                        <!-- Tambah Data -->
                        <form class="needs-validation" novalidate="" action="../../controller/admin/berita.php" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Judul Berita</label>
                                    <input type="text" class="form-control" name="judul_berita" required="">
                                    <!-- Validation -->
                                    <div class="valid-feedback"> Baguss! </div>
                                    <div class="invalid-feedback"> Wajib Diisi! </div>
                                    <!-- End Validation -->
                                </div>
                                <div class="form-group">
                                    <label>Isi Berita</label>
                                    <textarea class="form-control" name="isi_berita" rows="5" required=""></textarea>
                                    <!-- Validation -->
                                    <div class="valid-feedback">Bagus!</div>
                                    <div class="invalid-feedback">Wajib Diisi!</div>
                                    <!-- End Validation -->
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" required="">
                                    <!-- Validation -->
                                    <div class="valid-feedback"> Baguss! </div>
                                    <div class="invalid-feedback"> Wajib Diisi! </div>
                                    <!-- End Validation -->
                                </div>

                                <br>
                                <div class="modal-footer bg-whitesmoke br">
                                    <a href="tampilData.php" type="button" class="btn btn-secondary">Batal</a>
                                    <button class="btn btn-primary" name="tambahData">Simpan</button>
                                </div>
                            </div>
                        </form>
                        <!-- penutup Tambah Data -->

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
