<?php
if (!$data){
    echo '<tr class="row_0"><td colspan="4" align="center">Tidak ada data loket</td></tr>';
} else {
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->loket_id;?>">
            <td><?php echo $val->loket_kode;?></td>
            <td><?php echo $val->loket_name;?></td>
            <td>
                <?php
                if ($val->poli){
                    echo '<ul class="list-unstyled">';
                    foreach ($val->poli as $valP){
                        echo '<li><i class="fa fa-hospital-o"></i> '.$valP->poli_name.'</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </td>
            <td>
                <a title="Rubah data" href="<?php echo site_url('admin/edit_loket/'.$val->loket_id);?>" onclick="show_modal(this);return false" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo site_url('admin/delete_loket/'.$val->loket_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}