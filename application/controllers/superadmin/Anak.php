<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anak extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Anak_model', 'm_anak');
		$this->load->library('Auth');

		$auth = new Auth();
		$auth->is_logged_in();
	}

	public function index()
	{
		$this->load->view('superadmin/List_laporana');
	}


	public function ajax_list()
	{
		$list = $this->m_anak->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $korban) {
			$no++;
			$row = array();
			$row[] = $no;

			if ($korban->keterangan == NULL) {
				$row[] = 'Lain-lain';
			} else {
				$row[] = $korban->keterangan;
			}

			$row[] = $korban->nama_korban;
			$row[] = $korban->nohp_korban;
			$row[] = $korban->nohp_pelapor;
			$row[] = $this->limit_words($korban->alamat_korban, 5) . ' ...';
			$row[] = date('d-m-Y', strtotime($korban->created_at));

			if ($korban->status_laporan == 1)
				$row[] = '<small class="label label-success"> Selesai ditangani</small>';
			else
				$row[] = '<small class="label label-danger"> Belum ditangani</small>';

			$row[] = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Lihat Data" onclick="lihat_laporan(' . "'" . $korban->id_korban . "'" . ')"><i class="fas fa-eye"></i></a>
				  <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Hapus Data" onclick="hapus_laporan(' . "'" . $korban->id_korban . "'" . ')"><i class="fas fa-trash"></i></a>
                  <a class="btn btn-warning btn-sm" href="javascript:void(0)" title="Update Status" onclick="update_laporan(' . "'" . $korban->id_korban . "'" . ')"><i class="fas fa-check"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_anak->count_all(),
			"recordsFiltered" => $this->m_anak->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public  function limit_words($string, $word_limit)
	{
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}

	public function lihat_detail($id)
	{
		$data['lihat']  = $this->m_anak->get_lihat_id($id);
		$this->load->view('superadmin/Lihat_laporana', $data);
	}

	public function ajax_delete($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$dihapus = date('Y-m-d H:i:s');
		$data = array(
			'deleted_at' => $dihapus
		);
		// $this->person->delete_by_id($id);
		$this->m_anak->update(array('id_korban' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->m_anak->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_upstatus()
	{
		$data = array(
			'status_laporan' => $this->input->post('status_laporan')
		);
		$this->m_anak->update(array('id_korban' => $this->input->post('id_korban')), $data);
		echo json_encode(array("status" => TRUE));
	}
}
