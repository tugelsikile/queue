<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH . '/vendor/autoload.php';

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
    function farmasi(){
        $data['marquee'] = $this->dbase->dataResult('marquee',array('rt_status'=>1));
        $data['media'] = $this->dbase->dataResult('media',array('media_status'=>1));
        $this->load->view('big_screen_farmasi',$data);
    }
    function poli(){
        $data['marquee'] = $this->dbase->dataResult('marquee',array('rt_status'=>1));
        $data['media'] = $this->dbase->dataResult('media',array('media_status'=>1));
        $this->load->view('big_screen_poli',$data);
    }
	public function read_entry(){
        $json['t'] = 0;
        $data_call = $this->dbase->dataRow('calling_loket',array('call_at' => null,'hari'=>Carbon\Carbon::now()->format('Y-m-d')),'*','created_at','ASC');
        if ($data_call){
            $data_que = $this->dbase->dataRow('queue_new',array('id'=>$data_call->queue_id));
            if ($data_que){
                $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$data_que->loket_id));
                if ($data_loket){
                    $this->dbase->dataUpdate('calling_loket',array('id'=>$data_call->id),array('call_at'=> Carbon\Carbon::now()->format('Y-m-d H:i:s')));
                    $hasPoli = $this->dbase->dataRow('queue_poli_new', ['number' => $data_que->number,'poli_id' => $data_que->poli_id, 'tanggal' => Carbon\Carbon::now()->format('Y-m-d')]);
                    if ($hasPoli == null) {
                        $this->dbase->dataInsert('queue_poli_new', ['number' => $data_que->number, 'poli_id' => $data_que->poli_id,'tanggal' => Carbon\Carbon::now()->format('Y-m-d H:i:s'),'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
                    }
                    $json['t'] = 1;
                    $json['loket_name'] = $data_loket->loket_name;
                    $json['que_kode'] = str_pad($data_que->number,3,'0',STR_PAD_LEFT);
                    $json['speaker'] = "Antrian untuk nomor. ".str_pad($data_que->number,3,'0',STR_PAD_LEFT)."! silahkan menuju? ".$data_loket->loket_name."!";
                }
            }
        }
        die(json_encode($json));
    }
    function read_entry_poli(){
        $json['t'] = 0;
        $data_call = $this->dbase->dataRow('calling_poli',array('call_at' => null,'hari'=>Carbon\Carbon::now()->format('Y-m-d')),'*','created_at','ASC');
        if ($data_call){
            $data_que = $this->dbase->dataRow('queue_poli_new',array('id'=>$data_call->queue_id));
            if ($data_que){
                /*$dataMainQue = $this->dbase->dataRow('queue_new', ['id' => $data_que->queue_id]);
                if ($dataMainQue) {}*/
                $data_loket = $this->dbase->dataRow('poli',array('poli_id'=>$data_que->poli_id));
                if ($data_loket){
                    $this->dbase->dataUpdate('calling_poli',array('id'=>$data_call->id),array('call_at'=> Carbon\Carbon::now()->format('Y-m-d H:i:s')));
                    $hasFarmasi = $this->dbase->dataRow('queue_farmasi_new', ['tanggal' => Carbon\Carbon::now()->format('Y-m-d'), 'number' => $data_que->number]);
                    if ($hasFarmasi == null) {
                        $this->dbase->dataInsert('queue_farmasi_new', ['tanggal' => Carbon\Carbon::now()->format('Y-m-d'), 'number' => $data_que->number, 'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
                    }
                    $json['t'] = 1;
                    $json['loket_name'] = $data_loket->poli_name;
                    $json['que_kode'] = str_pad($data_que->number,3,'0',STR_PAD_LEFT);
                    $json['speaker'] = "Antrian untuk nomor. ".str_pad($data_que->number,3,'0',STR_PAD_LEFT)."! silahkan menuju? ".$data_loket->poli_name."!";
                }
            }
        }
        die(json_encode($json));
    }
    function read_entry_farmasi(){
        $json['t'] = 0;
        $data_call = $this->dbase->dataRow('calling_farmasi',array('call_at' => null,'hari'=>Carbon\Carbon::now()->format('Y-m-d')),'*','created_at','ASC');
        if ($data_call){
            $data_que = $this->dbase->dataRow('queue_farmasi_new',array('id'=>$data_call->queue_id));
            if ($data_que){
                $this->dbase->dataUpdate('calling_farmasi',array('id'=>$data_call->id),array('call_at'=> Carbon\Carbon::now()->format('Y-m-d H:i:s')));
                $json['t'] = 1;
                $json['loket_name'] = 'FARMASI';
                $json['que_kode'] = str_pad($data_que->number,3,'0',STR_PAD_LEFT);
                $json['speaker'] = "Antrian untuk nomor. ".str_pad($data_que->number,3,'0',STR_PAD_LEFT)."! silahkan menuju? FARMASI!";

                /*$data_loket = $this->dbase->dataRow('poli',array('poli_id'=>$data_que->poli_id));
                if ($data_loket){
                    $hasFarmasi = $this->dbase->dataRow('queue_farmasi_new', ['tanggal' => Carbon\Carbon::now()->format('Y-m-d'), 'number' => $data_que->number]);
                    if ($hasFarmasi == null) {
                        $this->dbase->dataInsert('queue_farmasi_new', ['tanggal' => Carbon\Carbon::now()->format('Y-m-d'), 'number' => $data_que->number, 'created_at' => Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
                    }
                    $json['t'] = 1;
                    $json['loket_name'] = $data_loket->poli_name;
                    $json['que_kode'] = str_pad($data_que->number,3,'0',STR_PAD_LEFT);
                    $json['speaker'] = "Antrian untuk nomor. ".str_pad($data_que->number,3,'0',STR_PAD_LEFT)."! silahkan menuju? ".$data_loket->poli_name."!";
                }*/
            }
        }
        die(json_encode($json));
    }
}
