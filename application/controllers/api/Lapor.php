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

        $post=$this->input->post();

        $data=$post;


		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}
}
