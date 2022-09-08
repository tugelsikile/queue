<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Big_screen extends CI_Controller {

	public function index(){
	    $data['marquee'] = $this->dbase->dataResult('marquee',array('rt_status'=>1));
	    $data['media'] = $this->dbase->dataResult('media',array('media_status'=>1));
        $this->load->view('big_screen',$data);
	}
	function pendaftaran(){
        $data['marquee'] = $this->dbase->dataResult('marquee',array('rt_status'=>1));
        $data['media'] = $this->dbase->dataResult('media',array('media_status'=>1));
        $this->load->view('big_screen',$data);
    }
    function poli(){
        $data['marquee'] = $this->dbase->dataResult('marquee',array('rt_status'=>1));
        $data['media'] = $this->dbase->dataResult('media',array('media_status'=>1));
        $this->load->view('big_screen_poli',$data);
    }
	public function read_entry(){
        $json['t'] = 0;
        $data_call = $this->dbase->dataRow('calling',array('call_status'=>0,'DATE(call_date)'=>date('Y-m-d'),'que_id !='=>NULL),'*','call_date','ASC');
        if ($data_call){
            $data_que = $this->dbase->dataRow('queue',array('que_id'=>$data_call->que_id));
            if ($data_que){
                $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$data_que->loket_id));
                if ($data_loket){
                    $this->dbase->dataUpdate('calling',array('call_id'=>$data_call->call_id),array('call_status'=>1));
                    $json['t'] = 1;
                    $json['loket_name'] = $data_loket->loket_name;
                    $json['que_kode'] = $data_que->que_kode.$data_que->que_kode2;
                    $json['speaker'] = "Antrian untuk nomor. ".$data_que->que_kode."! ".(int)$data_que->que_kode2."! silahkan menuju? ".$data_loket->loket_name."!";
                }
            }
        }
        die(json_encode($json));
    }
    function read_entry_poli(){
        $json['t'] = 0;
        $data_call = $this->dbase->dataRow('calling',array('call_status'=>0,'DATE(call_date)'=>date('Y-m-d'),'qpol_id !='=>NULL),'*','call_date','ASC');
        if ($data_call){
            $data_qpol = $this->dbase->dataRow('queue_poli',array('qpol_id'=>$data_call->qpol_id));
            if ($data_qpol){
                $data_poli = $this->dbase->dataRow('poli',array('poli_id'=>$data_qpol->poli_id));
                if ($data_poli){
                    $data_dr = $this->dbase->dataRow('dokter',array('dr_id'=>$data_qpol->dr_id));
                    if ($data_dr){
                        $data_user = $this->dbase->dataRow('user',array('user_id'=>$data_dr->user_id),'user_fullname');
                        if ($data_user){
                            $this->dbase->dataUpdate('calling',array('call_id'=>$data_call->call_id),array('call_status'=>1));
                            $json['t'] = 1;
                            $json['loket_name'] = $data_poli->poli_name;
                            $json['que_kode'] = $data_qpol->qpol_kode1.$data_qpol->qpol_kode2;
                            $json['speaker'] = "Antrian untuk nomor! ".$data_qpol->qpol_kode1."! ".(int)$data_qpol->qpol_kode2."! silahkan menuju! ".$data_poli->poli_name."! dengan ".$data_user->user_fullname."! ";
                        }
                    }
                }
            }
        }
        die(json_encode($json));
    }
}
