<?php


class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function read_entry($id = null){
        $json['t'] = 0;
        if ($id == null) {
            $data_call = $this->dbase->dataRow('calling',array('call_status'=>0,'DATE(call_date)'=>date('Y-m-d'),'que_id !='=>NULL),'*','call_date','ASC');
        } else {
            $data_call = $this->dbase->dataRow('calling',array('call_id' => $id ),'*','call_date','ASC');
        }
        if ($data_call){
            $data_que = $this->dbase->dataRow('queue',array('que_id'=>$data_call->que_id));
            if ($data_que){
                $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$data_que->loket_id));
                if ($data_loket){
                    //$this->dbase->dataUpdate('calling',array('call_id'=>$data_call->call_id),array('call_status'=>1));
                    $json['t'] = 1;
                    $json['loket_name'] = $data_loket->loket_name;
                    $json['que_kode'] = $data_que->que_kode.$data_que->que_kode2;
                    $json['speaker'] = "Antrian untuk nomor. ".$data_que->que_kode."! ".(int)$data_que->que_kode2."! silahkan menuju? ".$data_loket->loket_name."!";
                }
            }
        }
        die(json_encode($json));
    }
}