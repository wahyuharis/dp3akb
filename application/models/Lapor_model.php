<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lapor_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function pelapor_last_data($device_id)
    {
        $sql = "SELECT * FROM pelapor
        WHERE pelapor.device_id=" . $this->db->escape($device_id) . "
        ORDER BY pelapor.id_pelapor DESC
        LIMIT 1";

        $db = $this->db->query($sql);
        $result = $db->row_array();

        if ($db->num_rows() > 0) {
            return $result;

        }else{
            return false;

        }
    }
}
