<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Pengguna_model', 'm_pengguna');
		$this->load->library('Auth');

		$auth = new Auth();
		$auth->is_logged_in();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->view('superadmin/List_pengguna');
	}

	public function ajax_list()
	{
		$list = $this->m_pengguna->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengguna) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pengguna->fullname;
			$row[] = $pengguna->email;
			$row[] = $pengguna->jabatan;
			$row[] = '<a class="btn btn-info btn-sm" href="javascript:void(0)" title="Edit Data" onclick="edit_user(' . "'" . $pengguna->id_user . "'" . ')"><i class="fas fa-edit"></i></a>
				  <a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Lihat Data" onclick="lihat_user(' . "'" . $pengguna->id_user . "'" . ')"><i class="fas fa-eye"></i></a>
				  <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Hapus Data" onclick="hapus_user(' . "'" . $pengguna->id_user . "'" . ')"><i class="fas fa-trash"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_pengguna->count_all(),
			"recordsFiltered" => $this->m_pengguna->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function edit($id = null)
	{
		if (!isset($id)) redirect('superadmin/pengguna');

		$data["pengguna"] = $this->m_pengguna->get_by_id($id);
		if (!$data["pengguna"]) show_404();
		$this->load->view('superadmin/Edit_pengguna', $data);
	}

	public function tambah()
	{
		$this->load->view('superadmin/Tambah_pengguna');
	}

	public function simpan()
	{

		$config = array(
			array(
				'field' => 'fullname',
				'label' => 'Nama',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s tidak boleh kosong',
				),
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s tidak boleh kosong',
				),
			),
			array(
				'field' => 'jabatan',
				'label' => 'Jabatan',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s tidak boleh kosong',
				),
			)
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() != false) {
			$fullname = $this->input->post('fullname');
			$email = $this->input->post('email');
			$password = $this->input->post('passwd');
			$jabatan = $this->input->post('jabatan');

			$data = array(
				'fullname' => $fullname,
				'level' => 'Superadmin',
				'email' => $email,
				'password' => md5($password),
				'jabatan' => $jabatan
			);

			$insert = $this->m_pengguna->save($data);
			$this->session->set_flashdata('success', 'Data berhasil disimpan');
			$this->load->view("superadmin/Tambah_pengguna");
		} else {
			$this->session->set_flashdata('failed', 'Data gagal disimpan');
			$this->load->view("superadmin/Tambah_pengguna");
		}
	}

	public function update()
	{
		$fullname = $this->input->post('fullname');
		$email = $this->input->post('email');
		$password = $this->input->post('passwd');
		$jabatan = $this->input->post('jabatan');

		if ($password == "") {
			$data = array(
				'fullname' => $fullname,
				'email' => $email,
				'jabatan' => $jabatan
			);
		} else {
			$data = array(
				'fullname' => $fullname,
				'email' => $email,
				'password' => md5($password),
				'jabatan' => $jabatan
			);
		}
		$this->m_pengguna->update(array('id_user' => $this->input->post('id_user')), $data);
		$this->session->set_flashdata('success', 'Berhasil disimpan');
		$this->session->set_userdata('fullname', $fullname);
		redirect('superadmin/pengguna/edit/' . $this->input->post('id_user') . '');
	}


	public function ajax_delete($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$dihapus = date('Y-m-d H:i:s');
		$data = array(
			'deleted_at' => $dihapus
		);
		// $this->person->delete_by_id($id);
		$this->m_pengguna->update(array('id_user' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}


	public function lihat($id)
	{
		$data['lihat']  = $this->m_pengguna->get_lihat_id($id);
		$this->load->view('superadmin/Lihat_pengguna', $data);
	}

	public  function limit_words($string, $word_limit)
	{
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}
}
