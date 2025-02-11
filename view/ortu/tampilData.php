<!-- Header -->
<?php
$title = "Data Orang Tua"; // Page title
require("../template/header.php"); // Include the header
?>

<!-- Content Section -->

<section class="section">
    <div class="section-header">
        <h1><?= $title; ?></h1>
    </div>

    <?php
    // Display alert messages if any
    if (isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
    ?>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Form Filter Data -->
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
                            <button class="btn btn-primary mt-4">Filter</button>
                            <button class="btn btn-danger mt-4">Reset Filter</button>
                        </div>
                    </div>

                    <!-- Form Kepala Sekolah & NIP -->
                    <div class="col-12">
                        <div class="card">
                            <!-- Form Kepala Sekolah & NIP -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <form action="cetakData.php" method="POST" target="_blank">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kepala_sekolah">Nama Kepala Sekolah:</label>
                                                        <input type="text" class="form-control" name="kepala_sekolah" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nip">NIP Kepala Sekolah:</label>
                                                        <input type="text" class="form-control" name="nip" required>
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
                        </div>
                    </div>


                    <!-- Header -->
                    <div class="card-header">
                        <a href="tambahData.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
                            <i class="fas fa-plus"></i> Tambah Data Orang Tua
                        </a>
                    </div>

                    <!-- Tabel Data -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>NISN</th>
                                        <th>Nama Peserta</th>
                                        <th>Nama Ayah</th>
                                        <th>Nama Ibu</th>
                                        <th>Nama Wali</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('../../config/connection.php');
                                    $no = 1;
                                    $query = "SELECT NISN, Id_Orang_Tua_Wali, Nama_Peserta_Didik, Nama_Ayah, Nama_Ibu, Nama_Wali FROM orang_tua_wali 
                                  LEFT JOIN identitas_siswa ON orang_tua_wali.Id_Identitas_Siswa = identitas_siswa.Id_Identitas_Siswa";
                                    $data = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                    foreach ($data as $row) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $row['NISN']; ?></td>
                                            <td><?= $row['Nama_Peserta_Didik']; ?></td>
                                            <td><?= $row['Nama_Ayah']; ?></td>
                                            <td><?= $row['Nama_Ibu']; ?></td>
                                            <td><?= $row['Nama_Wali']; ?></td>
                                            <td class="text-center" width="120px">
                                                <a href="ubahData.php?id=<?= $row['Id_Orang_Tua_Wali']; ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="../../controller/admin/ortu.php?hapusData=<?= $row['Id_Orang_Tua_Wali']; ?>" class="btn btn-danger my-2" onclick="return confirm('Anda Yakin');"><i class="fas fa-trash"></i></a>
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
    // Filter function for date range
    function filterData() {
        var tanggalAwal = document.getElementById('tanggal_awal').value;
        var tanggalAkhir = document.getElementById('tanggal_akhir').value;

        $('#table-1 tbody tr').each(function() {
            var tanggalTabel = $(this).find('td:eq(6)').text();

            if (tanggalAwal <= tanggalTabel && tanggalTabel <= tanggalAkhir) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    // Reset function for date filter
    function resetFilter() {
        document.getElementById('tanggal_awal').value = '';
        document.getElementById('tanggal_akhir').value = '';
        $('#table-1 tbody tr').show();
    }

    $(document).ready(function() {
        $('#table-1').DataTable();
    });
</script>

<!-- Footer -->
<?php require("../template/footer.php"); ?>