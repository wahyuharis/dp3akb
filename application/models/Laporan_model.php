<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function laporan_list($device_id)
    {
        $sql = "SELECT * FROM korban
        JOIN pelapor
        ON pelapor.id_pelapor=korban.id_pelapor
        
        WHERE pelapor.device_id=" . $this->db->escape($device_id) . " 
        
        ORDER BY id_korban DESC
        LIMIT 100
        ";

        $db = $this->db->query($sql);


        $result = $db->result_array();

        if ($db->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    function laporan_detail($device_id, $id_korban)
    {
        $sql = "SELECT * FROM korban
        JOIN pelapor
        ON pelapor.id_pelapor=korban.id_pelapor
        
        WHERE 
        pelapor.device_id=" . $this->db->escape($device_id) . "
        AND
        korban.id_korban=" . $this->db->escape($id_korban) . "";

        $db = $this->db->query($sql);

        $sql2 = "SELECT * FROM korban_jenis_pengaduan_rel
        LEFT JOIN jenis_pengaduan
        ON jenis_pengaduan.id_jenis_aduan=korban_jenis_pengaduan_rel.id_jenis_aduan
        WHERE korban_jenis_pengaduan_rel.id_korban=" . $this->db->escape($id_korban) . " ";
        $db2 = $this->db->query($sql2);


        $result = $db->row_array();
        $result['jenis_aduan'] = $db2->result_array();

        if ($db->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
}
