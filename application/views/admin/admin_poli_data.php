<?php
if (!$data){
    echo '<tr class="row_0"><td colspan="4" align="center">Tidak ada data poli</td></tr>';
} else {
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->poli_id;?>">
            <td><?php echo $val->poli_kode;?></td>
            <td><?php echo $val->poli_name;?></td>
            <td><?php echo $val->loket_name;?></td>
            <td>
                <a title="Rubah data" href="<?php echo base_url('admin/edit_poli/'.$val->poli_id);?>" onclick="show_modal(this);return false" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo base_url('admin/delete_poli/'.$val->poli_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}