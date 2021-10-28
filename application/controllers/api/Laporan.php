<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Laporan extends RestController
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

		$device_id = $this->input->get('device_id');

		$page = $this->input->get('page');

		$this->load->model('Laporan_model');

		$laporan_model = new Laporan_model();

		if (!empty(trim($device_id))) {
			$res = $laporan_model->laporan_list($device_id, $page);
			if ($res) {
				$data = $res;
			} else {
				$status = false;
			}
		} else {
			$status = false;
		}

		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}

	function detail_get()
	{
		$data = array();
		$message = 'succes';
		$status = true;
		$response = array();

		$device_id = $this->input->get('device_id');
		$id_korban = $this->input->get('id_korban');

		$this->load->model('Laporan_model');

		$laporan_model = new Laporan_model();

		if (!empty(trim($device_id)) && !empty(trim($id_korban))) {
			$res = $laporan_model->laporan_detail($device_id, $id_korban);
			if ($res) {
				$data = $res;
			} else {
				$status = false;
			}
		} else {
			$status = false;
		}

		$response = array(
			'data' => $data,
			'message' => $message,
			'status' => $status
		);

		$this->response($response, 200);
	}
}
