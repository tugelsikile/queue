
<?php
if (isset($poli)){
    if ($poli){
        foreach ($poli as $value){
            ?>
            <div class="col-md-3 pl_<?php echo $value->poli_id;?>">
                <button poli="<?php echo $value->poli_id;?>" class="btn btn-block btn-default" onclick="show_dokter(this);return false">
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
