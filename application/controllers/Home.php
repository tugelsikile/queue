<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . '/vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!$this->session->userdata('queue')) {
            redirect(site_url('account/login'));
        }
        $data['data'] = $this->dbase->dataResult('loket', array('loket_status' => 1));
        $data['body'] = 'home';
        if ($this->input->is_ajax_request()) {
            $this->load->view('home', $data);
        } else {
            $this->load->view('dashboard', $data);
        }
    }
    function antrian_farmasi()
    {
        if (!$this->session->userdata('queue')) {
            redirect(site_url('account/login'));
        }
        $data['body'] = 'antrian_farmasi';
        if ($this->input->is_ajax_request()) {
            $this->load->view($data['body'], $data);
        } else {
            $this->load->view('dashboard', $data);
        }
    }
    function antrian_loket()
    {
        if (!$this->session->userdata('queue')) {
            redirect(site_url('account/login'));
        }
        $data['data'] = $this->dbase->dataResult('loket', array('loket_status' => 1));
        $data['body'] = 'antrian_loket';
        if ($this->input->is_ajax_request()) {
            $this->load->view($data['body'], $data);
        } else {
            $this->load->view('dashboard', $data);
        }
    }
    function antrian_poli()
    {
        if (!$this->session->userdata('queue')) {
            redirect(site_url('account/login'));
        }
        $data['data'] = $this->dbase->dataResult('poli', array('poli_status' => 1));
        $data['body'] = 'antrian_poli';
        if ($this->input->is_ajax_request()) {
            $this->load->view($data['body'], $data);
        } else {
            $this->load->view('dashboard', $data);
        }
    }
    function antri()
    {
        if (!$this->session->userdata('queue')) {
            redirect(site_url('account/login'));
        }
        $data['data']   = $this->dbase->dataResult('queue', array('DATE(que_date)' => date('Y-m-d'), 'que_status' => 0));
        $data['loket']  = $this->dbase->dataResult('loket', array('loket_status' => 1));
        $data['body'] = 'antrian';
        if ($this->input->is_ajax_request()) {
            $this->load->view('antrian', $data);
        } else {
            $this->load->view('dashboard', $data);
        }
    }
    function data_antri()
    {
        $json['t']  = 0;
        $json['msg'] = 'Forbidden page';
        $keyword    = $this->input->post('keyword');
        $loket_id   = $this->input->post('loket_id');

        $sql_loket  = "";
        if (strlen(trim($loket_id)) > 0) {
            $sql_loket  = " AND qu.loket_id = '" . $loket_id . "' ";
        }

        if ($this->session->userdata('queue')) {
            $sql = "SELECT  qu.*,po.poli_name,lo.loket_name,ca.call_status
                    FROM    tb_queue AS qu
                    LEFT JOIN tb_poli AS po ON qu.poli_id = po.poli_id
                    LEFT JOIN tb_loket AS lo ON po.loket_id = lo.loket_id
                    LEFT JOIN tb_calling AS ca ON qu.que_id = ca.que_id
                    WHERE   (
                              qu.que_kode LIKE '%" . $keyword . "%' OR
                              po.poli_name LIKE '%" . $keyword . "%' OR
                              lo.loket_name LIKE '%" . $keyword . "%'
                            ) AND DATE(qu.que_date) = '" . date('Y-m-d') . "' " . $sql_loket . "
                    GROUP BY qu.que_id
                    ORDER BY ca.call_status,qu.que_kode ASC
                    ";
            //ORDER BY qu.que_call ASC ";
            //die(var_dump($sql));
            $data_que   = $this->dbase->sqlResult($sql);
            if (!$data_que) {
                $json['msg'] = 'Tidak ada data';
            } else {
                $this->load->library('conv');
                $json['t']  = 1;
                $data['data'] = $data_que;
                $json['html'] = $this->load->view('data_antri', $data, TRUE);
            }
        }
        die(json_encode($json));
    }
    function insert_call_poli()
    {
        $json['t']  = 0;
        if ($this->session->userdata('queue')) {
            $user_id    = $this->session->userdata('user_id');
            $que_id     = $this->input->post('que_id');
            $dataQue    = $this->dbase->dataRow('queue', array('que_id' => $que_id));
            if ($que_id && $dataQue) {
                $arr = array(
                    'que_id' => $que_id, 'user_id' => $user_id
                );
                $call_id    = $this->dbase->dataInsert('calling', $arr);
                if ($call_id) {
                    $this->dbase->dataUpdate('queue', array('que_id' => $que_id), array('que_call' => 99));
                    $json['t'] = 1;
                }
            }
        }
        die(json_encode($json));
    }
    function insert_call()
    {
        $json['t']  = 0;
        if ($this->session->userdata('queue')) {
            $user_id    = $this->session->userdata('user_id');
            $que_id     = $this->input->post('que_id');
            $dataQue    = $this->dbase->dataRow('queue', array('que_id' => $que_id));
            if ($que_id && $dataQue) {
                $arr = array(
                    'que_id' => $que_id, 'user_id' => $user_id
                );
                $call_id    = $this->dbase->dataInsert('calling', $arr);
                if ($call_id) {
                    $this->dbase->dataUpdate('queue', array('que_id' => $que_id), array('que_call' => 99));
                    $json['t'] = 1;
                }
            }
        }
        die(json_encode($json));
    }
    function antri_statistik()
    {
        if (!$this->session->userdata('queue')) {
            redirect(site_url('account/login'));
        }
        $data['data']   = $this->dbase->dataResult('queue');
        $data['loket']  = $this->dbase->dataResult('loket', array('loket_status' => 1));
        $data['poli']   = $this->dbase->dataResult('poli', array('poli_status' => 1));
        $data['year']   = $this->dbase->dataRow('queue', array('que_status' => 1), 'MIN(YEAR(que_date)) AS tahun')->tahun;
        $data['body'] = 'home';
        if ($this->input->is_ajax_request()) {
            $this->load->view('antri_statistik', $data);
        } else {
            $this->load->view('dashboard', $data);
        }
    }
    function data_statistik()
    {
        $sql_poli = $sql_loket = "";
        $keyword    = $this->input->post('keyword');
        $loket_id   = $this->input->post('loket_id');
        if ($loket_id) {
            $sql_loket = " AND loket_id = '" . $loket_id . "' ";
        }
        $poli_id    = $this->input->post('poli_id');
        if ($poli_id) {
            $sql_poli = " AND poli_id = '" . $poli_id . "' ";
        }
        $tgl        = $this->input->post('tgl');
        $bulan      = $this->input->post('bulan');
        $tahun      = $this->input->post('tahun');
    }
    function show_antrian()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $loket_id   = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('loket', array('loket_id' => $loket_id));
        if ($loket_id || $data_loket) {
            $data['loket'] = $data_loket;
            $json['loket_name'] = $data_loket->loket_name;
            $json['t'] = 1;
            $json['html'] = $this->load->view('show_antrian', $data, TRUE);
        }
        die(json_encode($json));
    }
    function load_antrian_farmasi()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $data_antri = $this->dbase->dataResult('queue_farmasi_new', ['tanggal' => Carbon\Carbon::now()->format('Y-m-d')], false, 'created_at', 'asc');
        if (!$data_antri) {
            $json['msg'] = 'Tidak ada data antrian';
        } else {
            $json['t'] = 1;
            $data['data'] = $data_antri;
            $json['html'] = $this->load->view('load_antrian_farmasi', $data, true);
        }
        die(json_encode($json));
    }
    function load_antrian()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $loket_id = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('loket', ['loket_id' => $loket_id]);
        if (!$loket_id || !$data_loket) {
            $json['msg'] = 'Invalid data loket';
        } else {
            $today = \Carbon\Carbon::now();
            $data_antri = $this->dbase->dataResult('queue_new', ['tanggal' => $today->format('Y-m-d')], false, 'number', 'asc');
            //$data_antri = $this->dbase->dataResult('queue_new',array('que_status'=>1,'loket_id'=>$loket_id,'DATE(que_date)'=>date('Y-m-d')));
            if (!$data_antri) {
                $json['msg'] = 'Tidak ada antrian';
            } else {
                $i = 0;
                $json['t'] = 1;
                $data['loket'] = $data_loket;
                $data['data'] = $data_antri;
                $json['html'] = $this->load->view('load_antrian', $data, TRUE);
            }
        }
        die(json_encode($json));
    }
    function call_antri_poli()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $que_id = $this->input->post('que_id');
        $data_que = $this->dbase->dataRow('queue_poli_new', array('id' => $que_id));
        if (!$que_id || !$data_que) {
            $json['msg'] = 'Invalid data antri';
        } else {
            //$ar_call = array('que_id'=>$que_id,'user_id'=>$this->session->userdata('user_id'),'call_date'=>date('Y-m-d H:i:s'));
            //$call_id = $this->dbase->dataInsert('calling',$ar_call);
            $call_id = $this->dbase->dataInsert('calling_poli', ['queue_id' => $que_id, 'hari' => \Carbon\Carbon::now()->format('Y-m-d')]);
            if (!$call_id) {
                $json['msg'] = 'Database error';
            } else {
                $this->dbase->dataUpdate('queue_poli_new', array('id' => $que_id), array('call_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')));
                $json['t'] = 1;
                $json['kode'] = str_pad($data_que->number, 3, '0', STR_PAD_LEFT);
                $json['msg'] = 'Sukses';
                //$this->sendNotif(['id' => $call_id], 'panggilan-loket');
            }
        }
        die(json_encode($json));
    }
    function call_antri_farmasi()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $que_id = $this->input->post('que_id');
        $data_que = $this->dbase->dataRow('queue_farmasi_new', array('id' => $que_id));
        if (!$que_id || !$data_que) {
            $json['msg'] = 'Invalid data antri';
        } else {
            //$ar_call = array('que_id'=>$que_id,'user_id'=>$this->session->userdata('user_id'),'call_date'=>date('Y-m-d H:i:s'));
            //$call_id = $this->dbase->dataInsert('calling',$ar_call);
            $call_id = $this->dbase->dataInsert('calling_farmasi', ['queue_id' => $que_id, 'hari' => \Carbon\Carbon::now()->format('Y-m-d'), 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
            if (!$call_id) {
                $json['msg'] = 'Database error';
            } else {
                $this->dbase->dataUpdate('queue_farmasi_new', array('id' => $que_id), array('call_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')));
                $json['t'] = 1;
                $json['kode'] = str_pad($data_que->number, 3, '0', STR_PAD_LEFT);
                $json['msg'] = 'Sukses';
                //$this->sendNotif(['id' => $call_id], 'panggilan-loket');
            }
        }
        die(json_encode($json));
    }
    function call_antri()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $que_id = $this->input->post('que_id');
        $data_que = $this->dbase->dataRow('queue_new', array('id' => $que_id));
        if (!$que_id || !$data_que) {
            $json['msg'] = 'Invalid data antri';
        } else {
            //$ar_call = array('que_id'=>$que_id,'user_id'=>$this->session->userdata('user_id'),'call_date'=>date('Y-m-d H:i:s'));
            //$call_id = $this->dbase->dataInsert('calling',$ar_call);
            $call_id = $this->dbase->dataInsert('calling_loket', ['queue_id' => $que_id, 'hari' => \Carbon\Carbon::now()->format('Y-m-d')]);
            if (!$call_id) {
                $json['msg'] = 'Database error';
            } else {
                $this->dbase->dataUpdate('queue_new', array('id' => $que_id), array('call_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')));
                $json['t'] = 1;
                $json['kode'] = str_pad($data_que->number, 3, '0', STR_PAD_LEFT);
                $json['msg'] = 'Sukses';
                //$this->sendNotif(['id' => $call_id], 'panggilan-loket');
            }
        }
        die(json_encode($json));
    }
    public function sendNotif($data, $what)
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '01d420271ac734b562b9',
            '6819c84f5c8347216c0f',
            '1472597',
            $options
        );
        $data['message'] = $this->read_entry($data['id'])->speaker;
        $pusher->trigger('puskesmas', $what, $data);
    }
    function show_antrian_poli()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $poli_id   = $this->input->post('loket_id');
        $data_poli = $this->dbase->dataRow('poli', array('poli_id' => $poli_id));
        if ($poli_id || $data_poli) {
            $data['poli'] = $data_poli;
            $json['poli_name'] = $data_poli->poli_name;
            $json['t'] = 1;
            $json['html'] = $this->load->view('show_antrian_poli', $data, TRUE);
        }
        die(json_encode($json));
    }
    function load_antrian_poli()
    {
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $loket_id = $this->input->post('loket_id');
        $data_loket = $this->dbase->dataRow('poli', ['poli_id' => $loket_id]);
        if (!$loket_id || !$data_loket) {
            $json['msg'] = 'Invalid data loket';
        } else {
            $today = \Carbon\Carbon::now();
            $data_antri = $this->dbase->dataResult('queue_poli_new', ['tanggal' => $today->format('Y-m-d'), 'poli_id' => $loket_id], false, 'number', 'asc');
            //$data_antri = $this->dbase->dataResult('queue_new',array('que_status'=>1,'loket_id'=>$loket_id,'DATE(que_date)'=>date('Y-m-d')));
            if (!$data_antri) {
                $json['msg'] = 'Tidak ada antrian';
            } else {
                $i = 0;
                $json['t'] = 1;
                $data['loket'] = $data_loket;
                $data['data'] = $data_antri;
                $json['html'] = $this->load->view('load_antrian_poli', $data, TRUE);
            }
        }
        die(json_encode($json));
    }
    /*function call_antri_poli(){
        $json['t'] = 0;
        $json['msg'] = 'Invalid data';
        $qpol_id = $this->input->post('que_id');
        $data_qpol = $this->dbase->dataRow('queue_poli',array('qpol_id'=>$qpol_id));
        if (!$qpol_id || !$data_qpol){
            $json['msg'] = 'Invalid data antri';
        } else {
            $ar_call = array('qpol_id'=>$qpol_id,'user_id'=>$this->session->userdata('user_id'),'call_date'=>date('Y-m-d H:i:s'));
            $call_id = $this->dbase->dataInsert('calling',$ar_call);
            if (!$call_id){
                $json['msg'] = 'Database error';
            } else {
                $this->dbase->dataUpdate('queue',array('que_id'=>$qpol_id),array('que_call'=>1));
                $json['t'] = 1;
                $json['kode'] = $data_qpol->qpol_kode1.$data_qpol->qpol_kode2;
                $json['msg'] = 'Sukses';
                //$this->sendNotif(['id' => $call_id], 'panggilan-poli');
            }
        }
        die(json_encode($json));
    }*/

    public function sendToPoly()
    {
        $id = $this->input->post('que_id');
        $data_que = $this->dbase->dataRow('queue_new', array('id' => $id));
        //die(var_dump($data_que));
        $today = \Carbon\Carbon::now();

        // $number = $this->dbase->dataRow("queue_poli_new", false, "MAX(number) as number");
        // $nomor = $number->number;
        // (int) $nomor;
        // if ($nomor == null) {
        //     $nomor = 1;
        // } else {
        //     $nomor++;
        // }

        $this->dbase->dataInsert('queue_poli_new', [
            'created_at' => $today->format('Y-m-d H:i:s'),
            'number' => $data_que->number,
            'poli_id' => $data_que->poli_id,
            'tanggal' => $today->format('Y-m-d H:i:s'),

        ]);
        die(json_encode('success'));
    }
}
