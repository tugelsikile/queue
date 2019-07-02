<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>APLIKASI ANTRIAN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css');?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin_lte/css/AdminLTE.min.css');?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin_lte/css/skins/skin-blue.min.css');?>">
    <!--Custom CSS->
    <link rel="stylesheet" href="<?php echo base_url('assets/custom.css');?>">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
    <!-- Dropzone.js -->
    <link rel="stylesheet" href="<?php echo base_url('assets/dropzone.css');?>">
    <!-- jQuery 3 -->
    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.3.1.min.js');?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <!--<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>-->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/admin_lte/js/adminlte.min.js');?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url('assets/admin_lte/js/demo.js');?>"></script>
    <!--<script src="http://code.responsivevoice.org/responsivevoice.js"></script>-->
    <script>
        var base_url    = '<?php echo base_url();?>';
        var site_url    = '<?php echo site_url();?>';
        //responsiveVoice.setDefaultVoice("Indonesian Female");
        function load_page(ob) {
            var url     = $(ob).attr('uri');
            $('.content-wrapper').load(url);
            $('.sidebar-menu .active').removeClass('active');
            $(ob).parents('li').addClass('active');
        }
        //responsiveVoice.speak("selamat pagi dan siang");
        function show_modal(ob) {
            var url = $(ob).attr('href');
            var title = $(ob).attr('title');
            if (!title || title.length == 0){
                title = "Informasi";
            }
            $('#modal1 .modal-title').html(title);
            $('#modal1 .modal-footer').html('');
            $('#modal1 .modal-body').html('<i class="fa fa-spin fa-refresh"></i> Loading ...').load(url);
            $('#modal1').modal('show');
        }
        function show_info(msg) {
            $('#modal2 .modal-body').html(msg);
            $('#modal2').modal('show');
        }
        function konfirmasi(ob) {
            var url = $(ob).attr('href');
            $('#modalConfirm .modal-body').html('<i class="fa fa-spin fa-refresh"></i> Loading ...').load(url);
            $('#modalConfirm').modal('show');
        }
    </script>
    <!-- Google Font -->
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">

<div id="modal1" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('#new_form).submit();" class="btn-submit btn btn-primary">Simpan</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalConfirm" class="modal fade" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modal2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Informasi</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="wrapper">


    <?php
    $this->load->view('header');
    $this->load->view('sidebar');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php
        if (!isset($body)){
            $this->load->view('home');
        } else {
            $this->load->view($body);
        }
        ?>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2014-<?php echo date('Y');?> <a target="_blank" href="https://smkmuhkandanghaur.sch.id">SMK Muhammadiyah Kandanghaur</a>.</strong> All rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->



</body>
</html>
