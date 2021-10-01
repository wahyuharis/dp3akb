<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Korban extends RestController {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('id_korban');
        if ($id == '') {
            $kontak = $this->db->get('korban')->result();
        } else {
            $this->db->where('id_korban', $id);
            $kontak = $this->db->get('korban')->result();
        }
        $this->response($kontak, 200);
    }

    //Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
                    'id_korban'         => $this->post('id_korban'),
                    'id_pelapor'        => $this->post('id_pelapor'),
                    'id_jenis_aduan'    => $this->post('id_jenis_aduan'),
                    'jenis_korban'      => $this->post('jenis_korban'),
                    'nama_korban'       => $this->post('nama_korban'),
                    'jkel_korban'       => $this->post('jkel_korban'),
                    'umur_korban'       => $this->post('umur_korban'),
                    'nik_korban'        => $this->post('nik_korban'),
                    'nohp_korban'       => $this->post('nohp_korban'),
                    'alamat_korban'     => $this->post('alamat_korban'),
                    'aduan_lain'        => $this->post('aduan_lain'),
                    'status_laporan'    => $this->post('status_laporan'),
                );
        $insert = $this->db->insert('korban', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbarui data kontak yang telah ada
    function index_put() {
        $id = $this->put('id_korban');
        $data = array(
                    'id_korban'       => $this->put('id_korban'),
                    'id_pelapor'        => $this->put('id_pelapor'),
                    'id_jenis_aduan'    => $this->put('id_jenis_aduan'),
                    'jenis_korban'      => $this->put('jenis_korban'),
                    'nama_korban'       => $this->put('nama_korban'),
                    'jkel_korban'       => $this->put('jkel_korban'),
                    'umur_korban'       => $this->put('umur_korban'),
                    'nik_korban'        => $this->put('nik_korban'),
                    'nohp_korban'       => $this->put('nohp_korban'),
                    'alamat_korban'     => $this->put('alamat_korban'),
                    'aduan_lain'        => $this->put('aduan_lain'),
                    'status_laporan'    => $this->put('status_laporan'),
                );
        $this->db->where('id_korban', $id);
        $update = $this->db->update('korban', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Menghapus salah satu data kontak
    function index_delete() {
        $id = $this->delete('id_korban');
        $this->db->where('id_korban', $id);
        $delete = $this->db->delete('korban');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }


    //Masukan function selanjutnya disini
}
?>