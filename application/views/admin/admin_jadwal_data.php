<?php
if ($data){
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->djad_id;?>">
            <td><?php echo $this->conv->hariIndo($val->djad_day);?></td>
            <td><?php echo date('H:i',strtotime($val->djad_time_start));?></td>
            <td><?php echo date('H:i',strtotime($val->djad_time_end));?></td>
            <td>
                <a title="Rubah data" class="btn btn-sm btn-primary" href="<?php echo site_url('dokter/edit_jadwal/'.$val->djad_id);?>" onclick="show_modal(this);return false"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo site_url('dokter/delete_jadwal/'.$val->djad_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}