<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index(){
	    if (!$this->session->userdata('queue')){
	        redirect(site_url('account/login'));
        }
        $data['data']   = $this->dbase->dataResult('queue',array('DATE(que_date)'=>date('Y-m-d'),'que_status'=>0));
        $data['loket']  = $this->dbase->dataResult('loket',array('loket_status'=>1));
        $data['body'] = 'home';
        if ($this->input->is_ajax_request()){
	        $this->load->view('home',$data);
        } else {
            $this->load->view('dashboard',$data);
        }
	}
	function admin_loket(){
	    $this->load->view('admin/admin_loket');
    }
    function admin_loket_data(){
	    $json['t'] = 0;
	    $keyword     = $this->input->post('keyword');
	    $sql    = "SELECT  * FROM tb_loket
                   WHERE   (loket_name LIKE '%".$keyword."%' OR loket_kode LIKE '%".$keyword."%')
                           AND loket_status = 1
                   ORDER BY loket_name ASC ";
	    $data_loket = $this->dbase->sqlResult($sql);
	    if (!$data_loket){
	        $json['msg'] = 'Tidak ada data loket pendaftaran';
        } else {
	        $i = 0;
	        foreach ($data_loket as $value){
	            $data_loket[$i] = $value;
	            $data_loket[$i]->poli = $this->dbase->dataResult('poli',array('loket_id'=>$value->loket_id,'poli_status'=>1));
	            $i++;
            }
	        $json['t'] = 1;
            $data['data'] = $data_loket;
            $json['html'] = $this->load->view('admin/admin_loket_data',$data,TRUE);
        }
	    die(json_encode($json));
    }
    function edit_loket(){
	    if (!$this->input->is_ajax_request()){
	        redirect(base_url());
        }
	    $loket_id   = $this->uri->segment(3);
	    $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$loket_id));
	    if (!$data_loket){
	        die('Invalid data');
        } else {
	        $data_poli      = $this->dbase->dataResult('poli',array('poli_status'=>1));
	        if ($data_poli){
	            $i = 0;
	            foreach ($data_poli as $value){
	                $data_poli[$i]  = $value;
	                $data_poli[$i]->check = 0;
	                if ($value->loket_id == $loket_id){
	                    $data_poli[$i]->check = 1;
                    }
	                $i++;
                }
            }
            $data['poli']   = $data_poli;
	        $data['data']   = $data_loket;
	        $this->load->view('admin/form/edit_loket',$data);
        }
    }
    function edit_loket_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'loket_name';
        $loket_id   = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$loket_id));
        $loket_name = $this->input->post('loket_name');
        $loket_kode = $this->input->post('loket_kode');
        $poli_id    = $this->input->post('poli_id');
        $chk_kode   = $this->dbase->dataRow('loket',array('loket_id !='=>$loket_id,'loket_kode'=>$loket_kode,'loket_status'=>1));
        if (!$loket_id || !$data_loket){
            $json['msg'] = 'Invalid data';
            $json['class'] = 'loket_name';
        } elseif (strlen(trim($loket_name)) == 0){
            $json['msg'] = 'Masukkan <strong>Nama Loket</strong>';
            $json['class'] = 'loket_name';
        } elseif (strlen(trim($loket_kode)) == 0){
            $json['msg'] = 'Masukkan <strong>Kode Loket</strong>';
            $json['class'] = 'loket_kode';
        } elseif (strlen(trim($loket_kode)) > 1) {
            $json['msg'] = '<strong>Kode Loket</strong> terlalu panjang (maksimal 1 karakter)';
            $json['class'] = 'loket_kode';
        } elseif ($chk_kode){
            $json['msg'] = '<strong>Kode Loket</strong> sudah terpakai di <strong>'.$chk_kode->loket_name.'</strong>';
            $json['class'] = 'loket_kode';
        //} elseif (!isset($poli_id)){
        //    $json['msg'] = 'Pilih <strong>Poli</strong> lebih dulu';
        //} elseif (count($poli_id) == 0) {
        //    $json['msg'] = 'Pilih <strong>Poli</strong> lebih dulu';
        } else {
            $arr = array('loket_name'=>$loket_name, 'loket_kode'=>$loket_kode);
            $this->dbase->dataUpdate('loket',array('loket_id'=>$loket_id),$arr);
            //update poli
            $data_poli = $this->dbase->dataResult('poli',array('loket_id'=>$loket_id,'poli_status'=>1));
            if ($data_poli){
                foreach ($data_poli as $value){
                    $this->dbase->dataUpdate('poli',array('poli_id'=>$value->poli_id),array('loket_id'=>NULL));
                }
            }
            if (isset($poli_id) && count($poli_id) > 0){
                foreach ($poli_id as $value){
                    $this->dbase->dataUpdate('poli',array('poli_id'=>$value),array('loket_id'=>$loket_id));
                }
            }
            $json['t'] = 1;
            $json['msg'] = 'Data <strong>Loket</strong> berhasil dirubah';
        }
        die(json_encode($json));
    }
    function add_loket(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $data_poli      = $this->dbase->dataResult('poli',array('poli_status'=>1));
        $data['data']   = $data_poli;
        $this->load->view('admin/form/add_loket',$data);
    }
    function add_loket_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t'] = 0;
        $json['class'] = 'loket_name';
        $loket_name = $this->input->post('loket_name');
        $loket_kode = $this->input->post('loket_kode');
        $poli_id    = $this->input->post('poli_id');
        $chk_kode   = $this->dbase->dataRow('loket',array('loket_kode'=>$loket_kode,'loket_status'=>1));
        if (strlen(trim($loket_name)) == 0){
            $json['msg'] = 'Masukkan <strong>Nama Loket</strong>';
            $json['class'] = 'loket_name';
        } elseif (strlen(trim($loket_kode)) == 0){
            $json['msg'] = 'Masukkan <strong>Kode Loket</strong>';
            $json['class'] = 'loket_kode';
        } elseif (strlen(trim($loket_kode)) > 1) {
            $json['msg'] = '<strong>Kode Loket</strong> terlalu panjang (max 1 karakter)';
            $json['class'] = 'loket_kode';
        } elseif ($chk_kode){
            $json['msg'] = '<strong>Kode Loket</strong> sudah terpakai di <strong>'.$chk_kode->loket_name.'</strong>';
            $json['class'] = 'loket_kode';
        } else {
            $loket_id = $this->dbase->dataInsert('loket',array('loket_kode'=>$loket_kode,'loket_name'=>$loket_name));
            if (!$loket_id){
                $json['msg'] = 'Database Error';
            } else {
                if (isset($poli_id) && count($poli_id) > 0){
                    foreach ($poli_id as $value){
                        $this->dbase->dataUpdate('poli',array('poli_id'=>$value),array('loket_id'=>$loket_id));
                    }
                }
                $json['t'] = 1;
                $json['msg'] = '<strong>Loket baru</strong> berhasil ditambahkan';
            }
        }
        die(json_encode($json));
    }
    function delete_loket(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $loket_id   = $this->uri->segment(3);
        $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$loket_id));
        if (!$loket_id || !$data_loket){
            die('Invalid data');
        } else {
            $data['data']   = $data_loket;
            $this->load->view('admin/form/delete_loket',$data);
        }
    }
    function delete_loket_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t'] = 0;
        $loket_id   = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$loket_id));
        if (!$loket_id || !$data_loket){
            $json['msg'] = 'Invalid data';
        } else {
            $this->dbase->dataUpdate('loket',array('loket_id'=>$loket_id),array('loket_status'=>0));
            $this->dbase->dataUpdate('poli',array('loket_id'=>$loket_id,'poli_status'=>1),array('loket_id'=>NULL));
            $json['t'] = 1;
            $json['msg'] = '<strong>Data Loket</strong> berhasil dihapus';
        }
        die(json_encode($json));
    }
    function admin_poli(){
        $this->load->view('admin/admin_poli');
    }
    function admin_poli_data(){
        $json['t'] = 0;
        $keyword     = $this->input->post('keyword');
        $sql    = " SELECT  pl.*,lk.loket_name
                    FROM    tb_poli AS pl
                    LEFT JOIN tb_loket AS lk ON pl.loket_id = lk.loket_id
                    WHERE   (
                            pl.poli_kode LIKE '%".$keyword."%' OR
                            pl.poli_name LIKE '%".$keyword."%' OR
                            lk.loket_name LIKE '%".$keyword."%'
                            ) AND pl.poli_status = 1
                    ORDER BY pl.poli_kode ASC ";
        $data_poli = $this->dbase->sqlResult($sql);
        if (!$data_poli){
            $json['msg'] = 'Tidak ada data Poli';
        } else {
             $json['t'] = 1;
            $data['data'] = $data_poli;
            $json['html'] = $this->load->view('admin/admin_poli_data',$data,TRUE);
        }
        die(json_encode($json));
    }
    function edit_poli(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $poli_id    = $this->uri->segment(3);
        $data_poli  = $this->dbase->dataRow('poli',array('poli_id'=>$poli_id));
        if (!$data_poli || !$poli_id){
            die('Invalid data');
        } else {
            $data_poli->loket_name = "";
            if (strlen(trim($data_poli->loket_id)) > 0){
                $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$data_poli->loket_id),'loket_name');
                if ($data_loket){
                    $data_poli->loket_name = $data_loket->loket_name;
                }
            }
            $data['loket'] = $this->dbase->dataResult('loket',array('loket_status'=>1),'loket_id,loket_name');
            $data['data'] = $data_poli;
            $this->load->view('admin/form/edit_poli',$data);
        }
    }
    function edit_poli_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'poli_name';
        $files      = $_FILES['poli_pic'];
        $file_name  = $_FILES['poli_pic']['name'];
        $file_tmp   = $_FILES['poli_pic']['tmp_name'];
        $poli_id    = $this->input->post('poli_id');
        $data_poli  = $this->dbase->dataRow('poli',array('poli_id'=>$poli_id));
        $poli_name  = $this->input->post('poli_name');
        $poli_kode  = $this->input->post('poli_kode');
        $loket_id   = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$loket_id));
        $chk_kode   = $this->dbase->dataRow('poli',array('poli_id !='=>$poli_id,'poli_kode'=>$poli_kode,'poli_status'=>1));
        //file upload check
        if (strlen(trim($file_name)) > 0){
            $target_dir = FCPATH . "assets/img/poli/";
            $file_ext   = explode(".",$file_name);
            $file_ext   = end($file_ext);
            $new_filename = md5(date('YmdHis')).'.'.$file_ext;
            $target_file = $target_dir . $new_filename;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = getimagesize($file_tmp);
            if($check === false) {
                $json['msg'] = 'Mohon pilih <strong>file gambar</strong>';
                die(json_encode($json));
            } else {
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    $json['msg'] = 'Hanya file jpg, gif, dan png saja yang boleh diupload';
                    die(json_encode($json));
                }
            }
        }
        //file upload check
        if (!$poli_id || !$data_poli){
            $json['msg'] = 'Invalid data';
            $json['class'] = 'poli_name';
        } elseif (strlen(trim($poli_name)) == 0){
            $json['msg'] = 'Masukkan <strong>Nama Poli</strong>';
            $json['class'] = 'poli_name';
        } elseif (strlen(trim($poli_kode)) == 0){
            $json['msg'] = 'Masukkan <strong>Kode Poli</strong>';
            $json['class'] = 'poli_kode';
        } elseif (strlen(trim($poli_kode)) > 1) {
            $json['msg'] = '<strong>Kode Poli</strong> terlalu panjang (maksimal 1 karakter)';
            $json['class'] = 'poli_kode';
        } elseif ($chk_kode) {
            $json['msg'] = '<strong>Kode Poli</strong> sudah terpakai di <strong>' . $chk_kode->poli_name . '</strong>';
            $json['class'] = 'poli_kode';
            //} elseif (!isset($poli_id)){
            //    $json['msg'] = 'Pilih <strong>Poli</strong> lebih dulu';
            //} elseif (count($poli_id) == 0) {
            //    $json['msg'] = 'Pilih <strong>Poli</strong> lebih dulu';
        } elseif (strlen(trim($loket_id)) > 0 && !$data_loket){
            $json['msg'] = 'Invalid data <strong>Loket</strong>';
            $json['class'] = 'loket_id';
        } else {
            //file upload start
            if (strlen(trim($file_name)) > 0){
                @move_uploaded_file($file_tmp, $target_file);
                $arr = array('poli_name'=>$poli_name, 'poli_kode'=>$poli_kode,'poli_logo'=>$new_filename);
                if (strlen(trim($loket_id)) > 0 && $data_loket){
                    $arr = array('poli_name'=>$poli_name, 'poli_kode'=>$poli_kode, 'loket_id'=>$loket_id,'poli_logo'=>$new_filename);
                }
            } else {
                $arr = array('poli_name'=>$poli_name, 'poli_kode'=>$poli_kode);
                if (strlen(trim($loket_id)) > 0 && $data_loket){
                    $arr = array('poli_name'=>$poli_name, 'poli_kode'=>$poli_kode, 'loket_id'=>$loket_id);
                }
            }
            //file upload start

            $this->dbase->dataUpdate('poli',array('poli_id'=>$poli_id),$arr);
            $json['t'] = 1;
            $json['msg'] = 'Data <strong>Poli</strong> berhasil dirubah';
        }
        die(json_encode($json));
    }
    function delete_poli(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $poli_id    = $this->uri->segment(3);
        $data_poli  = $this->dbase->dataRow('poli',array('poli_id'=>$poli_id));
        if (!$poli_id || !$data_poli){
            die('Invalid data');
        } else {
            $data['data']   = $data_poli;
            $this->load->view('admin/form/delete_poli',$data);
        }
    }
    function delete_poli_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t'] = 0;
        $poli_id   = $this->input->post('poli_id');
        $data_poli = $this->dbase->dataRow('poli',array('poli_id'=>$poli_id));
        if (!$poli_id || !$data_poli){
            $json['msg'] = 'Invalid data';
        } else {
            $this->dbase->dataUpdate('poli',array('poli_id'=>$poli_id),array('poli_status'=>0));
            $json['t'] = 1;
            $json['msg'] = '<strong>Data Poli</strong> berhasil dihapus';
        }
        die(json_encode($json));
    }
    function add_poli(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $data_loket     = $this->dbase->dataResult('loket',array('loket_status'=>1));
        $data['data']   = $data_loket;
        $this->load->view('admin/form/add_poli',$data);
    }
    function add_poli_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'poli_name';
        //die(var_dump($_FILES['poli_pic']));
        $files      = $_FILES['poli_pic'];
        $file_name  = $_FILES['poli_pic']['name'];
        $file_tmp   = $_FILES['poli_pic']['tmp_name'];
        $poli_name  = $this->input->post('poli_name');
        $poli_kode  = $this->input->post('poli_kode');
        $loket_id   = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$loket_id));
        $chk_kode   = $this->dbase->dataRow('poli',array('poli_kode'=>$poli_kode,'poli_status'=>1));

        //file upload check
        if (strlen(trim($file_name)) > 0){
            $target_dir = FCPATH . "assets/img/poli/";
            $file_ext   = explode(".",$file_name);
            $file_ext   = end($file_ext);
            $new_filename = md5(date('YmdHis')).'.'.$file_ext;
            $target_file = $target_dir . $new_filename;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $check = getimagesize($file_tmp);
            if($check === false) {
                $json['msg'] = 'Mohon pilih <strong>file gambar</strong>';
                die(json_encode($json));
            } else {
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    $json['msg'] = 'Hanya file jpg, gif, dan png saja yang boleh diupload';
                    die(json_encode($json));
                }
            }
        }
        //file upload check

        if (strlen(trim($poli_name)) == 0){
            $json['msg'] = 'Masukkan <strong>Nama Poli</strong>';
            $json['class'] = 'poli_name';
        } elseif (strlen(trim($poli_kode)) == 0){
            $json['msg'] = 'Masukkan <strong>Kode Poli</strong>';
            $json['class'] = 'poli_kode';
        } elseif (strlen(trim($poli_kode)) > 1) {
            $json['msg'] = '<strong>Kode Poli</strong> terlalu panjang (maksimal 1 karakter)';
            $json['class'] = 'poli_kode';
        } elseif ($chk_kode) {
            $json['msg'] = '<strong>Kode Poli</strong> sudah terpakai di <strong>' . $chk_kode->poli_name . '</strong>';
            $json['class'] = 'poli_kode';
            //} elseif (!isset($poli_id)){
            //    $json['msg'] = 'Pilih <strong>Poli</strong> lebih dulu';
            //} elseif (count($poli_id) == 0) {
            //    $json['msg'] = 'Pilih <strong>Poli</strong> lebih dulu';
        } elseif (strlen(trim($loket_id)) > 0 && !$data_loket){
            $json['msg'] = 'Invalid data <strong>Loket</strong>';
            $json['class'] = 'loket_id';
        } else {

            //file upload start
            if (strlen(trim($file_name)) > 0){
                @move_uploaded_file($file_tmp, $target_file);
            } else {
                $new_filename = NULL;
            }
            //file upload start

            $arr = array('poli_name'=>$poli_name,'poli_kode'=>$poli_kode,'poli_logo'=>$new_filename);
            if (strlen(trim($loket_id)) > 0 && $data_loket){
                $arr = array('poli_name'=>$poli_name,'poli_kode'=>$poli_kode,'loket_id'=>$loket_id,'poli_logo'=>$new_filename);
            }
            $poli_id = $this->dbase->dataInsert('poli',$arr);
            if (!$poli_id){
                $json['msg'] = 'Database error';
            } else {
                $json['t'] = 1;
                $json['msg'] = 'Data <strong>Poli</strong> berhasil ditambahkan';
            }
        }
        die(json_encode($json));
    }
    function admin_user(){
        $this->load->view('admin/admin_user');
    }
    function admin_user_data(){
        $json['t'] = 0;
        $keyword     = $this->input->post('keyword');
        $sql    = " SELECT  *
                    FROM    tb_user
                    WHERE   (
                            user_name LIKE '%".$keyword."%' OR
                            user_fullname LIKE '%".$keyword."%'
                            ) AND user_status = 1
                    ORDER BY user_name ASC ";
        $data_user = $this->dbase->sqlResult($sql);
        if (!$data_user){
            $json['msg'] = 'Tidak ada data Poli';
        } else {
            $json['t'] = 1;
            $data['data'] = $data_user;
            $json['html'] = $this->load->view('admin/admin_user_data',$data,TRUE);
        }
        die(json_encode($json));
    }
    function add_user(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $this->load->view('admin/form/add_user');
    }
    function add_user_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'user_name';

        $user_fullname  = $this->input->post('user_fullname');
        $user_name      = $this->input->post('user_name');
        $user_password  = $this->input->post('user_password');
        $user_level     = $this->input->post('user_level');
        $chk_username   = $this->dbase->dataRow('user',array('user_name'=>$user_name));
        if (strlen(trim($user_fullname)) == 0){
            $json['msg'] = 'Mohon isi <strong>Nama Lengkap Pengguna</strong>';
            $json['class'] = 'user_fullname';
        } elseif (strlen(trim($user_name)) == 0){
            $json['msg'] = 'Mohon isi <strong>Username</strong>';
        } elseif (strlen(trim($user_name)) > 20){
            $json['msg'] = '<strong>Username</strong> tidak boleh terlalu panjang (Max 20 karakter)';
        } elseif ($chk_username){
            $json['msg'] = '<strong>Username</strong> sudah terpakai oleh pengguna dengan nama <strong>'.$chk_username->user_fullname.'</strong>';
        } elseif (strlen(trim($user_password)) == 0){
            $json['msg'] = 'Mohon isi <strong>Password pengguna</strong>';
        } elseif (strlen(trim($user_password)) < 5){
            $json['msg'] = '<strong>Password Pengguna</strong> terlalu sedikit (Min 5 karakter)';
        } else {
            $arr = array('user_name' => $user_name, 'user_password' => password_hash($user_password,PASSWORD_DEFAULT),'user_fullname' => $user_fullname, 'user_level' => $user_level);
            $user_id    = $this->dbase->dataInsert('user',$arr);
            if (!$user_id){
                $json['msg'] = 'Database error';
            } else {
                $json['t'] = 1;
                $json['msg'] = 'Pengguna berhasil dibuat';
            }
        }
        die(json_encode($json));
    }
    function edit_user(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $user_id    = $this->uri->segment(3);
        $data_user  = $this->dbase->dataRow('user',array('user_id'=>$user_id));
        if (!$user_id || !$data_user){
            die('Invalid data');
        } else {
            $data['data']   = $data_user;
            $this->load->view('admin/form/edit_user',$data);
        }
    }
    function edit_user_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'user_name';

        $user_id        = $this->input->post('user_id');
        $data_user      = $this->dbase->dataRow('user',array('user_id'=>$user_id));
        $user_fullname  = $this->input->post('user_fullname');
        $user_name      = $this->input->post('user_name');
        $user_password  = $this->input->post('user_password');
        $user_level     = $this->input->post('user_level');
        $chk_username   = $this->dbase->dataRow('user',array('user_name'=>$user_name,'user_id !='=>$user_id));
        if (!$user_id || !$data_user){
            $json['msg'] = 'Invalid data';
        } elseif (strlen(trim($user_fullname)) == 0){
            $json['msg'] = 'Mohon isi <strong>Nama Lengkap Pengguna</strong>';
            $json['class'] = 'user_fullname';
        } elseif (strlen(trim($user_name)) == 0){
            $json['msg'] = 'Mohon isi <strong>Username</strong>';
        } elseif (strlen(trim($user_name)) > 20){
            $json['msg'] = '<strong>Username</strong> tidak boleh terlalu panjang (Max 20 karakter)';
        } elseif ($chk_username){
            $json['msg'] = '<strong>Username</strong> sudah terpakai oleh pengguna dengan nama <strong>'.$chk_username->user_fullname.'</strong>';
        //} elseif (strlen(trim($user_password)) == 0){
        //    $json['msg'] = 'Mohon isi <strong>Password pengguna</strong>';
        //} elseif (strlen(trim($user_password)) < 5){
        //    $json['msg'] = '<strong>Password Pengguna</strong> terlalu sedikit (Min 5 karakter)';
        } else {
            $arr = array('user_name' => $user_name, 'user_fullname' => $user_fullname, 'user_level' => $user_level);
            if (strlen(trim($user_password)) > 0){
                $arr = array('user_name' => $user_name, 'user_password' => password_hash($user_password,PASSWORD_DEFAULT),'user_fullname' => $user_fullname, 'user_level' => $user_level);
            }
            $this->dbase->dataUpdate('user',array('user_id'=>$user_id),$arr);
            $json['t'] = 1;
            $json['msg'] = 'Pengguna berhasil dirubah';
        }
        die(json_encode($json));
    }
    function runing_text(){
	    $this->load->view('admin/runing_text');
    }
    function admin_runing_text_data(){
	    $json['t'] = 0;
	    $json['msg'] = 'Tidak ada data';
	    $keyword = $this->input->post('keyword');
	    $sql = "SELECT * FROM tb_marquee WHERE rt_status = 1 AND rt_content LIKE '%".$keyword."%' ";
	    $data_rt = $this->dbase->sqlResult($sql);
	    if ($data_rt){
	        $data['data']   = $data_rt;
	        $json['t'] = 1;
	        $json['html'] = $this->load->view('admin/admin_runing_text_data',$data,TRUE);
        }
        die(json_encode($json));
    }
    function add_runing_text(){
	    $this->load->view('admin/form/add_runing_text');
    }
    function add_runing_text_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Tidak ada data';
        $json['class'] = 'rt_name';
        $rt_content = $this->input->post('rt_name');
        if (strlen(trim(strip_tags($rt_content))) == 0){
            $json['msg'] = 'Mohon isikan <strong>Isi Runing Text</strong>';
        } elseif (strlen(trim(strip_tags($rt_content))) < 10){
            $json['msg'] = '<strong>Isi Runing Text</strong> terlalu sedikit';
        } else {
            $rt_id = $this->dbase->dataInsert('marquee',array('rt_content'=>$rt_content));
            if (!$rt_id){
                $json['msg'] = 'Database error';
            } else {
                $json['t'] = 1;
                $json['msg'] = '<strong>Runing Text</strong> berhasil dibuat';
            }
        }
        die(json_encode($json));
    }
    function edit_runing_text(){
	    $rt_id = $this->uri->segment(3);
	    $data_rt = $this->dbase->dataRow('marquee',array('rt_id'=>$rt_id));
	    if (!$rt_id || !$data_rt){
	        die('Invalid data');
        } else {
	        $data['data'] = $data_rt;
	        $this->load->view('admin/form/edit_runing_text',$data);
        }
    }
    function edit_runing_text_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Tidak ada data';
        $json['class'] = 'rt_name';
        $rt_id = $this->input->post('rt_id');
        $data_rt = $this->dbase->dataRow('marquee',array('rt_id'=>$rt_id));
        $rt_content = $this->input->post('rt_name');
        if (!$data_rt || !$rt_id){
            $json['msg'] = 'Invalid data';
        } elseif (strlen(trim(strip_tags($rt_content))) == 0){
            $json['msg'] = 'Mohon isikan <strong>Isi Runing Text</strong>';
        } elseif (strlen(trim(strip_tags($rt_content))) < 10){
            $json['msg'] = '<strong>Isi Runing Text</strong> terlalu sedikit';
        } else {
            $this->dbase->dataUpdate('marquee',array('rt_id'=>$rt_id),array('rt_content'=>$rt_content));
            $json['t'] = 1;
            $json['msg'] = '<strong>Runing Text</strong> berhasil dirubah';
        }
        die(json_encode($json));
    }
    function delete_runing_text(){
        $rt_id = $this->uri->segment(3);
        $data_rt = $this->dbase->dataRow('marquee',array('rt_id'=>$rt_id));
        if (!$rt_id || !$data_rt){
            die('Invalid data');
        } else {
            $data['data'] = $data_rt;
            $this->load->view('admin/form/delete_runing_text',$data);
        }
    }
    function delete_runing_text_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Tidak ada data';
        $rt_id = $this->input->post('rt_id');
        $data_rt = $this->dbase->dataRow('marquee',array('rt_id'=>$rt_id));
        if (!$data_rt || !$rt_id){
            $json['msg'] = 'Invalid data';
        } else {
            $this->dbase->dataUpdate('marquee',array('rt_id'=>$rt_id),array('rt_status'=>0));
            $json['t'] = 1;
            $json['msg'] = '<strong>Runing Text</strong> berhasil dihapus';
        }
        die(json_encode($json));
    }
    function video(){
	    $this->load->view('admin/admin_video');
    }
    function admin_video_data(){
        $json['t'] = 0;
        $json['msg'] = 'Tidak ada data';
        $keyword = $this->input->post('keyword');
        $sql = "SELECT * FROM tb_media WHERE media_status = 1 AND media_name LIKE '%".$keyword."%' ";
        $data_rt = $this->dbase->sqlResult($sql);
        if ($data_rt){
            $data['data']   = $data_rt;
            $json['t'] = 1;
            $json['html'] = $this->load->view('admin/admin_video_data',$data,TRUE);
        }
        die(json_encode($json));
    }
    function add_video(){
	    $this->load->view('admin/form/add_video');
    }
    function upload_video(){
        set_time_limit(0);
	    $dir    = FCPATH . 'assets/video/';
        $media	= $_FILES["media"];
        $ext	= pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);
        $name   = $_FILES['media']['name'];
        $tmp_name = $_FILES['media']['tmp_name'];
        $tgl	= date("Y-m-d");
        $new_name = md5($tgl.$name).'.'.$ext;
        $target = $dir . $new_name;
        $this->dbase->dataInsert('media',array('media_name'=>$name,'media_url'=>$new_name));
        move_uploaded_file($tmp_name,$target);
        echo 'X';
    }
    function delete_video(){
        $media_id   = $this->uri->segment(3);
        $data_media = $this->dbase->dataRow('media',array('media_id'=>$media_id));
        if (!$media_id || !$data_media){
            die('Invalid data');
        } else {
            $data['data'] = $data_media;
            $this->load->view('admin/form/delete_media',$data);
        }
    }
    function delete_media_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Tidak ada data';
	    $media_id   = $this->input->post('media_id');
        $data_media = $this->dbase->dataRow('media',array('media_id'=>$media_id));
        if (!$media_id || !$data_media){
            $json['msg'] = 'Tidak ada data';
        } else {
            if (file_exists(FCPATH.'assets/video/'.$data_media->media_url)){
                @unlink(FCPATH.'assets/video/'.$data_media->media_url);
            }
            $this->dbase->dataUpdate('media',array('media_id'=>$media_id),array('media_status'=>0));
            $json['t'] = 1;
            $json['msg'] = 'Berhasil menghapus data';
        }
        die(json_encode($json));
    }
    public function printer(){
	    $data = $this->dbase->dataRow('printer');
	    //die(var_dump($data));
	    $this->load->view('admin/printer', ['data' => $data]);
    }
    public function printer_save() {
	    $json['t'] = 0;
	    $json['msg'] = 'Gagal';
	    $nama_printer = $this->input->post('nama_printer');
	    $ip_printer = $this->input->post('ip_printer');
	    $dataPrinter = $this->dbase->dataRow('printer');
	    if ($dataPrinter == null) {
            $dataPrinter = $this->dbase->dataInsert('printer', ['name' => $nama_printer, 'ip' => $ip_printer]);
        } else {
	        $dataPrinter = $this->dbase->dataUpdate('printer',['id' => $dataPrinter->id], ['name' => $nama_printer, 'ip' => $ip_printer]);
        }
        if (!$dataPrinter){
            $json['msg'] = 'Database error';
        } else {
            $json['t'] = 1;
            $json['msg'] = '<strong>Printer</strong> berhasil disimpan';
        }
    }
}
