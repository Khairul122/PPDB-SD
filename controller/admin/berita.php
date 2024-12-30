<?php
session_start();
include "../../config/connection.php";

// Tambah Data
if (isset($_POST['tambahData'])) {
    // Ambil nilai dari formulir
    $judul_berita = mysqli_real_escape_string($conn, $_POST['judul_berita']);
    $isi_berita = mysqli_real_escape_string($conn, $_POST['isi_berita']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

    // Nilai iduser yang akan disimpan
    $iduser = 1;

    // Simpan data ke database dengan nilai iduser = 1
    $query = mysqli_query($conn, "INSERT INTO berita (judul_berita, isi_berita, tanggal, iduser) VALUES ('$judul_berita', '$isi_berita', '$tanggal', '$iduser')");

    // Periksa apakah query berhasil atau tidak
    if ($query) {
        $_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
			                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                    <div class="alert-body">
			                      <button class="close" data-dismiss="alert">
			                        <span>×</span>
			                      </button>
			                      <div class="alert-title">Berhasil</div>
			                      Data berhasil ditambahkan.
			                    </div>
			                  </div>';
        header('Location: ../../view/berita/tampilData.php');
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
			                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                    <div class="alert-body">
			                      <button class="close" data-dismiss="alert">
			                        <span>×</span>
			                      </button>
			                      <div class="alert-title">Gagal</div>
			                      Data gagal ditambahkan.
			                    </div>
			                  </div>';
        header('Location: ../../view/berita/tampilData.php');
    }
}


if (isset($_POST['ubahData'])) {
    // Ambil nilai dari formulir
    $id_berita = mysqli_real_escape_string($conn, $_POST['idberita']);
    $judul_berita = mysqli_real_escape_string($conn, $_POST['judul_berita']);
    $isi_berita = mysqli_real_escape_string($conn, $_POST['isi_berita']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

    // Update data ke database
    $query = mysqli_query($conn, "UPDATE berita SET judul_berita = '$judul_berita', isi_berita = '$isi_berita', tanggal = '$tanggal' WHERE idberita = '$id_berita'");

    // Periksa apakah query berhasil atau tidak
    if ($query) {
        $_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
			                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                    <div class="alert-body">
			                      <button class="close" data-dismiss="alert">
			                        <span>×</span>
			                      </button>
			                      <div class="alert-title">Berhasil</div>
			                      Data berhasil diubah.
			                    </div>
			                  </div>';
        header('Location: ../../view/berita/tampilData.php');
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
			                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                    <div class="alert-body">
			                      <button class="close" data-dismiss="alert">
			                        <span>×</span>
			                      </button>
			                      <div class="alert-title">Gagal</div>
			                      Data gagal diubah.
			                    </div>
			                  </div>';
        header('Location: ../../view/berita/tampilData.php');
    }

}

if (isset($_GET['hapusData'])) {
    $idberita = $_GET['hapusData'];

    $query = mysqli_query($conn, "DELETE FROM berita WHERE idberita = $idberita");

    if ($query) {
        $_SESSION['alert'] = '<div class="alert alert-success alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Berhasil</div>
			                          Data berhasil dihapus.
			                        </div>
			                      </div>';
        header('Location: ../../view/berita/tampilData.php');
    } else {
        $_SESSION['alert'] = '<div class="alert alert-danger alert-has-icon" id="alert">
			                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
			                        <div class="alert-body">
			                          <button class="close" data-dismiss="alert">
			                            <span>×</span>
			                          </button>
			                          <div class="alert-title">Gagal</div>
			                          Data gagal dihapus.
			                        </div>
			                      </div>';
        header('Location: ../../view/berita/tampilData.php');
    }
}
