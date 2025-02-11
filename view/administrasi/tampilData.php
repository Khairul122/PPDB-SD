<!-- Header -->
<?php
$title = "Administrasi"; // Judulnya
require("../template/header.php"); // include headernya
?>



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
                    <div class="section-body">
                        <div class="row mb-3 col-12 pt-2">
                            <div class="col-md-4">
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal">
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary mt-4" onclick="filterData()">Filter</button>
                                <button class="btn btn-danger mt-4" onclick="resetFilter()">Reset Filter</button>
                            </div>
                        </div>

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <a href="tambahData.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
                                <i class="fas fa-plus"></i> Tambah Data Administrasi
                            </a>
                        </div>

                        <!-- Form Kepala Sekolah & NIP -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <form action="cetakData.php" method="GET" target="_blank">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kepala_sekolah">Nama Kepala Sekolah:</label>
                                                    <input type="text" class="form-control" name="kepala_sekolah" id="kepala_sekolah" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nip">NIP Kepala Sekolah:</label>
                                                    <input type="text" class="form-control" name="nip" id="nip" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-left mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-print"></i> Cetak PDF
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> No </th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Status Pendaftaran</th>
                                            <th>Tanggal Ubah</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include('../../config/connection.php');

                                        $no = 1;
                                        $data = mysqli_query($conn, "SELECT a.*, b.NISN, b.Nama_Peserta_Didik FROM administrasi a
                                              LEFT JOIN identitas_siswa b
                                              ON a.id_identitas_siswa = b.Id_Identitas_Siswa") or die(mysqli_error($conn));
                                        foreach ($data as $row) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td><?= $row['NISN']; ?></td>
                                                <td><?= $row['Nama_Peserta_Didik']; ?></td>
                                                <td><?= $row['status']; ?></td>
                                                <td><?= $row['tgl_ubah']; ?></td>
                                                <td class="text-center" width="120px">
                                                    <a href="ubahData.php?id=<?= $row['id_administrasi']; ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="../../controller/admin/administrasi.php?hapusData=<?= $row['id_administrasi']; ?>" class="btn btn-danger my-2" onclick="return confirm('Anda Yakin');"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table-1').DataTable();
    });
</script>

<script type="text/javascript">
    // Fungsi untuk memfilter data berdasarkan tanggal
    function filterData() {
        var tanggalAwal = document.getElementById('tanggal_awal').value; // Menggunakan ID yang benar
        var tanggalAkhir = document.getElementById('tanggal_akhir').value; // Menggunakan ID yang benar

        // Loop melalui semua baris dalam tabel
        $('#table-1 tbody tr').each(function() {
            var tanggalTabel = $(this).find('td:eq(4)').text(); // Ambil tanggal dari kolom ke-4

            // Jika tanggal dalam rentang yang dipilih, tampilkan baris, jika tidak, sembunyikan
            if (tanggalAwal <= tanggalTabel && tanggalTabel <= tanggalAkhir) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Fungsi untuk mereset filter
    function resetFilter() {
        // Bersihkan nilai input tanggal
        document.getElementById('tanggal_awal').value = ''; // Menggunakan ID yang benar
        document.getElementById('tanggal_akhir').value = ''; // Menggunakan ID yang benar

        // Tampilkan kembali semua baris dalam tabel
        $('#table-1 tbody tr').show();
    }

    $(document).ready(function() {
        $('#table-1').DataTable();
    });
</script>


<!-- Penutup Isinya -->



<!-- Footer -->
<?php require("../template/footer.php"); ?>