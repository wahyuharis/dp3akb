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
        $sql = "";

        $db = $this->db->query($sql);


        $result = $db->result_array();
    }
}
