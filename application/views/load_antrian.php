<?php
if ($data){
    $wait = 0;
    foreach ($data as $val){
        if ($val->is_called == 0){
            $call = '<span class="label label-default">Menunggu</span>';
            $wait++;
        } else {
            $call = '<a title="Ulangi panggilan" href="javascript:;" class="btn btn-xs btn-default" onclick="call_antri(this);return false" data-id="'.$val->que_id.'">
                        <i class="fa fa-microphone"></i>
                    </a>
                    <span class="label label-primary">Terpanggil</span> ';
        }
        ?>
        <tr class="row_<?php echo $val->que_id;?>">
            <td align="center"><?php echo $val->que_kode.$val->que_kode2;?></td>
            <td align="center"><?php echo date('H:i',strtotime($val->que_date));?></td>
            <td align="center" class="call_<?php echo $val->que_id;?>"><?php echo $call;?></td>
        </tr>
        <?php
    }
}
?>
<script>
    $('.terpanggil').html($('.data-antri').find('.label-primary').length);
    $('.tunggu').html('<?php echo $wait;?>');

    //rewrite antrian sekarang
    var cur_antri = $('.data-antri').find('.label-primary').eq($('.data-antri').find('.label-primary').length-1).parents('tr').find('td').eq(0).text();
    var que_id  = $('.data-antri').find('.label-primary').eq($('.data-antri').find('.label-primary').length-1).parents('tr').attr('class');
    if (cur_antri){
        $('.cur-antri').html(cur_antri);
    }
    if (que_id){
        que_id = que_id.replace("row_","");
        $('.cur-antri').attr({'data-id':que_id});
    }
    //console.log(cur_antri)
    <?php
    if (count($data) > 0){
        echo "$('.btn-next,.btn-panggil').removeClass('disabled');";
    }
    if ($wait == 0){
        echo "$('.btn-next').addClass('disabled');";
    }
    ?>


</script>
