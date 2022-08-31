<?php
if (!$data){
    echo '<tr class="row_0"><td align="center">Tidak ada data spesialisasi</td></tr>';
} else {
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->spc_id;?>">
            <td><?php echo $val->spc_name;?></td>
            <td><?php echo $val->jml;?></td>
            <td>
                <a title="Rubah data" class="btn btn-sm btn-primary" href="<?php echo site_url('dokter/edit_spesialis/'.$val->spc_id);?>" onclick="show_modal(this);return false"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo site_url('dokter/delete_spesialis/'.$val->spc_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}