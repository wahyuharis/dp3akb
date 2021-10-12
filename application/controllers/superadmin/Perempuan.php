<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Perempuan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Perempuan_model', 'm_perempuan');
		$this->load->library('Auth');

		$auth = new Auth();
		$auth->is_logged_in();
	}

	public function index()
	{
		$this->load->view('superadmin/List_laporanp');
	}


	public function ajax_list()
	{
		$list = $this->m_perempuan->get_datatables();
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
			$row[] = $korban->umur_korban . " Tahun";
			$row[] = $korban->nohp_pelapor;
			// $row[] = date('d-m-Y', strtotime($korban->created_at));

			if ($korban->status_laporan == 1)
				$row[] = '<small class="label label-success"> Selesai ditangani</small>';
			elseif ($korban->status_laporan == 2)
				$row[] = '<small class="label label-danger"> Belum ditangani</small>';
			else
				$row[] = '<small class="label label-warning"> Dalam Proses</small>';

			$row[] = '<a class="btn btn-primary btn-sm" href="javascript:void(0)" title="Lihat Data" onclick="lihat_laporan(' . "'" . $korban->id_korban . "'" . ')"><i class="fas fa-eye"></i></a>
				  <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Hapus Data" onclick="hapus_laporan(' . "'" . $korban->id_korban . "'" . ')"><i class="fas fa-trash"></i></a>
                  <a class="btn btn-warning btn-sm" href="javascript:void(0)" title="Update Status" onclick="update_laporan(' . "'" . $korban->id_korban . "'" . ')"><i class="fas fa-check"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_perempuan->count_all(),
			"recordsFiltered" => $this->m_perempuan->count_filtered(),
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
		$data['lihat']  = $this->m_perempuan->get_lihat_id($id);
		$this->load->view('superadmin/Lihat_laporanp', $data);
	}

	public function ajax_delete($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$dihapus = date('Y-m-d H:i:s');
		$data = array(
			'deleted_at' => $dihapus
		);
		// $this->person->delete_by_id($id);
		$this->m_perempuan->update(array('id_korban' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit($id)
	{
		$data = $this->m_perempuan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_upstatus()
	{
		$data = array(
			'status_laporan' => $this->input->post('status_laporan')
		);
		$this->m_perempuan->update(array('id_korban' => $this->input->post('id_korban')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function excel()
	{
		$this->load->model('Perempuan_model');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->setCellValue('B1', 'Nama Korban');
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->setCellValue('C1', 'Umur Korban');
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->setCellValue('D1', 'Jenis Kelamin Korban');
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->setCellValue('E1', 'NIK Korban');
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->setCellValue('F1', 'No HP Korban');
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->setCellValue('G1', 'Alamat Korban');
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->setCellValue('H1', 'Jenis Pengaduan');
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->setCellValue('I1', 'Aduan Lain');
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->setCellValue('J1', 'Nama Pelapor');
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->setCellValue('K1', 'Umur Pelapor');
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->setCellValue('L1', 'Jenis Kelamin Pelapor');
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->setCellValue('M1', 'NIK Pelapor');
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->setCellValue('N1', 'No HP Pelapor');
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->setCellValue('O1', 'Alamat Pelapor');
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->setCellValue('P1', 'Status Pengaduan');
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->setCellValue('Q1', 'Tanggal Pengaduan');
		$sheet->getColumnDimension('Q')->setAutoSize(true);

		$data1 = $this->input->post('tgl1');
		$data2 = $this->input->post('tgl2');

		$p = $this->Perempuan_model->getEx($data1, $data2);
		$no = 1;
		$x = 2;
		foreach ($p as $row) {
			$sheet->setCellValue('A' . $x, $no++);
			$sheet->setCellValue('B' . $x, $row->nama_korban);
			$sheet->setCellValue('C' . $x, $row->umur_korban . " Tahun");
			if ($row->jkel_korban == "L") {
				$jkel = "Laki-laki";
				$sheet->setCellValue('D' . $x, $jkel);
			} else {
				$jkel = "Perempuan";
				$sheet->setCellValue('D' . $x, $jkel);
			}

			$sheet->setCellValue('E' . $x, "'" . $row->nik_korban);
			$sheet->setCellValue('F' . $x, "'" . $row->nohp_korban);
			$sheet->setCellValue('G' . $x, $row->alamat_korban);
			$sheet->setCellValue('H' . $x, $row->keterangan);
			$sheet->setCellValue('I' . $x, $row->aduan_lain);
			$sheet->setCellValue('J' . $x, $row->nama_pelapor);
			$sheet->setCellValue('K' . $x, $row->umur_pelapor . " Tahun");
			if ($row->jkel_pelapor == "L") {
				$jkel2 = "Laki-laki";
				$sheet->setCellValue('L' . $x, $jkel2);
			} else {
				$jkel2 = "Perempuan";
				$sheet->setCellValue('L' . $x, $jkel2);
			}
			$sheet->setCellValue('M' . $x, "'" . $row->nik_korban);
			$sheet->setCellValue('N' . $x, "'" . $row->nohp_korban);
			$sheet->setCellValue('O' . $x, $row->alamat_korban);
			if ($row->status_laporan == 1) {
				$status = "Selesai";
				$sheet->setCellValue('P' . $x, $status);
			} else if ($row->status_laporan == 2) {
				$status = "Belum";
				$sheet->setCellValue('P' . $x, $status);
			} else {
				$status = "Dalam proses";
				$sheet->setCellValue('P' . $x, $status);
			}
			$sheet->setCellValue('Q' . $x, "'" . $row->created_at);
			$x++;
		}
		$writer = new Xlsx($spreadsheet);
		$filename = 'laporan_korban_perempuan';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
