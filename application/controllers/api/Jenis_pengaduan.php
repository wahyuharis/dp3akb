<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Jenis_pengaduan extends RestController
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


		$kontak = $this->db->get('jenis_pengaduan')->result();
		$data = $kontak;


		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}
}
