<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Lapor extends RestController
{

	function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->database();
	}

	//Menampilkan data pelapor terakhir
	function index_get()
	{
		$data = array();
		$message = 'succes';
		$status = true;
		$response = array();

		$device_id = $this->input->get('device_id');
		$this->load->model('Lapor_model');
		$lapor_model = new Lapor_model();

		$data = $lapor_model->pelapor_last_data($device_id);

		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}

	function save_post()
	{
		$data = array();
		$message = 'succes';
		$status = true;
		$response = array();

		$post = $this->input->post();


		$foto_ktp = null;
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 5000;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('ktp')) {
			$error = array('error' => $this->upload->display_errors());
		} else {
			$foto_ktp = $this->upload->data('file_name');
		}


		if (empty($foto_ktp) && !empty(trim($this->input->post('ktp_old')))) {
			$foto_ktp = $this->input->post('ktp_old');
		}


		$pelapor = array(
			'device_id' => $this->input->post('device_id'),
			'nama_pelapor' => $this->input->post('nama'),
			'jkel_pelapor' => $this->input->post('jenis_kelamin'),
			'umur_pelapor' => $this->input->post('umur'),
			'nohp_pelapor' => $this->input->post('no_telp'),
			'alamat_pelapor' => $this->input->post('alamat'),
			'foto_ktp' => $foto_ktp,
		);

		$korban = array(
			'nama_korban' => $this->input->post('nama_korban'),
			'jkel_korban' => $this->input->post('jenis_kelamin_korban'),
			'umur_korban' => $this->input->post('umur_korban'),
			'nohp_korban' => $this->input->post('no_telp_korban'),
			'alamat_korban' => $this->input->post('alamat_korban'),
			'jenis_korban' => $this->input->post('jenis_korban'),
			'id_pelapor' => '',
			//'id_jenis_aduan' => $this->input->post('keterangan_pengaduan'),
			'aduan_lain' => $this->input->post('keterangan_lain'),
			'status_laporan' => 2,
		);

		$keterangan_pengaduan = $this->input->post('keterangan_pengaduan');

		if (is_array($keterangan_pengaduan)) {
			$korban['aduan_lain'] = NULL;
		}

		$this->db->insert('pelapor', $pelapor);
		$id_pelapor = $this->db->insert_id();

		//if ($korban['id_jenis_aduan'] == 'etc') {
		$korban['id_jenis_aduan'] = null;
		//}

		$korban['id_pelapor'] = $id_pelapor;
		$this->db->insert('korban', $korban);
		$id_korban = $this->db->insert_id();

		// if (!empty($keterangan_pengaduan) || count($keterangan_pengaduan) > 0) {
		if (is_array($keterangan_pengaduan)) {
			foreach ($keterangan_pengaduan as $id_jenis_aduanrel) {
				$korban_jenis_pengaduan_rel = array(
					'id_korban' => $id_korban,
					'id_jenis_aduan' => $id_jenis_aduanrel
				);
				$this->db->insert('korban_jenis_pengaduan_rel', $korban_jenis_pengaduan_rel);
			}
		}

		$data = array(
			'korban' => $korban,
			'pelapor' => $pelapor
		);

		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status,
			// 'status' => false

		);

		$this->response($response, 200);
	}
}
