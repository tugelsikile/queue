<?php
if ($data){
    $i = 1;
    foreach ($data as $val){
        $cl = 'btn-default';
        $mic = 'fa-microphone-slash';
        if ($val->que_call == 0){
            $cl = 'btn-primary';
            $mic = 'fa-microphone';
        }
        ?>
        <tr class="row_<?php echo $val->que_id;?>">
            <td align="center"><?php echo $i; ?></td>
            <td><?php echo $val->que_kode.''.$val->que_kode2;?></td>
            <td><?php echo $val->poli_name;?></td>
            <td>
                <?php
                echo $this->conv->hariIndo(date('N',strtotime($val->que_date))).', '.$this->conv->tglIndo(date('Y-m-d',strtotime($val->que_date))).' @'.date('H:i',strtotime($val->que_date));
                ?>
            </td>
            <td>
                <a title="Panggil antrian" href="javascript:;" que="<?php echo $val->que_id;?>" onclick="panggil_antri(this);return false" class="btn-sm btn <?php echo $cl;?>"><i class="fa <?php echo $mic;?>"></i> Panggil</a>
                <?php
                if ($val->call_status == 99){
                    echo '<a title="Terpanggil pada speaker" href="javascript:;" class="btn btn-success disabled btn-sm"><i class="fa fa-volume-up"></i></a>';
                }
                ?>
            </td>
        </tr>
        <?php
        $i++;
    }
}