<!-- Content Header (Page header) -->
<section class="content-header">
<!--    <h1>-->
<!--        Dashboard-->
<!--        <small>Control panel</small>-->
<!--    </h1>-->
<!--    <ol class="breadcrumb">-->
<!--        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
<!--        <li class="active">Dashboard</li>-->
<!--    </ol>-->
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title repeat-flag">
                Antrian Pendaftaran
                <span class="nama-loket"></span>
            </h3>

            <div class="box-tools pull-right" >
                <i class="fa fa-spin fa-refresh loading"></i>
                <a title="Kembali" style="display: none" href="javascript:;" onclick="$('.nama-loket').html('');$('.loket-selection').show();$('.dashboard-content').html('');$('.btn-back').hide();return false" class="btn-back btn btn-sm btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
            </div>
        </div>
        <div class="box-body">
            <div class="loket-selection">
                <?php
                if (!$data){
                    echo '<strong>Tidak ada data Loket Pendaftaran</strong>';
                } else {
                    foreach ($data as $val){
                        ?>
                        <div class="col-md-3" style="margin-bottom: 20px">
                            <a class="btn btn-primary btn-block btn-lg" href="javascript:;" data-id="<?php echo $val->loket_id;?>" onclick="show_antrian(this);return false">
                                <?php echo $val->loket_name;?>
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            <div class="clearfix"></div>

            <div class="dashboard-content">

            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            Footer
        </div>
        <!-- /.box-footer-->
    </div>

</section>
<!-- /.content -->
<script>
    $('.loading').hide();
    function show_antrian(ob) {
        var loket_id = $(ob).attr('data-id');
        $('.loading').show();
        $.ajax({
            url     : '<?= site_url()?>/home/show_antrian',
            type    : 'POST',
            dataType: 'JSON',
            data    : { loket_id:loket_id },
            success : function (dt) {
                if (dt.t == 0){
                    $('.loading').hide();
                    show_info(dt.msg);
                } else {
                    $('.nama-loket').html(': '+dt.loket_name);
                    $('.loading').hide();
                    $('.loket-selection').hide();
                    $('.btn-back').show();
                    $('.dashboard-content').html(dt.html);
                }
            }
        })
    }
    function panggil_antri(ob) {
        var que_id  = $(ob).attr('que');
        if (que_id.length > 0){
            $.ajax({
                url     : '<?= site_url()?>/home/insert_call',
                type    : 'POST',
                dataType: 'JSON',
                data    : { que_id:que_id},
                success : function (dt) {
                    if (dt.t == 1){
                        //$(ob).addClass('disabled').removeClass('btn-primary');
                        $(ob).removeClass('btn-primary').addClass('btn-default');
                        $(ob).find('.fa-microphone').addClass('fa-microphone-slash').removeClass('fa-microphone');
                    }
                }
            })
        }
    }

</script>