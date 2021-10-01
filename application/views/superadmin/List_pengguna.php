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
		<div class="card-header py-3" id="judulBtn">
			<button class="btn btn-light shadow-sm" onclick="add_pengguna()"><i class="fas fa-plus"></i> Tambah Pengguna</button>
		</div>
		<div class="card-body" id="form-data" style="display:none;">
			<form action="#" id="form" class="form-horizontal">
				<input type="hidden" value="" name="id_user" />
				<!-- <div class="modal-body"> -->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Lengkap</label>
							<input class="form-control" type="text" name="fullname" id="fullname" tabindex="1">
							<span class="help-block" style="color: red;"></span>
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
							<span class="help-block" style="color: red;"></span>
						</div>
					</div>
                    
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" type="email" name="email" id="email" tabindex="3">
							<span class="help-block" style="color: red;"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Password</label>
							<input class="form-control" type="password" name="passwd" id="passwd" tabindex="4">
							<input class="form-control" type="hidden" name="passwdlama" id="passwdlama" readonly>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Jabatan</label>
                            <input class="form-control" type="text" name="jabatan" id="jabatan" tabindex="5">
							<span class="help-block" style="color: red;"></span>
						</div>
					</div>
				</div>	
				<!-- </div> -->
                <button type="button" class="btn btn-primary" id="btnSave" onclick="save()" tabindex="6">Simpan</button>
				<button type="button" name="btnBatal" id="btnBatal" class="btn btn-secondary" tabindex="7">Tutup</button>
				
			</form>
		</div>

	</div>
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<button class="btn btn-light shadow-sm" onclick="reload_table()"><i class="fas fa-sync"></i> Refresh Data</button>
		</div>



		<div class="card-body">
			<div class="table-responsive">
				<table id="mytable" class="table table-bordered nowrap" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Fullname</th>
							<th>Email</th>
							<th>Jabatan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Fullname</th>
							<th>Email</th>
							<th>Jabatan</th>
							<th>Aksi</th>
						</tr>
					</tfoot>
					<tbody>

					</tbody>
				</table>

			</div>
		</div>
	</div>

</div>
<!-- /.container-fluid -->
</div>

<!-- End of Main Content -->
<?php include "Footer.php" ?>

<script type="text/javascript">
	var save_method; //for save method string
	var table;
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000
	});

	$("#btnBatal").click(function() {
		$('#form-data').slideUp(500);
		$('html, body').animate({
			scrollTop: 0
		}, 'slow');
		$('#judulBtn').html('<button class="btn btn-light shadow-sm" onclick="add_pengguna()"><i class="fas fa-plus"></i> Tambah Pengguna</button>');

	});

	$(document).ready(function() {
		//datatables
		table = $('#mytable').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('superadmin/pengguna/ajax_list') ?>",
				"type": "POST"
			},

			"language": {
				"infoFiltered": ""
			},

			//Set column definition initialisation properties.
			"columnDefs": [{
					"targets": [0], //first column
					"orderable": false, //set not orderable
				},
				{
					"targets": [-1], //second column
					"orderable": false, //set not orderable
				}
			],

		});

		//set input/textarea/select event when change value, remove class error and remove text help block 
		$("input").change(function() {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});
		$("select").change(function() {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});
		$("textarea").change(function() {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});

	});

	function add_pengguna() {
		save_method = 'add';
		$('#form-data').slideToggle(500);
		$('#form')[0].reset(); // reset form on modals
		document.getElementById("fullname").focus();
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
	}

	function edit_user(id) {
		save_method = 'update';
		$('#form-data').slideToggle(500);
		$('html, body').animate({
			scrollTop: 0
		}, 'slow');
		$('#form')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$('#judulBtn').html('<b> Edit Pengguna </b>');
		$('#btnSave').text('Update');
		//Ajax Load data from ajax
		$.ajax({
			url: "<?php echo site_url('superadmin/pengguna/ajax_edit/') ?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data) {

				$('[name="id_user"]').val(data.id_user);
				$('[name="fullname"]').val(data.fullname);
				$('[name="level"]').val(data.level);
				$('[name="email"]').val(data.email);
				$('[name="passwd"]').val();
				$('[name="passwdlama"]').val(data.password);
				$('[name="jabatan"]').val(data.jabatan);

			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}

	function save() {
		$('#btnSave').text('Proses...'); //change button text
		$('#btnSave').attr('disabled', true); //set button disable 
		var url;

		if (save_method == 'add') {
			url = "<?php echo site_url('superadmin/pengguna/ajax_add') ?>";
		} else if (save_method == 'update') {
			url = "<?php echo site_url('superadmin/pengguna/ajax_update') ?>";
		}

		// ajax adding data to database
		var formData = new FormData($('#form')[0]);
		$.ajax({
			url: url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			dataType: "JSON",
			success: function(data) {

				if (data.status) //if success close modal and reload ajax table
				{
					$('#form-data').slideUp(500);
					$('html, body').animate({
						scrollTop: 0
					}, 'slow');
					$('#judulBtn').html('<button class="btn btn-light shadow-sm" onclick="add_pengguna()"><i class="fas fa-plus"></i> Tambah Pengguna</button>');
					reload_table();
					Toast.fire({
						type: 'success',
						title: 'Data berhasil disimpan'
					});
				} else {
					for (var i = 0; i < data.inputerror.length; i++) {
						$('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
						$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
					}
				}
				$('#btnSave').text('Simpan'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 


			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
				$('#btnSave').text('Simpan'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 

			}
		});
	}


	function hapus_user(id) {
		if (confirm('Apakah Anda yakin menghapus data ini?')) {
			// ajax delete data to database
			$.ajax({
				url: "<?php echo site_url('superadmin/pengguna/ajax_delete') ?>/" + id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					//if success reload ajax table
					reload_table();
					Toast.fire({
						type: 'success',
						title: 'Data berhasil dihapus'
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				}
			});

		}
	}

	function lihat_user(data) {
		window.location = "pengguna/lihat/" + data;
	}
</script>

</body>

</html>
