<?php include "Header.php" ?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Menu Aktif</h1>
    <a>Data Laporan Korban Anak-anak</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
	<button class="btn btn-light shadow-sm" onclick="reload_table()"><i class="fas fa-sync"></i> Refresh Data</button>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table id="mytable" class="table table-bordered nowrap" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>No.</th>
						<th>Keterangan Pengaduan</th>
						<th>Nama Korban</th>
						<th>No. HP Korban</th>
						<th>No. HP Pelapor</th>
						<th>Alamat Korban</th>
						<th>Status Pengaduan</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>No.</th>
						<th>Keterangan Pengaduan</th>
						<th>Nama Korban</th>
						<th>No. HP Korban</th>
						<th>No. HP Pelapor</th>
						<th>Alamat Korban</th>
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
				"type": "POST"
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
				$('.modal-title').text('Edit Status Laporan'); // Set title to Bootstrap modal title

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
						title: 'Status laporan berhasil diubah'
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

	function lihat_laporan(data) {
		window.location = "anak/lihat_detail/" + data;
	}
</script>

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
