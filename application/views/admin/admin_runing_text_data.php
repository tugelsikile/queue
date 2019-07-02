<?php
if ($data){
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->rt_id;?>">
            <td><?php echo $val->rt_content;?></td>
            <td>
                <a title="Rubah data" class="btn btn-sm btn-primary" href="<?php echo base_url('admin/edit_runing_text/'.$val->rt_id);?>" onclick="show_modal(this);return false"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo base_url('admin/delete_runing_text/'.$val->rt_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}