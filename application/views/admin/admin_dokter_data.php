<?php
if (!$data){
    echo '<tr class="row_0"><td align="center">Tidak ada data dokter</td></tr>';
} else {
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->dr_id;?>">
            <td><?php echo $val->user_fullname;?></td>
            <td><?php echo $val->user_name;?></td>
            <td><?php echo $val->spc_name;?></td>
            <td><?php echo $val->dr_quota;?></td>
            <td>
                <a title="Lihat jadwal dokter" class="btn btn-sm btn-primary" href="javascript:;" uri="<?php echo base_url('dokter/admin_jadwal/'.$val->dr_id);?>" onclick="load_page(this);return false"><i class="fa fa-calendar"></i> Lihat Jadwal</a>
            </td>
            <td>
                <a title="Rubah data" class="btn btn-sm btn-primary" href="<?php echo base_url('dokter/edit_dokter/'.$val->dr_id);?>" onclick="show_modal(this);return false"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo base_url('dokter/delete_dokter/'.$val->dr_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}