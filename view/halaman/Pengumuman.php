<?php
session_start();

// Konfigurasi dasar
define('TITLE', 'Pendaftaran Peserta Didik Baru');
define('BASE_ASSETS', '../../assets/');

// Redirect jika belum login
if (!isset($_SESSION['namaPeserta'])) {
	header('Location: daftarSiswa.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title><?= TITLE ?> | PPDB</title>

	<!-- Favicon -->
	<link rel="icon" href="<?= BASE_ASSETS ?>img/avatar/icone.png">

	<!-- CSS Dependencies -->
	<link rel="stylesheet" href="<?= BASE_ASSETS ?>bootstrap-4/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= BASE_ASSETS ?>fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?= BASE_ASSETS ?>dataTables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= BASE_ASSETS ?>css/style.css">
	<link rel="stylesheet" href="<?= BASE_ASSETS ?>css/components.css">
</head>

<body>
	<div id="app">
		<div class="main-wrapper">
			<div class="navbar-bg"></div>

			<!-- Navigation Bar -->
			<?php if (isset($_SESSION['namaPeserta'])): ?>
				<nav class="navbar navbar-expand-lg main-navbar">
					<form class="form-inline mr-auto">
						<ul class="navbar-nav mr-3">
							<li>
								<a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
									<i class="fas fa-bars"></i>
								</a>
							</li>
						</ul>
					</form>

					<!-- User Profile -->
					<ul class="navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
								<img src="<?= BASE_ASSETS ?>img/avatar/avatar-1.png" alt="profile" class="rounded-circle mr-1">
								<div class="d-sm-none d-lg-inline-block"><?= htmlspecialchars($_SESSION['namaPeserta']) ?></div>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="../../controller/admin/daftar.php?logout" class="dropdown-item has-icon text-danger">
									<i class="fas fa-sign-out-alt"></i> Keluar
								</a>
							</div>
						</li>
					</ul>
				</nav>

				<!-- Sidebar -->
				<div class="main-sidebar">
					<aside id="sidebar-wrapper">
						<div class="sidebar-brand">
							<a href="">
								<img src="<?= BASE_ASSETS ?>img/avatar/icone.png" alt="Logo" width="30px"> PPDB
							</a>
						</div>
						<div class="sidebar-brand sidebar-brand-sm">
							<a href="">
								<img src="<?= BASE_ASSETS ?>img/avatar/icone.png" alt="Logo" width="47px">
							</a>
						</div>

						<!-- Menu Sidebar -->
						<ul class="sidebar-menu">
							<li class="menu-header">Menu</li>
							<li class="nav-item dropdown active">
								<a href="#" class="nav-link has-dropdown">
									<i class="fas fa-book"></i>
									<span>Pendaftar</span>
								</a>
								<ul class="dropdown-menu">
									<li><a class="nav-link" href="daftarSiswa.php">Data Siswa</a></li>
									<li class="active"><a class="nav-link" href="daftarOrtu.php">Data Orang Tua</a></li>
									<li class="active"><a class="nav-link" href="Pengumuman.php">Pengumuman</a></li>
								</ul>
							</li>
						</ul>

						<!-- Cetak Kartu -->
						<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
							<button class="btn btn-primary btn-lg btn-block btn-icon-split" onclick="cetakKartuPeserta(<?= $_SESSION['nisnPeserta'] ?>)">
								<i class="fas fa-sign-out-alt"></i> Cetak Kartu Peserta
							</button>
						</div>
					</aside>
				</div>
			<?php else: ?>
				<style>
					.main-content {
						padding-left: 30px;
					}

					.navbar {
						left: 30px;
					}
				</style>
			<?php endif; ?>

			<!-- Main Content -->
			<div class="main-content">
				<section class="section">
					<div class="section-header">
						<h1><?= TITLE ?></h1>
					</div>

					<?php if (isset($_SESSION['alert'])): ?>
						<?= $_SESSION['alert'] ?>
						<?php unset($_SESSION['alert']); ?>
					<?php endif; ?>

					<div class="section-body">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<a href="index.php" class="btn btn-primary daterange-btn icon-left btn-icon">
											<i class="fas fa-arrow-left"></i> Halaman Utama
										</a>
									</div>
									<?php
									require_once('../../config/connection.php');

									if (!isset($conn)) {
										die("Kesalahan: Koneksi database tidak tersedia");
									}
									?>

									<!-- Card Body dengan Form dan Hasil -->
									<div class="card-body">
										<div class="row">
											<div class="col-12 col-md-8 offset-md-2">
												<!-- Form Pencarian NISN dengan UI yang Diperbarui -->
												<div class="card">
													<div class="card-body">
														<h4 class="mb-4">Cek Status Kelulusan</h4>

														<form action="" method="post">
															<div class="form-group">
																<label for="NISN">Nomor Induk Siswa Nasional (NISN)</label>
																<div class="input-group">
																	<div class="input-group-prepend">
																		<span class="input-group-text">
																			<i class="fas fa-id-card"></i>
																		</span>
																	</div>
																	<input type="text"
																		class="form-control"
																		id="NISN"
																		name="NISN"
																		placeholder="Masukkan NISN Anda"
																		required>
																</div>
																<small class="text-muted">Masukkan NISN untuk memeriksa status kelulusan Anda</small>
															</div>
															<div class="text-center">
																<button type="submit" name="check" class="btn btn-primary">
																	<i class="fas fa-search"></i> Periksa Status
																</button>
															</div>
														</form>
														<?php
														if (isset($_POST['check'])) {
															try {
																$NISN = mysqli_real_escape_string($conn, $_POST['NISN']);

																// Query untuk mendapatkan data siswa dan status administrasi
																$query = "
            SELECT 
                identitas_siswa.NISN,
                identitas_siswa.Nama_Peserta_Didik,
                administrasi.status
            FROM 
                identitas_siswa
            LEFT JOIN 
                administrasi 
            ON 
                identitas_siswa.Id_Identitas_Siswa = administrasi.id_identitas_siswa
            WHERE 
                identitas_siswa.NISN = '$NISN'
        ";

																$result = mysqli_query($conn, $query);
																if ($result && mysqli_num_rows($result) > 0) {
																	$data = mysqli_fetch_assoc($result);
														?>
																	<div class="mt-4">
																		<div class="table-responsive">
																			<table class="table table-hover">
																				<thead>
																					<tr>
																						<th>No</th>
																						<th>Nama</th>
																						<th>NISN</th>
																						<th>Status</th>
																					</tr>
																				</thead>
																				<tbody>
																					<tr>
																						<td>1</td>
																						<td><?= htmlspecialchars($data['Nama_Peserta_Didik']) ?></td>
																						<td><?= htmlspecialchars($data['NISN']) ?></td>
																						<td>
																							<?php if (!empty($data['status'])): ?>
																								<?php if (strtolower($data['status']) == 'lolos'): ?>
																									<span class="badge badge-success" style="font-size: 14px; padding: 8px 12px; border-radius: 15px;">LOLOS</span>
																								<?php elseif (strtolower($data['status']) == 'tidak lolos'): ?>
																									<span class="badge badge-danger" style="font-size: 14px; padding: 8px 12px; border-radius: 15px;">TIDAK LOLOS</span>
																								<?php else: ?>
																									<span class="badge badge-secondary" style="font-size: 14px; padding: 8px 12px; border-radius: 15px;"><?= htmlspecialchars($data['status']) ?></span>
																								<?php endif; ?>
																							<?php else: ?>
																								<span class="badge badge-warning" style="font-size: 14px; padding: 8px 12px; border-radius: 15px;">BELUM VERIFIKASI</span>
																							<?php endif; ?>
																						</td>

																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																<?php
																} else {
																	// Debug output
																	var_dump([
																		'NISN' => $NISN,
																		'Query' => $query,
																		'Error' => mysqli_error($conn)
																	]);
																?>
																	<div class="alert alert-warning mt-4">
																		<i class="fas fa-exclamation-triangle mr-2"></i>
																		Data dengan NISN <?= htmlspecialchars($NISN) ?> tidak ditemukan.
																		<br>
																		Pastikan NISN yang Anda masukkan sudah benar.
																	</div>
																<?php
																}
															} catch (Exception $e) {
																error_log("PPDB Error: " . $e->getMessage());
																?>
																<div class="alert alert-danger mt-4">
																	<i class="fas fa-exclamation-circle mr-2"></i>
																	Terjadi kesalahan saat memproses data. Silakan coba beberapa saat lagi.
																</div>
														<?php
															}
														}
														?>
													</div>
												</div>
											</div>
										</div>
									</div>

									<style>
										.card {
											border-radius: 8px;
											box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
										}

										.btn-primary {
											background-color: #6c63ff;
											border-color: #6c63ff;
											padding: 10px 24px;
											border-radius: 4px;
										}

										.input-group-text {
											background-color: #f8f9fa;
											border-right: none;
										}

										.form-control {
											border-left: none;
										}

										.form-control:focus {
											box-shadow: none;
											border-color: #ced4da;
										}

										.alert {
											border-radius: 4px;
										}

										.badge {
											padding: 8px 12px;
											font-weight: 500;
											border-radius: 4px;
										}

										.table th {
											border-top: none;
											font-weight: 600;
										}
									</style>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>

			<footer class="main-footer">
				<!-- Footer content -->
			</footer>
		</div>
	</div>

	<!-- JavaScript Dependencies -->
	<script src="<?= BASE_ASSETS ?>bootstrap-4/js/jquery-3.3.1.min.js"></script>
	<script src="<?= BASE_ASSETS ?>bootstrap-4/js/popper.min.js"></script>
	<script src="<?= BASE_ASSETS ?>bootstrap-4/js/bootstrap.min.js"></script>
	<script src="<?= BASE_ASSETS ?>bootstrap-4/js/jquery.nicescroll.min.js"></script>
	<script src="<?= BASE_ASSETS ?>bootstrap-4/js/moment.min.js"></script>
	<script src="<?= BASE_ASSETS ?>js/stisla.js"></script>
	<script src="<?= BASE_ASSETS ?>dataTables/js/jquery.dataTables.js"></script>
	<script src="<?= BASE_ASSETS ?>dataTables/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= BASE_ASSETS ?>js/scripts.js"></script>
	<script src="<?= BASE_ASSETS ?>js/custom.js"></script>

	<script>
		function cetakKartuPeserta(id) {
			window.open(`../cetak/index.php?id=${id}`, "_blank",
				"toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=100,width=900,height=460");
		}
	</script>
</body>

</html>