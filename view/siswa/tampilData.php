<?php
$title = "Data Siswa";
require("../template/header.php");
?>

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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="tambahData.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Data Siswa
                        </a>
                    </div>

                    <!-- Row baru untuk form Cetak Data -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input type="date" class="form-control" id="tanggal_awal">
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tanggal_akhir">
                            </div>
                            <div class="col-md-4 d-grid gap-2">
                                <button class="btn btn-primary mt-4" onclick="filterData()">Filter</button>
                                <button class="btn btn-danger mt-4" onclick="resetFilter()">Reset Filter</button>
                            </div>
                        </div>

                        <!-- Form untuk input Kepala Sekolah & NIP sebelum Cetak PDF -->
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
                                        <div class="text-left mt-1">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-print"></i> Cetak PDF
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Tabel Data Siswa -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>NISN</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('../../config/connection.php');
                                    $query = "SELECT Id_Identitas_Siswa, NISN, Nama_Peserta_Didik, Tanggal_Lahir, Alamat_Tinggal, tgl_ubah FROM identitas_siswa";
                                    $data = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                    $no = 1;
                                    foreach ($data as $row) {
                                        echo "<tr>
                                    <td class='text-center'>$no</td>
                                    <td>{$row['NISN']}</td>
                                    <td>{$row['Nama_Peserta_Didik']}</td>
                                    <td>{$row['Tanggal_Lahir']}</td>
                                    <td>{$row['Alamat_Tinggal']}</td>
                                    <td class='text-center'>
                                        <a href='ubahData.php?id={$row['Id_Identitas_Siswa']}' class='btn btn-warning'><i class='fas fa-pencil-alt'></i></a>
                                        <a href='../../controller/admin/siswa.php?hapusData={$row['Id_Identitas_Siswa']}' class='btn btn-danger my-2' onclick='return confirm(\"Anda Yakin\");'><i class='fas fa-trash'></i></a>
                                    </td>
                                </tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    $(document).ready(function() {
        $('#table-1').DataTable();

        function filterData() {
            var tanggalAwal = $('#tanggal_awal').val();
            var tanggalAkhir = $('#tanggal_akhir').val();

            $('#table-1 tbody tr').each(function() {
                var tanggalTabel = $(this).find('td:eq(5)').text();
                $(this).toggle(tanggalAwal <= tanggalTabel && tanggalTabel <= tanggalAkhir);
            });
        }

        function resetFilter() {
            $('#tanggal_awal, #tanggal_akhir').val('');
            $('#table-1 tbody tr').show();
        }

        window.filterData = filterData;
        window.resetFilter = resetFilter;
    });
</script>

<?php require("../template/footer.php"); ?>