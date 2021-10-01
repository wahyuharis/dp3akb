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
				  <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Hapus Data" onclick="hapus_user(' . "'" . $pengguna->id_user . "'" . ')"><i class="fas fa-trash"></i></a>
                  <a class="btn btn-secondary btn-sm" href="javascript:void(0)" title="Lihat Data" onclick="lihat_user(' . "'" . $pengguna->id_user . "'" . ')"><i class="fas fa-eye"></i></a>';

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

	public function ajax_edit($id)
	{
		$data = $this->m_pengguna->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();

		$fullname = $this->input->post('fullname');
		$level = $this->input->post('level');
		$email = $this->input->post('email');
		$password = $this->input->post('passwd');
		$jabatan = $this->input->post('jabatan');

		$data = array(
			'fullname' => $fullname,
			'level' => $level,
			'email' => $email,
			'password' => md5($password),
			'jabatan' => $jabatan
		);

		$insert = $this->m_pengguna->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$fullname = $this->input->post('fullname');
		$level = $this->input->post('level');
        $email = $this->input->post('email');
		$password = $this->input->post('passwd');
		$jabatan = $this->input->post('jabatan');

        if($password == ""){
            $data = array(
				'fullname' => $fullname,
				'level' => $level,
                'email' => $email,
                'jabatan' => $jabatan
            );
           
        }else{
            $data = array(
				'fullname' => $fullname,
				'level' => $level,
                'email' => $email,
                'password' => md5($password),
                'jabatan' => $jabatan
            );
        }

	
		$this->m_pengguna->update(array('id_user' => $this->input->post('id_user')), $data);
		echo json_encode(array("status" => TRUE));
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

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('fullname') == '') {
			$data['inputerror'][] = 'fullname';
			$data['error_string'][] = 'Fullname tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if ($this->input->post('level') == '') {
			$data['inputerror'][] = 'level';
			$data['error_string'][] = 'Level tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if ($this->input->post('email') == '') {
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email tidak boleh kosong';
			$data['status'] = FALSE;
		}		

		if ($this->input->post('jabatan') == '') {
			$data['inputerror'][] = 'jabatan';
			$data['error_string'][] = 'Jabatan tidak boleh kosong';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}


	public  function limit_words($string, $word_limit)
	{
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}

}
