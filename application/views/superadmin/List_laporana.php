<?php include "Header.php" ?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Menu Aktif</h1>
		<a>Data Pengaduan Korban Anak-anak</a>
	</div>

	<?php if ($this->session->flashdata('success')) : ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php echo $this->session->flashdata('success'); ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<div class="card shadow mb-4">
		<!-- Card Header - Accordion -->
		<a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
			<h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
		</a>
		<!-- Card Content - Collapse -->
		<div class="collapse show" id="collapseCardExample">
			<div class="card-body">
				<form id="form-filter" class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Berdasarkan Status Pengaduan</label>
								<select name="dicari" id="dicari" class="form-control" tabindex="2">
									<option value="0" disabled selected>--- Pilih ---</option>
									<option value="1">Selesai ditangani</option>
									<option value="2">Belum ditangani</option>
									<option value="3">Dalam proses</option>
								</select>
							</div>
						</div>
					</div>
					<button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
					<button type="button" id="btn-reset" class="btn btn-secondary">Reset</button>
				</form>
			</div>
		</div>
	</div>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<button class="btn btn-light shadow-sm" onclick="reload_table()"><i class="fas fa-sync"></i> Refresh Data</button>
			<button class="btn btn-light shadow-sm" onclick="ex_data()"><i class="fas fa-download"></i> Export Excel</button>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="mytable" class="table table-bordered nowrap" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No.</th>
							<th>Keterangan Pengaduan</th>
							<th>Nama Korban</th>
							<th>Umur Korban</th>
							<th>No. HP Pelapor</th>
							<th>Status Pengaduan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No.</th>
							<th>Keterangan Pengaduan</th>
							<th>Nama Korban</th>
							<th>Umur Korban</th>
							<th>No. HP Pelapor</th>
							<th>Status Pengaduan</th>
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
				"url": "<?php echo site_url('superadmin/anak/ajax_list') ?>",
				"type": "POST",
				"data": function(data) {
					data.dicari = $('#dicari').val();
				}
			},

			"language": {
				"infoFiltered": ""
			},

			//Set column definition initialisation properties.
			"columnDefs": [{
					"targets": [-1], //first column
					"orderable": false, //set not orderable
				},
				{
					"targets": [0], //second column
					"orderable": false, //set not orderable
				}
			],

		});

		//set input/textarea/select event when change value, remove class error and remove text help block 
		$('#btn-filter').click(function() { //button filter event click
			table.ajax.reload(); //just reload table
		});
		$('#btn-reset').click(function() { //button reset event click
			$('#form-filter')[0].reset();
			table.ajax.reload(); //just reload table
		});
	});


	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}

	function hapus_laporan(id) {
		if (confirm('Apakah Anda yakin menghapus data ini?')) {
			// ajax delete data to database
			$.ajax({
				url: "<?php echo site_url('superadmin/anak/ajax_delete') ?>/" + id,
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

	function update_laporan(id) {
		save_method = 'upstatus';
		$('#form_up')[0].reset(); // reset form on modals

		//Ajax Load data from ajax
		$.ajax({
			url: "<?php echo site_url('superadmin/anak/ajax_edit/') ?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function(data) {

				$('[name="id_korban"]').val(data.id_korban);
				$('[name="status_laporan"]').val(data.status_laporan);
				$('#modal_form_up').modal('show'); // show bootstrap modal when complete loaded
				$('.modal-title').text('Edit Status Pengaduan'); // Set title to Bootstrap modal title

			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}

	function up_status() {
		$('#btnUp').text('Proses...'); //change button text
		$('#btnUp').attr('disabled', true); //set button disable 
		var url;

		if (save_method == 'upstatus') {
			url = "<?php echo site_url('superadmin/anak/ajax_upstatus') ?>";
		}

		// ajax adding data to database
		var formData = new FormData($('#form_up')[0]);
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

					$('#modal_form_up').modal('hide');
					reload_table();
					Toast.fire({
						type: 'success',
						title: 'Status pengaduan berhasil diubah'
					});

				}
				$('#btnUp').text('Simpan'); //change button text
				$('#btnUp').attr('disabled', false); //set button enable 


			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
				$('#btnUp').text('Simpan'); //change button text
				$('#btnUp').attr('disabled', false); //set button enable 

			}
		});
	}

	function ex_data() {
		save_method = 'add';
		$('#form')[0].reset(); // reset form on modals
		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		$('#modal_form').modal('show'); // show bootstrap modal
		$('.modal-title').text('Export Data Pengaduan'); // Set Title to Bootstrap modal title
	}

	function lihat_laporan(data) {
		window.location.href = "<?php echo base_url() ?>superadmin/anak/lihat_detail/" + data;
	}
</script>

<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Export Data Pengaduan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo base_url('superadmin/anak/excel') ?>" id="form" class="form-horizontal" method="post">
				<input type="hidden" value="" name="id_korban" />
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>dari Tanggal</label>
								<input type="date" name="tgl1" id="tgl1" class="form-control" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>sampai Tanggal</label>
								<input type="date" name="tgl2" id="tgl2" class="form-control" required />
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="btnDownload">Download</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_form_up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Status Pengaduan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="#" id="form_up" class="form-horizontal">
				<input type="hidden" value="" name="id_korban" />
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Keterangan</label>
								<select name="status_laporan" id="status_laporan" class="form-control">
									<option value="1">Selesai ditangani</option>
									<option value="2">Belum ditangani</option>
									<option value="3">Dalam Proses</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="btnUp" onclick="up_status()">Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</form>
		</div>
	</div>
</div>

</body>

</html>
