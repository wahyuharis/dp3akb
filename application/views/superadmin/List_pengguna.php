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
		<div class="card-header py-3">
			<a href="<?php echo site_url('superadmin/pengguna/tambah') ?>" class="btn btn-light shadow-sm"><i class="fas fa-plus"></i> Tambah Pengguna</a>
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

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}

	function edit_user(id) {
		window.location.href = "<?php echo base_url() ?>superadmin/pengguna/edit/" + id;
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
		window.location.href = "<?php echo base_url() ?>superadmin/pengguna/lihat/" + data;
	}
</script>

</body>

</html>
