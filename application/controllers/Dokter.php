<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {
    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }
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
	function admin_dokter(){
	    $data['data'] = $this->dbase->dataResult('spesialis',array('spc_status'=>1));
	    $this->load->view('admin/admin_dokter',$data);
    }
    function admin_dokter_data(){
	    if (!$this->input->is_ajax_request()){
	        redirect(base_url());
        }
        $json['t'] = 0;
	    $keyword        = $this->input->post('keyword');
	    $spc_id         = $this->input->post('spc_id');
	    $sql_spc        = "";
	    if ($spc_id){
	        $sql_spc    = " AND sp.spc_id = '".$spc_id."' ";
        }
        $sql = " SELECT     us.*,dt.dr_id,sp.spc_id,sp.spc_name,dt.dr_quota
                 FROM       tb_dokter AS dt
                 LEFT JOIN  tb_user AS us ON dt.user_id = us.user_id
                 LEFT JOIN  tb_spesialis AS sp ON dt.spc_id = sp.spc_id
                 WHERE      (
                              us.user_fullname LIKE '%".$keyword."%'
                            ) AND us.user_status = 1 AND dt.dr_status = 1  ".$sql_spc."
                 ORDER BY us.user_fullname ASC ";
	    $data_dokter    = $this->dbase->sqlResult($sql);
	    if (!$data_dokter){
	        $json['msg'] = 'Tidak ada data dokter';
        } else {
	        $json['t'] = 1;
	        $data['data']   = $data_dokter;
	        $json['html']   = $this->load->view('admin/admin_dokter_data',$data,TRUE);
        }
	    die(json_encode($json));
    }
    function add_dokter(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $data['poli'] = $this->dbase->dataResult('poli',array('poli_status'=>1));
        $data['data'] = $this->dbase->dataResult('spesialis',array('spc_status'=>1));
        $this->load->view('admin/form/add_dokter',$data);
    }
    function add_dokter_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'dr_name';
        $dr_name    = $this->input->post('dr_name');
        $spc_id     = $this->input->post('spc_id');
        $data_spc   = $this->dbase->dataRow('spesialis',array('spc_id'=>$spc_id));
        $user_name  = $this->input->post('user_name');
        $user_pass  = $this->input->post('user_password');
        $chk_user   = $this->dbase->dataRow('user',array('user_name'=>$user_name));
        $dr_quota   = (int)$this->input->post('dr_quota');
        $poli_id    = $this->input->post('poli_id');
        $data_poli  = $this->dbase->dataRow('poli',array('poli_id'=>$poli_id));
        if (strlen(trim($dr_name)) == 0){
            $json['msg'] = 'Mohon masukkan <strong>nama lengkap dokter</strong>';
        } elseif (!$spc_id || !$data_spc){
            $json['msg'] = 'Mohon pilih <strong>Spesialisasi Dokter</strong>';
            $json['class'] = 'spc_id';
        } elseif (strlen(trim($user_name)) == 0){
            $json['msg'] = 'Mohon masukkan <strong>Nama Pengguna Dokter</strong>';
            $json['class'] = 'user_name';
        } elseif (strlen(trim($user_name)) > 100){
            $json['msg'] = '<strong>Nama Pengguna Dokter</strong> terlalu panjang';
            $json['class'] = 'user_name';
        } elseif ($chk_user){
            $json['msg'] = '<strong>Nama Pengguna Dokter</strong> sudah terpakai oleh <strong>'.$chk_user->user_fullname.'</strong>';
            $json['class'] = 'user_name';
        } elseif (strlen(trim($user_pass)) == 0){
            $json['msg'] = 'Mohon masukkan <strong>Password</strong>';
            $json['class'] = 'user_pass';
        } elseif ($dr_quota == 0){
            $json['msg'] = 'Mohon isikan <strong>Quota Dokter</strong>';
            $json['class'] = 'dr_quota';
        } elseif ($dr_quota > 999) {
            $json['msg'] = '<strong>Quota Dokter</strong> terlalu besar';
            $json['class'] = 'dr_quota';
        } elseif (!$poli_id || !$data_poli){
            $json['msg'] = 'Mohon pilih <strong>Poli</strong>';
            $json['class'] = 'poli_id';
        } else {
            $arr_u = array(
                'user_fullname' =>  $dr_name,       'user_name' =>  $user_name,
                'user_password' =>  password_hash($user_pass,PASSWORD_DEFAULT),
                'user_level'    => 50
            );
            $user_id    = $this->dbase->dataInsert('user',$arr_u);
            if (!$user_id){
                $json['msg'] = 'Database error'; $json['class'] = 'dr_name';
            } else {
                $arr_dr = array('user_id'=>$user_id,'dr_quota'=>$dr_quota,'spc_id'=>$spc_id,'poli_id'=>$poli_id);
                $dr_id  = $this->dbase->dataInsert('dokter',$arr_dr);
                if (!$dr_id){
                    $json['msg'] = 'Database error';
                    $this->dbase->dataDelete('user',array('user_id'=>$user_id));
                } else {
                    $json['msg'] = 'Berhasil membuat data dokter';
                    $json['t']  = 1;
                }
            }
        }
        die(json_encode($json));
    }
    function admin_jadwal(){
	    $dr_id  = $this->uri->segment(3);
	    $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
	    if (!$dr_id || !$data_dr){
	        die('Invalid data dokter');
        } else {
	        $data_user  = $this->dbase->dataRow('user',array('user_id'=>$data_dr->user_id));
	        if (!$data_user){
	            die('Invalid data user');
            } else {
                $data['data']   = $data_dr;
                $data['user']   = $data_user;
                $this->load->view('admin/admin_jadwal',$data);
            }
        }
    }
    function admin_jadwal_data(){
	    $json['t']  = 0;
	    $dr_id      = $this->input->post('dr_id');
	    $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
	    $data_jad   = $this->dbase->dataResult('dokter_jadwal',array('dr_id'=>$dr_id,'djad_status'=>1),'*','djad_day','asc');
	    if (!$dr_id || !$data_dr) {
            $json['msg'] = 'Invalid data dokter';
        } elseif (!$data_jad){
	        $json['msg'] = 'Jadwal tidak ditemukan';
        } else {
	        $this->load->library('conv');
            $json['t']  = 1;
            $data['data']   =  $data_jad;
            $json['html'] = $this->load->view('admin/admin_jadwal_data',$data,TRUE);
        }
	    die(json_encode($json));
    }
    function add_jadwal(){
	    $dr_id  = $this->uri->segment(3);
	    $data_dr = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
	    if (!$dr_id || !$data_dr){
	        die('Invalid data dokter');
        } else {
	        $data['data']   = $data_dr;
	        $this->load->view('admin/form/add_jadwal',$data);
        }
    }
    function add_jadwal_submit(){
        $json['t']  = 0;
        $json['class'] = 'djad_day';
        $json['msg'] = '';
        $dr_id  = $this->input->post('dr_id');
        $jad_day    = $this->input->post('djad_day');
        $jad_start  = $this->input->post('djad_start');
        $jad_end    = $this->input->post('djad_end');
        $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
        if (!$dr_id || !$data_dr){
            $json['msg'] = 'Invalid data dokter';
        } elseif ($jad_day < 1 && $jad_day > 7){
            $json['msg'] = 'Hari tidak valid';
            $json['class'] = 'djad_day';
        } elseif (!strtotime($jad_start)){
            $json['msg'] = '<strong>Jam Mulai</strong> tidak valid';
            $json['class'] = 'djad_start';
        } elseif (!strtotime($jad_end)){
            $json['msg'] = '<strong>Jam Selesai</strong> tidak valid';
            $json['class'] = 'djad_end';
        } else {
            $start      = new DateTime($jad_start);
            $end        = new DateTime($jad_end);
            $time_antri = $start->modify('-1 hours');
            //die(var_dump($time_antri->format('H:i:s')));
            $time_antri = $time_antri->format('H:i:s');

            if ($start->diff($end)->format('%R') == '-'){
                $json['msg'] = '<strong>Jam Selesai</strong> tidak boleh melebihi <strong>Jam Mulai</strong>, atau sebaliknya.';
                $json['class'] = 'djad_jam';
            } else {
                $chk_jad    = $this->dbase->dataRow('dokter_jadwal',array('dr_id'=>$dr_id,'djad_day'=>$jad_day,'djad_time_start'=>$jad_start,'djad_time_end'=>$jad_end));
                if ($chk_jad){
                    //$arr = array('djad_day'=>$jad_day, 'djad_time_start'=>$jad_start,'djad_time_end'=>$jad_end);
                    //$this->dbase->dataUpdate('dokter_jadwal',array('djad_id'=>$chk_jad->djad_id),$arr);
                    //$djad_id    = $chk_jad->djad_id;
                    $json['msg'] = 'Jadwal dokter sudah ada pada jam ini';
                } else {
                    $arr = array('dr_id'=>$dr_id, 'djad_day'=>$jad_day, 'djad_time_start'=>$jad_start,'djad_time_end'=>$jad_end,'djad_time_antri'=>$time_antri);
                    $djad_id    = $this->dbase->dataInsert('dokter_jadwal',$arr);
                    $json['msg'] = 'Jadwal dokter berhasil dibuat';
                    if (!$djad_id){
                        $json['msg'] = 'Database error';
                    } else {
                        $json['t'] = 1;

                    }
                }
            }
        }
        die(json_encode($json));
    }
    function edit_jadwal(){
        $djad_id    = $this->uri->segment(3);
        $data_djad  = $this->dbase->dataRow('dokter_jadwal',array('djad_id'=>$djad_id));
        if (!$djad_id || !$data_djad){
            die('Invalid data jadwal');
        } else {
            $data['data']   = $data_djad;
            $this->load->view('admin/form/edit_jadwal',$data);
        }
    }
    function edit_jadwal_submit(){
        $json['t']  = 0;
        $json['class'] = 'djad_day';
        $json['msg'] = '';
        $djad_id    = $this->input->post('djad_id');
        $data_djad  = $this->dbase->dataRow('dokter_jadwal',array('djad_id'=>$djad_id));
        $jad_day    = $this->input->post('djad_day');
        $jad_start  = $this->input->post('djad_start');
        $jad_end    = $this->input->post('djad_end');

        if (!$djad_id || !$data_djad){
            $json['msg'] = 'Invalid data jadwal';
        } elseif ($jad_day < 1 && $jad_day > 7){
            $json['msg'] = 'Hari tidak valid';
            $json['class'] = 'djad_day';
        } elseif (!strtotime($jad_start)){
            $json['msg'] = '<strong>Jam Mulai</strong> tidak valid';
            $json['class'] = 'djad_start';
        } elseif (!strtotime($jad_end)){
            $json['msg'] = '<strong>Jam Selesai</strong> tidak valid';
            $json['class'] = 'djad_end';
        } else {
            $start      = new DateTime($jad_start);
            $end        = new DateTime($jad_end);
            $time_antri = $start->modify('-1 hours');
            //die(var_dump($time_antri->format('H:i:s')));
            $time_antri = $time_antri->format('H:i:s');

            if ($start->diff($end)->format('%R') == '-'){
                $json['msg'] = '<strong>Jam Selesai</strong> tidak boleh melebihi <strong>Jam Mulai</strong>, atau sebaliknya.';
                $json['class'] = 'djad_jam';
            } else {
                $arr = array('djad_day'=>$jad_day, 'djad_time_start'=>$jad_start,'djad_time_end'=>$jad_end,'djad_time_antri'=>$time_antri);
                $this->dbase->dataUpdate('dokter_jadwal',array('djad_id'=>$djad_id),$arr);
                $json['t'] = 1;
                $json['msg'] = 'Jadwal dokter berhasil dirubah';
            }
        }
        die(json_encode($json));
    }
    function delete_jadwal(){
        $djad_id    = $this->uri->segment(3);
        $data_djad  = $this->dbase->dataRow('dokter_jadwal',array('djad_id'=>$djad_id));
        if (!$djad_id || !$data_djad){
            die('Invalid data jadwal');
        } else {
            $data['data']   = $data_djad;
            $this->load->view('admin/form/delete_jadwal',$data);
        }
    }
    function delete_jadwal_submit(){
        $json['t'] = 0;
        $djad_id    = $this->input->post('id');
        $data_djad  = $this->dbase->dataRow('dokter_jadwal',array('djad_id'=>$djad_id));
        if (!$data_djad || !$djad_id){
             $json['msg'] = 'Invalid data jadwal';
        } else {
            $this->dbase->dataUpdate('dokter_jadwal',array('djad_id'=>$djad_id),array('djad_status'=>0));
            $json['t'] = 1;
            $json['msg'] = 'Jadwal berhasil dihapus';
        }
        die(json_encode($json));
    }
    function edit_dokter(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $dr_id  = $this->uri->segment(3);
        $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
        if (!$dr_id || !$data_dr){
            die('Invalid data dokter');
        } else {
            $data_user  = $this->dbase->dataRow('user',array('user_id'=>$data_dr->user_id));
            if (!$data_user){
                die('Invalid data user');
            } else {
                $data['user'] = $data_user;
                $data['data']   = $data_dr;
                $data['poli'] = $this->dbase->dataResult('poli',array('poli_status'=>1));
                $data['spc'] = $this->dbase->dataResult('spesialis',array('spc_status'=>1));
                $this->load->view('admin/form/edit_dokter',$data);
            }
        }
    }
    function edit_dokter_submit(){
        if (!$this->input->is_ajax_request()){
            redirect(base_url());
        }
        $json['t']  = 0;
        $json['class'] = 'dr_name';
        $dr_id      = $this->input->post('dr_id');
        $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
        $dr_name    = $this->input->post('dr_name');
        $spc_id     = $this->input->post('spc_id');
        $data_spc   = $this->dbase->dataRow('spesialis',array('spc_id'=>$spc_id));
        $user_name  = $this->input->post('user_name');
        $user_pass  = $this->input->post('user_password');
        $dr_quota   = (int)$this->input->post('dr_quota');
        $poli_id    = $this->input->post('poli_id');
        $data_poli  = $this->dbase->dataRow('poli',array('poli_id'=>$poli_id));

        if (!$dr_id || !$data_dr){
            $json['msg'] = 'Invalid data dokter';
        } elseif (strlen(trim($dr_name)) == 0){
            $json['msg'] = 'Mohon masukkan <strong>nama lengkap dokter</strong>';
        } elseif (!$spc_id || !$data_spc){
            $json['msg'] = 'Mohon pilih <strong>Spesialisasi Dokter</strong>';
            $json['class'] = 'spc_id';
        } elseif (strlen(trim($user_name)) == 0){
            $json['msg'] = 'Mohon masukkan <strong>Nama Pengguna Dokter</strong>';
            $json['class'] = 'user_name';
        } elseif (strlen(trim($user_name)) > 100) {
            $json['msg'] = '<strong>Nama Pengguna Dokter</strong> terlalu panjang';
            $json['class'] = 'user_name';
        } elseif ($this->dbase->dataRow('user',array('user_id !='=>$data_dr->user_id,'user_name'=>$user_name))){
            $json['msg'] = '<strong>Nama Pengguna Dokter</strong> sudah terpakai';
            $json['class'] = 'user_name';
        //} elseif (strlen(trim($user_pass)) == 0){
        //    $json['msg'] = 'Mohon masukkan <strong>Password</strong>';
        //    $json['class'] = 'user_pass';
        } elseif ($dr_quota == 0){
            $json['msg'] = 'Mohon isikan <strong>Quota Dokter</strong>';
            $json['class'] = 'dr_quota';
        } elseif ($dr_quota > 999) {
            $json['msg'] = '<strong>Quota Dokter</strong> terlalu besar';
            $json['class'] = 'dr_quota';
        } elseif (!$poli_id || !$data_poli){
            $json['msg'] = 'Mohon pilih <strong>Poli</strong>';
            $json['class'] = 'poli_id';
        } else {
            $user_id    = $this->dbase->dataRow('user',array('user_id'=>$data_dr->user_id),'user_id')->user_id;
            if (strlen(trim($user_pass)) > 0){
                $arr_u = array(
                    'user_fullname' =>  $dr_name,       'user_name' =>  $user_name,
                    'user_password' =>  password_hash($user_pass,PASSWORD_DEFAULT)
                );
            } else {
                $arr_u = array(
                    'user_fullname' =>  $dr_name,       'user_name' =>  $user_name
                );
            }

            $this->dbase->dataUpdate('user',array('user_id'=>$user_id),$arr_u);
            $this->dbase->dataUpdate('dokter',array('dr_id'=>$dr_id),array('spc_id'=>$spc_id,'dr_quota'=>$dr_quota,'poli_id'=>$poli_id));
            $json['msg'] = 'Berhasil merubah data dokter';
            $json['t']  = 1;
        }
        die(json_encode($json));
    }
    function admin_spesialis(){
        $this->load->view('admin/admin_spesialis');
    }
    function admin_spesialis_data(){
        $json['t'] = 0;
        $json['msg'] = 'Tidak ada data';
        $keyword    = $this->input->post('keyword');
        $sql    = " SELECT    Count(dt.dr_id) AS jml,sp.spc_name,sp.spc_id  
                    FROM      tb_spesialis AS sp
                    LEFT JOIN tb_dokter AS dt ON dt.spc_id = sp.spc_id AND dt.dr_status = 1
                    WHERE     ( sp.spc_name LIKE '%".$keyword."%' ) AND sp.spc_status = 1
                    GROUP BY  sp.spc_name,sp.spc_id
                    ORDER BY  sp.spc_name ASC  ";
        $data_s = $this->dbase->sqlResult($sql);
        if ($data_s){
            $data['data']   = $data_s;
            $json['t'] = 1;
            $json['html'] = $this->load->view('admin/admin_spesialis_data',$data,TRUE);
        }
        die(json_encode($json));
    }
    function add_spesialis(){
        $this->load->view('admin/form/add_spesialis');
    }
    function add_spesialis_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $json['class'] = 'spc_name';
        $spc_name   = $this->input->post('spc_name');
        $data_spc   = $this->dbase->dataRow('spesialis',array('spc_name'=>$spc_name,'spc_status'=>1));
        if (strlen(trim($spc_name)) == 0){
            $json['msg'] = 'Mohon isikan <strong>Nama Spesialisasi</strong>';
        } elseif ($data_spc){
            $json['msg'] = '<strong>Nama Spesialisasi</strong> sudah terpakai';
        } else {
            $spc_id = $this->dbase->dataInsert('spesialis',array('spc_name'=>$spc_name));
            if (!$spc_id){
                $json['msg'] = 'Database error';
            } else {
                $json['t'] = 1;
                $json['msg'] = 'Berhasil membuat data <strong>Spesialisasi</strong>';
            }
        }
        die(json_encode($json));
    }
    function edit_spesialis(){
        $spc_id = $this->uri->segment(3);
        $data_spc = $this->dbase->dataRow('spesialis',array('spc_id'=>$spc_id));
        if (!$spc_id || !$data_spc){
            die('Invalid data');
        } else {
            $data['data']   = $data_spc;
            $this->load->view('admin/form/edit_spesialis',$data);
        }
    }
    function edit_spesialis_submit(){
        $spc_id = $this->input->post('spc_id');
        $json['t'] = 0;
        $json['class'] = 'spc_name';
        $json['msg'] = 'Invalid data';
        $spc_name = $this->input->post('spc_name');
        $data_spc = $this->dbase->dataRow('spesialis',array('spc_id'=>$spc_id));
        $chk_name   = $this->dbase->dataRow('spesialis',array('spc_id !='=>$spc_id,'spc_name'=>$spc_name,'spc_status'=>1));
        if (!$data_spc || !$spc_id) {
            $json['msg'] = 'Invalid data';
        } elseif (strlen(trim($spc_name)) == 0){
            $json['msg'] = 'Mohon isikan <strong>Nama Spesialisasi</strong>';
        } elseif ($chk_name){
            $json['msg'] = '<strong>Nama Spesialisasi</strong> sudah terpakai';
        } else {
            $this->dbase->dataUpdate('spesialis',array('spc_id'=>$spc_id),array('spc_name'=>$spc_name));
            $json['t'] = 1;
            $json['msg'] = 'Berhasil merubah data <strong>Spesialisasi</strong>';
        }
        die(json_encode($json));
    }
    function delete_dokter(){
        $dr_id = $this->uri->segment(3);
        $data_dr = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
        if (!$data_dr || !$dr_id){
            die('Invalid data');
        } else {
            $data_user  = $this->dbase->dataRow('user',array('user_id'=>$data_dr->user_id));
            if (!$data_user){
                die('Invalid data');
            } else {
                $data['data'] = $data_dr;
                $data['user'] = $data_user;
                $this->load->view('admin/form/delete_dokter',$data);
            }
        }
    }
    function delete_dokter_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $dr_id = $this->input->post('dr_id');
        $user_id = $this->input->post('user_id');
        $data_dr = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
        $data_user = $this->dbase->dataRow('user',array('user_id'=>$user_id));
        if (!$dr_id || !$data_dr){
            $json['msg'] = 'Invalid data dokter';
        } elseif (!$user_id || !$data_user){
            $json['msg'] = 'Invalid data user';
        } else {
            $json['t'] = 1;
            $json['msg'] = 'Data dokter <strong>'.$data_user->user_fullname.'</strong> berhasil dihapus';
            $this->dbase->dataUpdate('user',array('user_id'=>$user_id),array('user_status'=>0));
            $this->dbase->dataUpdate('dokter',array('dr_id'=>$dr_id),array('dr_status'=>0));
        }
        die(json_encode($json));
    }
    function delete_spesialis(){
        $spc_id = $this->uri->segment(3);
        $data_spc = $this->dbase->dataRow('spesialis',array('spc_id'=>$spc_id));
        if (!$spc_id || !$data_spc){
            die('Invalid data');
        } else {
            $data['data'] = $data_spc;
            $this->load->view('admin/form/delete_spesialis',$data);
        }
    }
    function delete_spesialis_submit(){
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $spc_id = $this->input->post('spc_id');
        $data_spc = $this->dbase->dataRow('spesialis',array('spc_id'=>$spc_id));
        if (!$spc_id || !$data_spc){
            $json['msg'] = 'Invalid data spesialisasi';
        } else {
            $json['t'] = 1;
            $json['msg'] = 'Data spesialisasi <strong>'.$data_spc->spc_name.'</strong> berhasil dihapus';
            $this->dbase->dataUpdate('spesialis',array('spc_id'=>$spc_id),array('spc_status'=>0));
        }
        die(json_encode($json));
    }
}
