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

	function column_jenis_aduan($row)
	{
		$return = null;
		$db =	$this->db->where('id_korban', $row->id_korban)
			->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban_jenis_pengaduan_rel.id_jenis_aduan')
			->get('korban_jenis_pengaduan_rel');

		$html = '';
		foreach ($db->result() as $res) {

			$html .= "<span class='badge badge-dark'>" . $res->keterangan . "</span><br> ";
		}
		$return = $html;

		return $return;
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

			if ($korban->aduan_lain == NULL) {
				$row[] = $this->column_jenis_aduan($korban);
			} else {
				// $row[] = "<span class='badge badge-dark'>" . $korban->aduan_lain . "</span>";
				$row[] = '<span class="badge badge-dark">Lain-lain</span>';
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
		$data['list']  = $this->m_perempuan->get_list_id($id);
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

	function column_ket($row)
	{
		$return = null;
		$db =	$this->db->where('id_korban', $row->id_korban)
			->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban_jenis_pengaduan_rel.id_jenis_aduan')
			->get('korban_jenis_pengaduan_rel');

		$isi = '';
		foreach ($db->result() as $res) {

			$isi .= $res->keterangan . "\n";
		}
		$return = $isi;

		return $return;
	}

	public function excel()
	{
		$this->load->model('Perempuan_model');

		$data1 = $this->input->post('tgl1');
		$data2 = $this->input->post('tgl2');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$styleArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000'],
				],
			],
		];

		$tengah = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
		];

		$tengah2 = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
		];

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

		$spreadsheet->getActiveSheet()->getStyle('A4:O4')
			->getFont()
			->setBold(true);

		$sheet->setCellValue('A4', 'No');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($tengah2);
		$sheet->setCellValue('B4', 'Nama Korban');
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($tengah2);
		$sheet->setCellValue('C4', 'Umur Korban');
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($tengah2);
		$sheet->setCellValue('D4', 'No HP Korban');
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('D4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('D4')->applyFromArray($tengah2);
		$sheet->setCellValue('E4', 'Alamat Korban');
		// $sheet->getColumnDimension('F')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40, 'px');
		$spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($tengah2);
		$sheet->setCellValue('F4', 'Jenis Pengaduan');
		$spreadsheet->getActiveSheet()->getStyle('F4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(50, 'px');
		$spreadsheet->getActiveSheet()->getStyle('F4')->applyFromArray($tengah2);
		$sheet->setCellValue('G4', 'Nama Pelapor');
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('G4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('G4')->applyFromArray($tengah2);
		$sheet->setCellValue('H4', 'Umur Pelapor');
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('H4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('H4')->applyFromArray($tengah2);
		$sheet->setCellValue('I4', 'Jenis Kelamin Pelapor');
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('I4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('I4')->applyFromArray($tengah2);
		// $sheet->setCellValue('J4', 'NIK Pelapor');
		// $sheet->getColumnDimension('J')->setAutoSize(true);
		// $spreadsheet->getActiveSheet()->getStyle('J4')->applyFromArray($styleArray);
		// $spreadsheet->getActiveSheet()->getStyle('J4')->applyFromArray($tengah2);
		$sheet->setCellValue('J4', 'No HP Pelapor');
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('J4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('J4')->applyFromArray($tengah2);
		$sheet->setCellValue('K4', 'Alamat Pelapor');
		// $sheet->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(40, 'px');
		$spreadsheet->getActiveSheet()->getStyle('K4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('K4')->applyFromArray($tengah2);
		$sheet->setCellValue('L4', 'Status Pengaduan');
		$sheet->getColumnDimension('L')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('L4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('L4')->applyFromArray($tengah2);
		$sheet->setCellValue('M4', 'Tanggal Pengaduan');
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getStyle('M4')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('M4')->applyFromArray($tengah2);

		$p = $this->Perempuan_model->getEx($data1, $data2);
		$no = 1;
		$x = 5;
		if (!empty($p)) {

			foreach ($p as $row) {
				$sheet->setCellValue('A' . $x, $no++);
				$spreadsheet->getActiveSheet()->getStyle('A' . $x)->applyFromArray($tengah);
				$spreadsheet->getActiveSheet()->getStyle('A' . $x)->applyFromArray($styleArray);

				$sheet->setCellValue('B' . $x, $row->nama_korban);
				$spreadsheet->getActiveSheet()->getStyle('B' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('B' . $x)->applyFromArray($tengah);

				$sheet->setCellValue('C' . $x, $row->umur_korban . " Tahun");
				$spreadsheet->getActiveSheet()->getStyle('C' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('C' . $x)->applyFromArray($tengah);

				if ($row->nohp_korban == NULL || $row->nohp_korban == "") {
					$telp = "-";
					$sheet->setCellValue('D' . $x, $telp);
				} else {
					$sheet->setCellValue('D' . $x, $row->nohp_korban);
				}
				$spreadsheet->getActiveSheet()->getStyle('D' . $x)
					->getNumberFormat()
					->setFormatCode(
						'000000000000'
					);
				$spreadsheet->getActiveSheet()->getStyle('D' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('D' . $x)->applyFromArray($tengah);

				if ($row->alamat_korban == NULL || $row->alamat_korban == "") {
					$alm = "-";
					$sheet->setCellValue('E' . $x, $alm);
				} else {
					$sheet->setCellValue('E' . $x, $row->alamat_korban);
				}
				$spreadsheet->getActiveSheet()->getStyle('E' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('E' . $x)->applyFromArray($tengah);
				$spreadsheet->getActiveSheet()->getStyle('E' . $x)->getAlignment()->setWrapText(true);

				if ($row->aduan_lain != NULL) {
					$sheet->setCellValue('F' . $x, $row->aduan_lain . " (Lain-lain)");
				} else {
					$sheet->setCellValue('F' . $x, $this->column_ket($row));
				}
				$spreadsheet->getActiveSheet()->getStyle('F' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('F' . $x)->applyFromArray($tengah);
				$spreadsheet->getActiveSheet()->getStyle('F' . $x)->getAlignment()->setWrapText(true);

				$sheet->setCellValue('G' . $x, $row->nama_pelapor);
				$spreadsheet->getActiveSheet()->getStyle('G' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('G' . $x)->applyFromArray($tengah);

				$sheet->setCellValue('H' . $x, $row->umur_pelapor . " Tahun");
				$spreadsheet->getActiveSheet()->getStyle('H' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('H' . $x)->applyFromArray($tengah);

				if ($row->jkel_pelapor == "L") {
					$jkel2 = "Laki-laki";
					$sheet->setCellValue('I' . $x, $jkel2);
				} else {
					$jkel2 = "Perempuan";
					$sheet->setCellValue('I' . $x, $jkel2);
				}
				$spreadsheet->getActiveSheet()->getStyle('I' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('I' . $x)->applyFromArray($tengah);

				// if ($row->nik_pelapor == NULL || $row->nik_pelapor == "") {
				// 	$nik1 = "-";
				// 	$sheet->setCellValue('J' . $x, $nik1);
				// } else {
				// 	$sheet->setCellValue('J' . $x, "'" . $row->nik_pelapor);
				// }
				// $spreadsheet->getActiveSheet()->getStyle('J' . $x)->applyFromArray($styleArray);
				// $spreadsheet->getActiveSheet()->getStyle('J' . $x)->applyFromArray($tengah);

				if ($row->nohp_pelapor == NULL || $row->nohp_pelapor == "") {
					$telp1 = "-";
					$sheet->setCellValue('J' . $x, $telp1);
				} else {
					$sheet->setCellValue('J' . $x, $row->nohp_pelapor);
				}
				$spreadsheet->getActiveSheet()->getStyle('J' . $x)
					->getNumberFormat()
					->setFormatCode(
						'000000000000'
					);
				$spreadsheet->getActiveSheet()->getStyle('J' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('J' . $x)->applyFromArray($tengah);

				if ($row->alamat_pelapor == NULL || $row->alamat_pelapor == "") {
					$alm2 = "-";
					$sheet->setCellValue('K' . $x, $alm2);
				} else {
					$sheet->setCellValue('K' . $x, $row->alamat_pelapor);
				}
				$spreadsheet->getActiveSheet()->getStyle('K' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('K' . $x)->applyFromArray($tengah);
				$spreadsheet->getActiveSheet()->getStyle('K' . $x)->getAlignment()->setWrapText(true);

				if ($row->status_laporan == 1) {
					$status = "Selesai ditangani";
					$sheet->setCellValue('L' . $x, $status);
					$spreadsheet->getActiveSheet()->getStyle('L' . $x)
						->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('20a76f');
				} else if ($row->status_laporan == 2) {
					$status = "Belum ditangani";
					$sheet->setCellValue('L' . $x, $status);
					$spreadsheet->getActiveSheet()->getStyle('L' . $x)
						->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('dd0d0d');
				} else {
					$status = "Dalam proses";
					$sheet->setCellValue('L' . $x, $status);
					$spreadsheet->getActiveSheet()->getStyle('L' . $x)
						->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e46e38');
				}
				$spreadsheet->getActiveSheet()->getStyle('L' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('L' . $x)->applyFromArray($tengah);

				$sheet->setCellValue('M' . $x, $this->hari_ini(date('l', strtotime($row->created_at))) . ", " . $this->tgl_indo(date('Y-m-d', strtotime($row->created_at))));
				$spreadsheet->getActiveSheet()->getStyle('M' . $x)->applyFromArray($styleArray);
				$spreadsheet->getActiveSheet()->getStyle('M' . $x)->applyFromArray($tengah);
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
			$this->session->set_flashdata('success', 'Data pada tanggal tersebut tidak ditemukan');
			redirect(base_url() . 'superadmin/perempuan');
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
