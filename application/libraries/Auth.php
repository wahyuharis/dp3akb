<?php

class Auth
{

    function __construct()
    {
        $ci = &get_instance();
    }

    function login($email, $password)
    {
        $ci = &get_instance();

        $error_message = array();

        //============VALIDASI EMAIL===========================
        $db = $ci->db->where('email', $email)->get('users');
        //  die(var_export($db));
        if ($db->num_rows() < 1) {
            $error_message['pesan'] = "email salah";
            $error_message['data'] = null;
        } else {
            //============VALIDASI PASSWORD===========================
            $db = $ci->db->where('email', $email)
                ->where('password', md5($password))
                ->get('users');

            if ($db->num_rows() < 1) {
                $error_message['pesan'] = "password salah";
                $error_message['data'] = null;
            } else {
                $sess = array();

                $db = $ci->db->select('users.*')
                    ->where('email', $email)
                    ->where('password', md5($password))
                    ->get('users');

                $sess = $db->row_array();


                $ci->session->set_userdata($sess);
                $error_message['data'] = $sess;
                $error_message['pesan'] = null;
            }
            //============VALIDASI PASSWORD===========================

        }
        //============VALIDASI EMAIL===========================
        return $error_message;
    }


    function is_logged_in()
    {
        $ci = &get_instance();

        $email = $ci->session->userdata('email');
        $password = $ci->session->userdata('password');

        $db = $ci->db->where('email', $email)
            ->where('password', $password)
            ->get('users');

        if ($db->num_rows() < 1) {
            $ci->session->set_flashdata('error_message', "Anda belum login");
            redirect('login');
        }

        return $this;
    }

    function is_administrator()
    {
        //Administrator //user_level

        $ci = &get_instance();
        $user_level = strtolower($ci->session->userdata('level'));

        if (strtolower($user_level) == strtolower('superadmin')) {
            // die(var_export($user_level));
            redirect('perempuan');
        } elseif ((strtolower($user_level) == strtolower('admin'))) {
            //pass
            redirect($user_level . '/perempuan');
        }
    }
}
