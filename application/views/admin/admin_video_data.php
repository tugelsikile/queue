<?php
if ($data){
    foreach ($data as $val){
        ?>
        <tr class="row_<?php echo $val->media_id;?>">
            <td>
                <video width="200" controls>
                    <source src="<?php echo base_url('assets/video/'.$val->media_url);?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </td>
            <td><?php echo $val->media_name;?></td>
            <td>
                <a title="Hapus data" href="<?php echo site_url('admin/delete_video/'.$val->media_id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}