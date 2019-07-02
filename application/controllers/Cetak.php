<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once APPPATH . 'libraries\escpos\autoload.php';
//use Mike42\Escpos\Printer;
//use Mike42\Escpos\EscposImage;
//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class Cetak extends CI_Controller {

	public function index(){

	}
    function insert_queue(){
        date_default_timezone_set('Asia/Jakarta');
	    $json['t'] = 0;
	    $dr_id  = $this->input->post('dr_id');
	    $data_dr    = $this->dbase->dataRow('dokter',array('dr_id'=>$dr_id));
	    if (!$dr_id || !$data_dr){
	        $json['msg'] = 'Data Dokter Invalid';
        } elseif (strlen(trim($data_dr->poli_id)) == 0) {
            $json['msg'] = 'Dokter tidak punya poli';
        } else {
	        $data_poli = $this->dbase->dataRow('poli',array('poli_id'=>$data_dr->poli_id));
	        if (!$data_poli){
                $json['msg'] = 'Invalid data Poli';
            } else {
	            $data_loket = $this->dbase->dataRow('loket',array('loket_id'=>$data_poli->loket_id));
	            if (!$data_loket){
	                $json['msg'] = 'Invalid data Loket';
                } else {
	                $data_user = $this->dbase->dataRow('user',array('user_id'=>$data_dr->user_id),'user_fullname');
                    $kode   = $this->dbase->dataRow('queue',array('poli_id'=>$data_dr->poli_id,'DATE(que_date)'=>date('Y-m-d')),'COUNT(que_id) AS kode');
                    if ($kode){
                        $kode = $kode->kode;
                    } else {
                        $kode = 0;
                    }
                    $kode = $kode + 1;
                    $kode = str_pad($kode,3,"0",STR_PAD_LEFT);
                    $ar = array(
                        'poli_id'   =>  $data_dr->poli_id,      'dr_id' =>  $dr_id,
                        'loket_id'  =>  $this->dbase->dataRow('poli',array('poli_id'=>$data_dr->poli_id),'loket_id')->loket_id,
                        'que_kode'  => $data_loket->loket_kode, 'que_kode2' => $kode,
                        'que_date' => date('Y-m-d H:i:s')
                    );
                    $que_id = $this->dbase->dataInsert('queue',$ar);
                    $kode_poli = $this->dbase->dataRow('queue_poli',array('poli_id'=>$data_dr->poli_id,'DATE(qpol_date)'=>date('Y-m-d')),'COUNT(qpol_id) AS kode');
                    if ($kode_poli){
                        $kode_poli = $kode_poli->kode;
                    } else {
                        $kode_poli = 0;
                    }
                    $kode_poli = $kode_poli + 1;
                    $kode_poli = str_pad($kode_poli,3,"0",STR_PAD_LEFT);
                    $ar_poli = array('qpol_date'=>date('Y-m-d H:i:s'),'poli_id'=>$data_dr->poli_id,'dr_id'=>$dr_id,'qpol_kode1'=>$data_poli->poli_kode,'qpol_kode2'=>$kode_poli);
                    $qpol_id = $this->dbase->dataInsert('queue_poli',$ar_poli);
                    if (!$que_id && !$qpol_id){
                        $json['msg'] = 'Database error';
                    } else {
                        $this->load->library('conv');
                        $kode_lengkap   = $data_loket->loket_kode.$kode;
                        $kode_poli_lengkap = $data_poli->poli_kode.$kode_poli;
                        $dt_rs  = $this->dbase->dataRow('rumkit',array('rs_id'=>1));
                        if ($dt_rs){
                            if (strlen(trim($dt_rs->rs_printer_name)) == 0) {
                                $json['msg'] = 'Printer belum diset';
                            } else {
                                $json['msg'] = 'OK';
//                                $connector = new WindowsPrintConnector($dt_rs->rs_printer_name);
//                                //$connector = new NetworkPrintConnector("192.168.1.169", 9100);
//                                $printer = new Printer($connector);
//                                try {
//                                    //struk pendaftaran
//                                    $tux = EscposImage::load(FCPATH . 'assets/img/logo-small.png', false);
//                                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
//                                    $printer -> bitImage($tux);
//                                    $printer -> text("____________________");
//                                    $printer -> feed();
//                                    $printer -> text("Nomor Antrian :");
//                                    $printer -> feed();
//                                    $printer -> setTextSize(8, 8);
//                                    $printer -> text($kode_lengkap);
//                                    $printer -> feed();
//                                    $printer -> qrCode($kode_lengkap,Printer::QR_ECLEVEL_L, 8);
//                                    $printer -> feed();
//                                    $printer -> setTextSize(1, 1);
//                                    $printer -> text($data_loket->loket_name."\n");
//                                    $printer -> text($this->conv->hariIndo(date('N')).", ".$this->conv->tglIndo(date('Y-m-d')));
//                                    $printer -> feed();
//                                    $printer -> text("\n>--------------------->\n");
//
//                                    //struk poli
//                                    $tux = EscposImage::load(FCPATH . 'assets/img/logo-small.png', false);
//                                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
//                                    $printer -> bitImage($tux);
//                                    $printer -> text("\n____________________\n");
//                                    $printer -> feed();
//                                    $printer -> text("Nomor Antrian Poli :");
//                                    $printer -> feed();
//                                    $printer -> setTextSize(8, 8);
//                                    $printer -> text($kode_poli_lengkap);
//                                    $printer -> feed();
//                                    $printer -> qrCode($kode_poli_lengkap.' - '.$data_user->user_fullname,Printer::QR_ECLEVEL_L, 8);
//                                    $printer -> feed();
//                                    $printer -> setTextSize(1, 1);
//                                    $printer -> text($data_poli->poli_name."\n");
//                                    $printer -> text($data_user->user_fullname."\n");
//                                    $printer -> text($this->conv->hariIndo(date('N')).", ".$this->conv->tglIndo(date('Y-m-d')));
//                                    $printer -> feed(3);
//
//
//
//                                } catch (Exception $e) {
//                                    /* Images not supported on your PHP, or image file not found */
//                                    $printer -> text($e -> getMessage() . "\n");
//                                }
//
//                                $printer -> cut();
//                                $printer -> close();
                            }
                        }
                        $json['t']  = 1;
                    }
                }
            }
        }
        die(json_encode($json));
    }
}
