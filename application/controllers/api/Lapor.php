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
		// $data = array();
		$message = 'succes';
		$status = true;
		$response = array();

		//$post = $this->input->post();
		//$data = $post;

		$data = array(
			'id_korban'         => $this->post('id_korban'),
			'id_pelapor'        => $this->post('id_pelapor'),
			'id_jenis_aduan'    => $this->post('id_jenis_aduan'),
			'jenis_korban'      => $this->post('jenis_korban'),
			'nama_korban'       => $this->post('nama_korban'),
			'jkel_korban'       => $this->post('jkel_korban'),
			'umur_korban'       => $this->post('umur_korban'),
			'nik_korban'        => $this->post('nik_korban'),
			'nohp_korban'       => $this->post('nohp_korban'),
			'alamat_korban'     => $this->post('alamat_korban'),
			'aduan_lain'        => $this->post('aduan_lain'),
			'status_laporan'    => $this->post('status_laporan'),
		);
		$insert = $this->db->insert('korban', $data);
		$response = array(
			'data' => $insert,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}
}
