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

	//Menampilkan data kontak
	function index_get()
	{
		$data = array();
		$message = 'succes';
		$status = true;
		$response = array();

		$id = $this->get('id_korban');
		if ($id == '') {
			$data = $this->db->get('korban')->result();
		} else {
			$this->db->where('id_korban', $id);
			$data = $this->db->get('korban')->result();
		}

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
		$data = $post;

		$pelapor = array(
			'nama_pelapor' => $this->input->post('nama'),
			'jkel_pelapor' => $this->input->post('jenis_kelamin'),
			'umur_pelapor' => $this->input->post('umur'),
			'nohp_pelapor' => $this->input->post('no_telp'),
			'alamat_pelapor' => $this->input->post('alamat'),
		);

		$korban = array(
			'nama_korban' => $this->input->post('nama_korban'),
			'jkel_korban' => $this->input->post('jenis_kelamin_korban'),
			'umur_korban' => $this->input->post('umur_korban'),
			'nohp_korban' => $this->input->post('no_telp_korban'),
			'alamat_korban' => $this->input->post('alamat_korban'),
			'jenis_korban' => $this->input->post('jenis_korban'),
			'id_pelapor' => '',
			'id_jenis_aduan' => $this->input->post('keterangan_pengaduan'),
			'aduan_lain' => $this->input->post('keterangan_lain'),
		);

		$this->db->insert('pelapor', $pelapor);
		$id_pelapor = $this->db->insert_id();

		if ($korban['id_jenis_aduan'] == 'etc') {
			$korban['id_jenis_aduan'] = null;
		}

		$korban['id_pelapor'] = $id_pelapor;
		$this->db->insert('korban', $korban);


		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}
}
