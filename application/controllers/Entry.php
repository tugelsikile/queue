<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Entry extends CI_Controller {
    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(){
	    $this->load->view('entry');
	}
	function show_poli(){
        $data['poli']   = $this->dbase->dataResult('poli',array('poli_status'=>1));
        $this->load->view('entry/show_poli',$data);
    }
	function show_dokter(){
        $json['t'] = 0;
        $poli_id    = $this->input->post('poli_id');
        $day_now    = date('N');
        $sql = "SELECT  dr.dr_id,us.user_fullname,dr.dr_quota
                FROM    tb_dokter AS dr
                LEFT JOIN tb_user AS us ON dr.user_id = us.user_id
                WHERE   dr.poli_id = '".$poli_id."' AND dr.dr_status = 1
                GROUP BY dr.dr_id ";
        //$data_dokt  = $this->dbase->dataResult('dokter',array('poli_id'=>$poli_id,'dr_status'=>1));
        $data_dokt  = $this->dbase->sqlResult($sql);

        //die(var_dump(array_unique($data_dokt)));
        if (!$data_dokt || !$poli_id){
            $json['msg'] = '<h1 style="text-align: center">Dokter tidak tersedia</h1><div class="col-md-12"><a href="javascript:;" onclick="show_poli();return false" class="btn btn-primary btn-block">Kembali</a></div>';
        } else {
            $i = 0;
            foreach ($data_dokt as $val){
                $data_dokt[$i]  = $val;
                $antrian    = $this->dbase->dataResult('queue',array('dr_id'=>$val->dr_id,'DATE(que_date)'=>date('Y-m-d')),'que_id');
                $data_dokt[$i]->antri = count($antrian);
                $data_dokt[$i]->jam     = 0;
                $sql = "SELECT djad_id,djad_time_start,djad_time_end,djad_day  FROM  tb_dokter_jadwal
                        WHERE ( CAST('".date('H:i:s')."' AS time ) BETWEEN djad_time_antri AND djad_time_end ) AND 
                        dr_id = '".$val->dr_id."' AND djad_day = '".$day_now."' AND djad_status = 1 ";
                //$jadwal     = $this->dbase->dataRow('dokter_jadwal',array('dr_id'=>$val->dr_id,'djad_time_start <'=>date('H:i:s'),'djad_time_end >'=>date('H:i:s')));
                $jadwal = $this->dbase->sqlRow($sql);
                $data_dokt[$i]->ada_jadwal  = 0;
                if ($jadwal){
                    $data_dokt[$i]->ada_jadwal      = 1;
                    $data_dokt[$i]->djad_time_start = $jadwal->djad_time_start;
                    $data_dokt[$i]->djad_time_end   = $jadwal->djad_time_end;
                    $data_dokt[$i]->djad_day        = $jadwal->djad_day;
                    $data_dokt[$i]->jam = 1;
                }
                $i++;
            }
            $data['data']   = $data_dokt;
            $json['t']  = 1;
            $json['html'] = $this->load->view('entry/show_dokter',$data,TRUE);
        }
        die(json_encode($json));
    }
    function insert_queue(){
        $json['t']  = 0;
	    $dr_id  = $this->input->post('dr_id');
        $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
        die(json_encode($json));
    }
}
