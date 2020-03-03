<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>APLIKASI ANTRIAN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom.css');?>">

    <link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.3.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>



    <script>
        var base_url    = '<?php echo base_url();?>';
        var site_url    = '<?php echo site_url();?>';
        function show_info(msg) {
            $('#modalConfirm .modal-body').html(msg)
            $('#modalConfirm').modal('show');
        }
    </script>
    <!-- Google Font -->
    <style>
        body,html{
            background: url('<?=base_url('assets/img/web-bg.png');?>') no-repeat;
            background-size:cover;
        }
        .tombol-wrapper{
            padding:10px;
        }
        .tombol-pilih{
            border:none;
            background:#CCC; margin-bottom:10px; padding:10px;
            border-radius:3px;
        }
        .btn-success,.btn-success:hover,.btn-success:active{
            background:#66ba00
        }
        .ireng2{
            background:rgba(0,0,0,.5); position: fixed; top:0;bottom:0;left:0;right:0;
            display: none; z-index: 9999;
        }
        .kotaknya{
            background: #FFF;width:400px;height:200px; padding: 10px; margin:100px auto;
            border-radius: 3px ;
        }
    </style>
</head>
<body>
    
    <div class="ireng2">
        <div class="kotaknya">
            LOADING ...
        </div>
    </div>
        
    <div class="col-md-4" style="margin-top:250px">
        <img src="<?=base_url('assets/img/logo-rsu.png');?>" width="100%">
    </div>
    <div class="col-md-8" style="margin-top:50px">
        <h2>Silahkan pilih tujuan anda!</h2>
        <div class="tombol-wrapper">

            <?php
            if ($loket){
                foreach ($loket as $key => $value) {
                    ?>
                    <div class="tombol-pilih">
                        <div class="col-md-2">
                            gambar
                        </div>
                        <div class="col-md-6">
                            <strong><?=$value->poli_name;?></strong><br>
                            <em><small>LOrem ipsum dolor sit amet</small></em>
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:;" data-id="<?=$value->poli_id;?>" onclick="select_poli(this);return false" class="btn btn-block btn-lg btn-success">
                                <i class="fa fa-forward"></i> Ambil Antrian
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php 
                }
            }
            ?>

        </div>
    </div>
        
    <script type="text/javascript">
        function show_loading(){
            $('.ireng2').show();
        }
        function select_poli(ob) {
            var poli_id = $(ob).attr('data-id');
            if (!poli_id){
                alert('Poli tidak valid !');
            } else {
                show_loading();
                $.ajax({
                    url     : base_url + 'entry/insert_antri',
                    type    : 'POST',
                    dataType: 'JSON',
                    data    : { poli_id : poli_id },
                    error   : function(e){
                        $('.kotaknya').html(e.status+' '+e.statusText);
                    },
                    success : function(dt){
                        if (dt.t == 0){
                            $('.ireng2').hide();
                            alert(dt.msg);
                        } else {
                            $('.ireng2').hide();
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
