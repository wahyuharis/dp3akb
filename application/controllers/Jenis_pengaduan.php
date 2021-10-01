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
		$id = $this->get('id_jenis_aduan');
		if ($id == '') {
			$kontak = $this->db->get('jenis_pengaduan')->result();
		} else {
			$this->db->where('id_jenis_aduan', $id);
			$kontak = $this->db->get('jenis_pengaduan')->result();
		}
		$this->response($kontak, 200);
	}

	//Mengirim atau menambah data kontak baru
	function index_post()
	{
		$data = array(
			'id_jenis_aduan'    => $this->post('id_jenis_aduan'),
			'keterangan'        	=> $this->post('keterangan')
		);
		$insert = $this->db->insert('jenis_pengaduan', $data);
		if ($insert) {
			$this->response($data, 200);
		} else {
			$this->response(array('status' => 'fail', 502));
		}
	}

	//Memperbarui data kontak yang telah ada
	function index_put()
	{
		$id = $this->put('id_jenis_aduan');
		$data = array(
			'id_jenis_aduan'       => $this->put('id_jenis_aduan'),
			'keterangan'        	=> $this->put('keterangan')
		);
		$this->db->where('id_jenis_aduan', $id);
		$update = $this->db->update('jenis_pengaduan', $data);
		if ($update) {
			$this->response($data, 200);
		} else {
			$this->response(array('status' => 'fail', 502));
		}
	}

	//Menghapus salah satu data kontak
	function index_delete()
	{
		$id = $this->delete('id_jenis_aduan');
		$this->db->where('id_jenis_aduan', $id);
		$delete = $this->db->delete('jenis_pengaduan');
		if ($delete) {
			$this->response(array('status' => 'success'), 201);
		} else {
			$this->response(array('status' => 'fail', 502));
		}
	}


	//Masukan function selanjutnya disini
}
