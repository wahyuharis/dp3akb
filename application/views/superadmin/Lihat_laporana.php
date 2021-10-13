<?php include "Header.php" ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Menu Aktif</h1>
		<a>Data Pengaduan Korban Anak-anak</a>
	</div>
	<!-- Content Row -->

	<div class="card shadow mb-4">
		<?php if (!empty($lihat)) { ?>
			<?php foreach ($lihat as $data) { //ngabsen data
			?>
				<?php if ($data['status_laporan'] == 1) { ?>
					<div class="card border-left-success shadow h-100 py-2">
					<?php } elseif ($data['status_laporan'] == 2) { ?>
						<div class="card border-left-danger shadow h-100 py-2">
						<?php } else { ?>
							<div class="card border-left-warning shadow h-100 py-2">
							<?php } ?>
							<div class="card-body">
								<form action="#" id="form" class="form-horizontal">

									<input class="form-control" type="hidden" value="<?php echo $data['id_korban'] ?>" name="id_korban" />
									<!-- <div class="modal-body"> -->

									<h5 style="font-weight:bold">Data Pelapor</h5>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Nama Pelapor</label>
												<input class="form-control" type="text" name="nama_pelapor" id="nama_pelapor" tabindex="1" value="<?php echo $data['nama_pelapor'] ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Jenis Kelamin</label>
												<?php if ($data['jkel_pelapor'] == "L") { ?>
													<input class="form-control" type="text" name="jkel_pelapor" id="jkel_pelapor" tabindex="2" value="Laki-laki" readonly>
												<?php } else { ?>
													<input class="form-control" type="text" name="jkel_pelapor" id="jkel_pelapor" tabindex="2" value="Perempuan" readonly>
												<?php } ?>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Umur Pelapor</label>
												<input class="form-control" type="text" name="umur_pelapor" id="umur_pelapor" tabindex="3" value="<?php echo $data['umur_pelapor'] . " Tahun" ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>No. HP Pelapor</label>
												<input class="form-control" type="text" name="nohp_pelapor" id="nohp_pelapor" tabindex="4" value="<?php echo $data['nohp_pelapor'] ?>" readonly>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Alamat Pelapor</label>
												<input class="form-control" type="text" name="alamat_pelapor" id="alamat_pelapor" tabindex="5" value="<?php echo $data['alamat_pelapor'] ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Foto KTP Pelapor</label><br>
												<?php if ($data['foto_ktp'] == NULL) { ?>
													<h6 style="color:red">Tidak Ada Foto KTP</h6>
												<?php } else { ?>
													<a href="<?php echo base_url('uploads/' . $data['foto_ktp']) ?>" target="_blank">Lihat Foto KTP</a>
												<?php } ?>
											</div>
										</div>
									</div>
									<br>
									<h5 style="font-weight:bold">Data Korban</h5>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Nama Korban</label>
												<input class="form-control" type="text" name="nama_korban" id="nama_korban" tabindex="6" value="<?php echo $data['nama_korban'] ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Jenis Kelamin</label>
												<?php if ($data['jkel_korban'] == "L") { ?>
													<input class="form-control" type="text" name="jkel_korban" id="jkel_korban" tabindex="7" value="Laki-laki" readonly>
												<?php } else { ?>
													<input class="form-control" type="text" name="jkel_korban" id="jkel_korban" tabindex="7" value="Perempuan" readonly>
												<?php } ?>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Umur Korban</label>
												<input class="form-control" type="text" name="umur_korban" id="umur_korban" tabindex="8" value="<?php echo $data['umur_korban'] . " Tahun" ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>No. HP Korban</label>
												<?php if ($data['nohp_korban'] == NULL || $data['nohp_korban'] == "") { ?>
													<input class="form-control" type="text" name="nohp_korban" id="nohp_korban" tabindex="9" value="-" readonly>
												<?php } else { ?>
													<input class="form-control" type="text" name="nohp_korban" id="nohp_korban" tabindex="9" value="<?php echo $data['nohp_korban'] ?>" readonly>
												<?php } ?>

											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Alamat Korban</label>
												<?php if ($data['alamat_korban'] == NULL || $data['alamat_korban'] == "") { ?>
													<input class="form-control" type="text" name="alamat_korban" id="alamat_korban" tabindex="10" value="-" readonly>
												<?php } else { ?>
													<input class="form-control" type="text" name="alamat_korban" id="alamat_korban" tabindex="10" value="<?php echo $data['alamat_korban'] ?>" readonly>
												<?php } ?>
											</div>
										</div>
									</div>
									<br>
									<h5 style="font-weight:bold">Lain-lain</h5>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Keterangan Pengaduan</label>
												<?php if ($data['aduan_lain'] == NULL && $data['id_jenis_aduan'] != NULL) { ?>
													<input class="form-control" type="text" name="keterangan_pengaduan" id="keterangan_pengaduan" tabindex="11" value="<?php echo $data['keterangan'] ?>" readonly>
												<?php } else if ($data['aduan_lain'] != NULL && $data['id_jenis_aduan'] == NULL) { ?>
													<input class="form-control" type="text" name="keterangan_pengaduan" id="keterangan_pengaduan" tabindex="11" value="<?php echo $data['aduan_lain'] ?>" readonly>
												<?php } else { ?>
													<ul>
														<?php foreach ($list as $data21) { //ngabsen data
														?>

															<li><?php echo $data21['keterangan']; ?></li>

														<?php } ?>
													</ul>
												<?php } ?>
											</div>
										</div>

									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Status Pengaduan</label>
												<?php if ($data['status_laporan'] == 1) {
													$ket = "Selesai ditangani";
												} else if ($data['status_laporan'] == 2) {
													$ket = "Belum ditangani";
												} else {
													$ket = "Dalam proses";
												}
												?>
												<input class="form-control" type="text" name="status_pengaduan" id="status_pengaduan" tabindex="12" value="<?php echo $ket ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Tanggal Pengaduan</label>
												<?php $initgl = date('Y-m-d', strtotime($data['created_at'])) ?>
												<input class="form-control" type="text" name="tgl_pengaduan" id="tgl_pengaduan" tabindex="13" value="<?php echo tanggal($initgl); ?>" readonly>
											</div>
										</div>
									</div>
									<!-- </div> -->
									<a href="<?php echo base_url(); ?>superadmin/anak" class="btn btn-secondary" tabindex="14">Kembali</a>
								</form>
							</div>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="card-body">
							<h5 style="color: red; text-align: center">Data tidak ditemukan</h5>
						</div>
						<a href="<?php echo base_url(); ?>superadmin/anak" class="btn btn-secondary">Kembali</a>
					<?php } ?>
						</div>

						<!-- Content Row -->

					</div>
					<!-- /.container-fluid -->

	</div>
	<!-- End of Main Content -->
	<?php include "Footer.php" ?>

	</body>

	</html>
