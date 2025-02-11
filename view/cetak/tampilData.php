<!-- Header -->
<?php
$title = "Cetak Kartu"; // Judulnya
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
                    <div class="card-body">
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

                        <!-- Form Kepala Sekolah dan NIP -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <form id="formKepsek">
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
                                            <button type="button" class="btn btn-info" onclick="updateURL()">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Data -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Status Pendaftaran</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('../../config/connection.php');

                                    $no = 1;
                                    $data = mysqli_query($conn, "SELECT a.*, b.NISN, b.Nama_Peserta_Didik, b.Id_Identitas_Siswa 
                                                                 FROM administrasi a
                                                                 RIGHT JOIN identitas_siswa b
                                                                 ON a.id_identitas_siswa = b.Id_Identitas_Siswa") or die(mysqli_error($conn));
                                    foreach ($data as $row) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><?= $row['NISN']; ?></td>
                                            <td><?= $row['Nama_Peserta_Didik']; ?></td>
                                            <td>
                                                <?= ($row['status'] == NULL) ? 'Belum Di Konfirmasi' : $row['status']; ?>
                                            </td>
                                            <td>
                                                <?= ($row['tgl_ubah'] == NULL) ? '-' : $row['tgl_ubah']; ?>
                                            </td>
                                            <td class="text-center" width="120px">
                                                <a href="#" class="btn btn-primary" onclick="cetak(<?= $row['NISN']; ?>)">
                                                    <i class="fas fa-print"></i>
                                                </a>
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

<script>
// Fungsi untuk memperbarui URL dengan Nama Kepala Sekolah & NIP
function updateURL() {
    let kepalaSekolah = document.getElementById("kepala_sekolah").value;
    let nip = document.getElementById("nip").value;

    if (kepalaSekolah && nip) {
        let newURL = window.location.pathname + "?kepala_sekolah=" + encodeURIComponent(kepalaSekolah) + "&nip=" + encodeURIComponent(nip);
        window.history.pushState({}, '', newURL);
    } else {
        alert("Silakan isi Nama Kepala Sekolah dan NIP.");
    }
}

// Fungsi untuk cetak data berdasarkan NISN dan mengambil Nama Kepala Sekolah & NIP dari URL
function cetak(nisn) {
    let urlParams = new URLSearchParams(window.location.search);
    let kepalaSekolah = urlParams.get('kepala_sekolah') || "NAMA KEPALA SEKOLAH";
    let nip = urlParams.get('nip') || "19XXXXXXXXX";

    let cetakURL = "index.php?nisn=" + nisn + "&kepala_sekolah=" + encodeURIComponent(kepalaSekolah) + "&nip=" + encodeURIComponent(nip);
    window.open(cetakURL, "_blank");
}

// Fungsi untuk memfilter data berdasarkan tanggal
function filterData() {
    var tanggalAwal = document.getElementById('tanggal_awal').value;
    var tanggalAkhir = document.getElementById('tanggal_akhir').value;

    $('#table-1 tbody tr').each(function() {
        var tanggalTabel = $(this).find('td:eq(4)').text().trim();
        
        if (tanggalTabel === '-' || (tanggalAwal <= tanggalTabel && tanggalTabel <= tanggalAkhir)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

// Fungsi untuk mereset filter
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
