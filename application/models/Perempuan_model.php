<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perempuan_model extends CI_Model
{

	var $table = 'korban';
	var $column_order = array('keterangan', 'nama_korban', 'nohp_korban', 'nohp_pelapor', 'alamat_korban', 'created_at', 'status_laporan', null); //set column field database for datatable orderable
	var $column_search = array('keterangan', 'nama_korban', 'nohp_korban', 'nohp_pelapor', 'alamat_korban'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id_korban' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{

		$this->db->select('korban.*, pelapor.nohp_pelapor, jenis_pengaduan.keterangan');
		$this->db->from($this->table);
		$this->db->join('pelapor', 'pelapor.id_pelapor = korban.id_pelapor', 'left');
		$this->db->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban.id_jenis_aduan', 'left');
		$this->db->where('korban.deleted_at', null);
		$this->db->where('korban.jenis_korban', 'Perempuan');

		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_lihat_id($id)
	{
		$this->db->select('korban.*, pelapor.*, jenis_pengaduan.*');
		$this->db->from($this->table);
		$this->db->join('pelapor', 'pelapor.id_pelapor = korban.id_pelapor', 'left');
		$this->db->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban.id_jenis_aduan', 'left');
		$this->db->where('korban.id_korban', $id);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_list_id($id)
	{
		$this->db->select('korban_jenis_pengaduan_rel.*,korban.id_korban,jenis_pengaduan.id_jenis_aduan');
		$this->db->from('korban_jenis_pengaduan_rel');
		$this->db->join('korban', 'korban.id_korban= korban_jenis_pengaduan_rel.id_korban', 'left');
		$this->db->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban.id_jenis_aduan', 'left');
		$this->db->where('korban.id_korban', $id);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_by_id($id)
	{
		$this->db->select('korban.*, pelapor.*, jenis_pengaduan.keterangan');
		$this->db->from($this->table);
		$this->db->join('pelapor', 'pelapor.id_pelapor = korban.id_pelapor', 'left');
		$this->db->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban.id_jenis_aduan', 'left');
		$this->db->where('korban.id_korban', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function getEx($data1, $data2)
	{
		$this->db->select('korban.*, pelapor.nama_pelapor, pelapor.umur_pelapor, pelapor.jkel_pelapor, pelapor.nik_pelapor, pelapor.nohp_pelapor, pelapor.alamat_pelapor, pelapor.created_at AS tgl2, jenis_pengaduan.keterangan');
		$this->db->from('korban');
		$this->db->join('pelapor', 'pelapor.id_pelapor = korban.id_pelapor', 'left');
		$this->db->join('jenis_pengaduan', 'jenis_pengaduan.id_jenis_aduan=korban.id_jenis_aduan', 'left');
		$this->db->where('korban.jenis_korban =', 'Perempuan');
		$this->db->where('korban.created_at >=', $data1 . " 00.00");
		$this->db->where('korban.created_at <=', $data2 . " 23.59");
		$query = $this->db->get();
		return $query->result();
	}

	public function getCount($data1, $data2)
	{
		return $this->db->query("SELECT COUNT(*) AS jml FROM korban WHERE jenis_korban='Perempuan' AND (created_at BETWEEN '" . $data1 . ' 00:00' . "' AND '" . $data2 . ' 23:59' . "')")->row();
	}
}
