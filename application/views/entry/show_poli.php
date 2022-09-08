
<?php
if (isset($polies)){
    if ($polies){
        foreach ($polies as $value){
            ?>
            <div class="col-md-6 pl_<?php echo $value->poli_id;?>">
                <button data-poli="<?php echo $value->poli_id;?>"
                        class="btn btn-block btn-default"
                        onclick="insert_queue_loket(this);return false">
                    <img width="32" height="32" src="<?php echo base_url('assets/img/poli/'.$value->poli_logo);?>">
                    <strong><?php echo $value->poli_name;?></strong>
                </button>
            </div>
            <?php
        }
    }
}
?>

<div class="clearfix"></div>
