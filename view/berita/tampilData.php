<!-- Header -->
<?php
$title = "Data Berita"; // Judulnya
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
                    <div class="row mb-3 col-12 pt-2">

                    </div>
                    <div class="card-header">
                        <!-- <h4>Basic DataTables</h4> -->
                        <a href="tambahData.php" type="button" class="btn btn-primary daterange-btn icon-left btn-icon">
                            <i class="fas fa-plus"></i> Tambah Data Berita
                        </a>
                    </div>
                    <div class="card-body">

                        <!-- tabelnya -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center"> No </th>
                                        <th>Judul Berita</th>
                                        <th>Isi Berita</th>
                                        <th>Tanggal</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
include '../../config/connection.php';

$no = 1;
$data = mysqli_query($conn, "SELECT * FROM berita") or die(mysqli_error($conn));
foreach ($data as $row) {
    ?>
                                    <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td><?=$row['judul_berita'];?></td>
                                            <td><?=$row['isi_berita'];?></td>
                                            <td><?=$row['tanggal'];?></td>
                                            <td class="text-center" width="120px">
                                                <!-- Tambahkan tombol tampilkan detail jika dibutuhkan -->
                                                <!-- <a href="#" class="btn btn-success my-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-eye"></i></a> -->
                                                <!-- Tambahkan tombol ubah data -->
                                                <a href="ubahData.php?idberita=<?=$row['idberita'];?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                                <!-- Tambahkan tombol hapus data -->
                                                <a href="../../controller/admin/berita.php?hapusData=<?=$row['idberita'];?>" class="btn btn-danger my-2" onclick="return confirm('Anda Yakin');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>

                            <!-- penutup tabelnya -->

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
            var tanggalTabel = $(this).find('td:eq(5)').text(); // Ambil tanggal dari kolom ke-4

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
<?php require "../template/footer.php";?>
