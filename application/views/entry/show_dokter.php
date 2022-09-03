<div class="heading-poli">SILAHKAN PILIH DOKTER</div>
<?php
if (isset($data)){
    if ($data){
        foreach ($data as $value){
            $disable  = '';
            $onclick = "insert_queue(this);return false";
            $quota  = 'Antrian tidak bisa diambil';

            if ($value->ada_jadwal == 0){
                $ada            = '<i class="text-danger fa fa-circle"></i> Dokter Tidak Ada';
                $jam_praktek    = 'Tidak ada jam praktek';
                $disable        = 'disabled';
                $onclick        = '';
            } else {
                $jam_praktek    = 'Praktek Dokter Pkl : '.date('H:i',strtotime($value->djad_time_start)).' - '.date('H:i',strtotime($value->djad_time_end));
                if ($value->antri == 0 && $value->antri < $value->dr_quota){
                    $quota = '<span class="text-success">Kuota Pasien '.$value->dr_quota.', Antrian bisa diambil</span>';
                } elseif ($value->antri > 0 && $value->dr_quota > $value->antri) {
                    $quota = '<span class="text-success">Kuota Pasien '.$value->dr_quota.', Antrian tersisa '.($value->dr_quota - $value->antri).'</span>';
                } else {
                    $quota = '<span class="text-danger">Kuota Pasien '.$value->dr_quota.', Tidak ada antrian tersisa</span>';
                    $disable  = 'disabled';
                    $onclick = "show_info('Maaf Quota Antrian sudah habis');return false";
                }
                $cur_day    = date('N');
                if ($value->djad_day == $cur_day){
                    $ada    = '<i class="text-success fa fa-circle"></i> Dokter Ada';
                } else {
                    $ada    = '<i class="text-danger fa fa-circle"></i> Dokter Tidak Ada';
                    $quota  = '<span class="text-danger">Antrian tidak bisa diambil</span>';
                    $onclick = "show_info('Maaf Dokter tidak praktek');return false";
                    $disable  = 'disabled';
                }

                if ($value->jam == 0){
                    $quota  = '<span class="text-danger">Antrian tidak bisa diambil</span>';
                    $onclick = "show_info('Maaf Dokter belum praktek');return false";
                    $disable  = 'disabled';
                }
            }



            //}
            /*$cur_time = time(date('Y-m-d H:i:s'));
            $start_time = time(date('Y-m-d ').$value->djad_time_start);
            $end_time   = time(date('Y-m-d ').$value->djad_time_end);
            if ($cur_time > $start_time && $cur_time < $end_time){
                $quota  = '<span class="text-danger">Antrian tidak bisa diambil</span>';
            }
            echo $cur_time. ' = ' .$start_time.' = '.$end_time;*/
            ?>
            <div class="col-md-3 pl_<?php echo $value->dr_id;?>">
                <div class="btn btn-block btn-danger text-center <?php echo $disable;?>" data-id="<?php echo $value->dr_id;?>" onclick="<?php echo $onclick;?>">
                    <div class="dr-name"><?php echo $value->user_fullname;?></div>
                    <div class="dr-detail">
                        <div class="dr-ada"><?php echo $ada; ?></div>
                        <div class="dr-jam"><?php echo $jam_praktek; ?></div>
                        <div class="quota"><?php echo $quota; ?></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>


<div class="clearfix"></div>

<div class="col-md-12" style="margin-top: 100px"><a href="javascript:;" onclick="show_poli();return false" style="padding:20px;font-size:25px" class="btn btn-primary btn-block">KEMBALI</a></div>