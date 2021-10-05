<?php include "Header.php" ?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Menu Aktif</h1>
		<a>Data Pengguna</a>
	</div>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<form action="<?php echo site_url('superadmin/pengguna/simpan') ?>" method="post">
				<!-- <div class="modal-body"> -->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Lengkap</label>
							<input class="form-control" type="text" name="fullname" id="fullname" tabindex="1">
							<span style="color: red;"><?php echo form_error('fullname'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Level</label>
							<select name="level" id="level" class="form-control" tabindex="2">
								<option value="" disabled selected>--- Pilih ---</option>
								<option value="Superadmin">Superadmin</option>
								<option value="Admin">Admin</option>
							</select>
							<span style="color: red;"><?php echo form_error('level'); ?></span>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" type="email" name="email" id="email" tabindex="3">
							<span style="color: red;"><?php echo form_error('email'); ?></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input class="form-control" type="password" name="passwd" id="passwd" tabindex="4">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Jabatan</label>
							<input class="form-control" type="text" name="jabatan" id="jabatan" tabindex="5">
							<span style="color: red;"><?php echo form_error('jabatan'); ?></span>
						</div>
					</div>
				</div>
				<!-- </div> -->
				<input type="submit" class="btn btn-primary" tabindex="6" value="Simpan" />
				<a href="<?php echo base_url(); ?>superadmin/pengguna" class="btn btn-secondary" tabindex="7">Kembali</a>

			</form>
		</div>
	</div>

</div>
<!-- /.container-fluid -->
</div>

<!-- End of Main Content -->
<?php include "Footer.php" ?>

<script type="text/javascript">
	document.getElementById("fullname").focus();
</script>

<?php if ($this->session->flashdata('success')) : ?>

	<script type="text/javascript">
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});

		Toast.fire({
			type: 'success',
			title: 'Data berhasil disimpan'
		});
	</script>
<?php endif; ?>
</body>

</html>
