<?php
if (!$data){
    echo '<tr class="row_0"><td colspan="4" align="center">Tidak ada data pengguna</td></tr>';
} else {
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->user_id;?>">
            <td><?php echo $val->user_name;?></td>
            <td><?php echo $val->user_fullname;?></td>
            <td>
                <?php
                switch($val->user_level){
                    default :
                    case 1: $lvl = 'Kasir'; break;
                    case 50: $lvl = 'Dokter'; break;
                    case 99: $lvl = 'Administrator'; break;
                }
                echo $lvl;
                ?>
            </td>
            <td>
                <?php
                if (strlen(trim($val->user_last_login)) > 0){
                    echo date('d-m-Y H:i',strtotime($val->user_last_login));
                } else {
                    echo '-';
                }
                ?>
            </td>
            <td>
                <a title="Rubah data" href="<?php echo site_url('admin/edit_user/'.$val->user_id);?>" onclick="show_modal(this);return false" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?php echo site_url('admin/delete_user/'.$val->user_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}