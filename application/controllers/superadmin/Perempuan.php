<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

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
		$data1 = $this->input->post('tgl1');
		$data2 = $this->input->post('tgl2');
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Laporan Data Pengaduan Korban Perempuan');
		$spreadsheet->getActiveSheet()->mergeCells('A1:E1');
		$spreadsheet->getActiveSheet()->getStyle('A1')
			->getFont()
			->setSize(16);

		$spreadsheet->getActiveSheet()->getStyle('A1')
			->getFont()
			->setBold(true);

		$sheet->setCellValue('A2', 'Periode ' . $this->tgl_indo(date('Y-m-d', strtotime($data1))) . ' sampai ' . $this->tgl_indo(date('Y-m-d', strtotime($data2))));
		$spreadsheet->getActiveSheet()->mergeCells('A2:E2');
		$spreadsheet->getActiveSheet()->getStyle('A2')
			->getFont()
			->setSize(14);

		$spreadsheet->getActiveSheet()->getStyle('A2')
			->getFont()
			->setBold(true);

		$sheet->setCellValue('A4', 'No');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->setCellValue('B4', 'Nama Korban');
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->setCellValue('C4', 'Umur Korban');
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->setCellValue('D4', 'NIK Korban');
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->setCellValue('E4', 'No HP Korban');
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->setCellValue('F4', 'Alamat Korban');
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->setCellValue('G4', 'Jenis Pengaduan');
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->setCellValue('H4', 'Aduan Lain');
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->setCellValue('I4', 'Nama Pelapor');
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->setCellValue('J4', 'Umur Pelapor');
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->setCellValue('K4', 'Jenis Kelamin Pelapor');
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->setCellValue('L4', 'NIK Pelapor');
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$sheet->setCellValue('M4', 'No HP Pelapor');
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->setCellValue('N4', 'Alamat Pelapor');
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->setCellValue('O4', 'Status Pengaduan');
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->setCellValue('P4', 'Tanggal Pengaduan');
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$styleArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => ['argb' => 'FFFF0000'],
				],
			],
		];

		$sheet->getStyle('A4:P10')->applyFromArray($styleArray);
		$p = $this->Perempuan_model->getEx($data1, $data2);
		$no = 1;
		$x = 5;
		if (!empty($p)) {

			foreach ($p as $row) {
				$sheet->setCellValue('A' . $x, $no++);
				$spreadsheet->getActiveSheet()->getStyle("A5:A200")
					->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

				$sheet->setCellValue('B' . $x, $row->nama_korban);
				$sheet->setCellValue('C' . $x, $row->umur_korban . " Tahun");

				if ($row->nik_korban == NULL) {
					$nik2 = "-";
					$sheet->setCellValue('D' . $x, $nik2);
				} else {
					$sheet->setCellValue('D' . $x,  "'" . $row->nik_korban);
				}

				$sheet->setCellValue('E' . $x, $row->nohp_korban);
				$spreadsheet->getActiveSheet()->getStyle('E5:E200')
					->getNumberFormat()
					->setFormatCode(
						'000000000000'
					);
				$sheet->setCellValue('F' . $x, $row->alamat_korban);

				if ($row->keterangan == NULL) {
					$aduan = "Lain-lain";
					$sheet->setCellValue('G' . $x, $aduan);
				} else {
					$sheet->setCellValue('G' . $x, $row->keterangan);
				}

				if ($row->aduan_lain == NULL) {
					$lain = "-";
					$sheet->setCellValue('H' . $x, $lain);
				} else {
					$sheet->setCellValue('H' . $x, $row->aduan_lain);
				}

				$sheet->setCellValue('I' . $x, $row->nama_pelapor);
				$sheet->setCellValue('J' . $x, $row->umur_pelapor . " Tahun");

				if ($row->jkel_pelapor == "L") {
					$jkel2 = "Laki-laki";
					$sheet->setCellValue('K' . $x, $jkel2);
				} else {
					$jkel2 = "Perempuan";
					$sheet->setCellValue('K' . $x, $jkel2);
				}

				if ($row->nik_pelapor == NULL) {
					$nik1 = "-";
					$sheet->setCellValue('L' . $x, $nik1);
				} else {
					$sheet->setCellValue('L' . $x, "'" . $row->nik_pelapor);
				}

				$sheet->setCellValue('M' . $x, $row->nohp_korban);
				$spreadsheet->getActiveSheet()->getStyle('M5:M200')
					->getNumberFormat()
					->setFormatCode(
						'000000000000'
					);
				$sheet->setCellValue('N' . $x, $row->alamat_korban);

				if ($row->status_laporan == 1) {
					$status = "Selesai";
					$sheet->setCellValue('O' . $x, $status);
				} else if ($row->status_laporan == 2) {
					$status = "Belum";
					$sheet->setCellValue('O' . $x, $status);
				} else {
					$status = "Dalam proses";
					$sheet->setCellValue('O' . $x, $status);
				}
				$sheet->setCellValue('P' . $x, $this->hari_ini(date('l', strtotime($row->created_at))) . ", " . $this->tgl_indo(date('Y-m-d', strtotime($row->created_at))));
				$x++;
			}
			$writer = new Xlsx($spreadsheet);
			$filename = 'Laporan Korban Perempuan (Periode ' . date('d-m-Y', strtotime($data1)) . ' sampai ' . date('d-m-Y', strtotime($data2)) . ')';

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
			exit;
		} else {
			echo "<script>" .
				"alert('Data pada tanggal tersebut tidak tersedia'); " .
				"window.location.href='" . base_url() . "superadmin/perempuan';" .
				"</script>";
		}
	}

	function hari_ini($ini)
	{
		$hari = $ini;

		switch ($hari) {
			case 'Sunday':
				$hari_ini = "Minggu";
				break;

			case 'Monday':
				$hari_ini = "Senin";
				break;

			case 'Tuesday':
				$hari_ini = "Selasa";
				break;

			case 'Wednesday':
				$hari_ini = "Rabu";
				break;

			case 'Thursday':
				$hari_ini = "Kamis";
				break;

			case 'Friday':
				$hari_ini = "Jumat";
				break;

			case 'Saturday':
				$hari_ini = "Sabtu";
				break;

			default:
				$hari_ini = "Tidak di ketahui";
				break;
		}

		return $hari_ini;
	}

	public function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}
}
