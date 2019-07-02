<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index(){
	    if (!$this->session->userdata('queue')){
	        redirect(base_url('account/login'));
        }
		$this->load->view('welcome_message');
	}
	function logout(){
	    $this->session->sess_destroy();
	    redirect(base_url(''));
    }
	function login(){
	    if ($this->session->userdata('queue')){
	        redirect(base_url());
        }
        $this->load->view('account/login');
    }
    function login_submit(){
	    $json['t'] = 0;
	    $user_name  = $this->input->post('user_name');
	    $data_user  = $this->dbase->dataRow('user',array('user_name'=>$user_name,'user_status'=>1));
	    $user_pass  = $this->input->post('user_password');
	    if ($this->session->userdata('queue')){
	        $json['t'] = 1;
        } else {
	        if (strlen(trim($user_name)) == 0){
                $json['msg'] = 'Mohon isi kolom <strong>Username</strong>';
                $json['class'] = 'user_name';
            } elseif (!$data_user){
	            $json['msg'] = '<strong>Username</strong> tidak ditemukan';
	            $json['class'] = 'user_name';
            } elseif (strlen(trim($user_pass)) == 0){
	            $json['msg'] = 'Mohon isi kolom <strong>Password</strong>';
	            $json['class'] = 'user_password';
            } elseif (!password_verify($user_pass,$data_user->user_password)){
	            $json['msg'] = 'Kombinasi <strong>Username</strong> dan <strong>Password</strong> tidak valid ';//.password_hash($user_pass,PASSWORD_DEFAULT);
	            $json['class'] = 'user_password';
            } else {
                $dt_rs  = $this->dbase->dataRow('rumkit',array('rs_id'=>1));
                $arr = array(
                    'queue' => true,
                    'user_id'   => $data_user->user_id,
                    'user_fullname' => $data_user->user_fullname,
                    'user_level' => $data_user->user_level,
                    'rs_name' => $dt_rs->rs_name
                );

                $this->session->set_userdata($arr);
                $this->dbase->dataUpdate('user',array('user_id'=>$data_user->user_id),array('user_last_login'=>date('Y-m-d H:i:s')));
                $json['t']  = 1;
            }
        }
	    die(json_encode($json));
    }
}
