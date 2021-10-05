<?php include "Header.php" ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Menu Aktif</h1>
		<a>Data Pengguna</a>
	</div>
	<!-- Content Row -->

	<div class="card shadow mb-4">

		<div class="card-body">
			<form action="#" id="form" class="form-horizontal">
				<?php if (!empty($lihat)) { ?>
					<?php foreach ($lihat as $data) { //ngabsen data
					?>
						<input class="form-control" type="hidden" value="<?php echo $data['id_user'] ?>" name="id_user" />
						<!-- <div class="modal-body"> -->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input class="form-control" type="text" name="fullname" id="fullname" tabindex="1" value="<?php echo $data['fullname'] ?>" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="text" name="email" id="email" tabindex="2" value="<?php echo $data['email'] ?>" readonly>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Level</label>
									<input class="form-control" type="text" name="level" id="level" tabindex="3" value="<?php echo $data['level'] ?>" readonly>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Jabatan</label>
									<input class="form-control" type="text" name="jabatan" id="jabatan" tabindex="4" value="<?php echo $data['jabatan'] ?>" readonly>
								</div>
							</div>
						</div>
						<!-- </div> -->
					<?php } ?>
				<?php } else { ?>
					<h5 style="color: red; text-align: center">Data tidak ditemukan</h5>
				<?php } ?>
				<a href="<?php echo base_url(); ?>superadmin/pengguna" class="btn btn-secondary" tabindex="20">Kembali</a>
			</form>
		</div>

	</div>


	<!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include "Footer.php" ?>

</body>

</html>
