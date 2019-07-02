<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>APLIKASI ANTRIAN</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css');?>">
    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.3.1.min.js');?>"></script>
    <style>
        body, html{
            background: #d9edf7;
        }
        .metro{
            border-radius: 0; -moz-border-radius: 0; -webkit-border-radius: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div style="width: 500px; margin: 150px auto">
        <form class="form form-horizontal" id="loginForm">
            <div class="panel panel-warning">
                <div class="panel-heading"><i class="fa fa-lock"></i> MASUK APLIKASI</div>
                <div class="panel-body">
                    <div class="form-group user_name">
                        <label for="user_name" class="control-label col-md-3">Username</label>
                        <div class="col-md-9">
                            <input type="text" name="user_name" id="user_name" class="form-control input-sm metro">
                        </div>
                    </div>
                    <div class="form-group user_password">
                        <label for="user_password" class="control-label col-md-3">Password</label>
                        <div class="col-md-9">
                            <input type="password" name="user_password" id="user_password" class="form-control input-sm metro">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <small class="text-danger status"></small>
                    <button class="pull-right metro btn btn-sm btn-primary"><i class="fa fa-lock"></i> LOGIN</button>
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
    </div>
    <div class="text-center">
        <a href="<?php echo base_url('big_screen/poli');?>">Antrian Pendaftaran</a> |
        <a href="<?php echo base_url('big_screen/poli');?>">Antrian Poli</a> |
        <a href="<?php echo base_url('entry');?>">Pengunjung</a>
    </div>
</div>

<script>
    $('#loginForm').submit(function () {
        $('#loginForm .status').html('');
        $('#loginForm .has-error').removeClass('has-error');
        $.ajax({
            url     : '<?php echo base_url('account/login_submit');?>',
            type    : 'POST',
            data    : $(this).serialize(),
            dataType: 'JSON',
            success : function (dt) {
                if (dt.t == 0){
                    $('.status').html(dt.msg);
                    $('#loginForm .'+dt.class).addClass('has-error');
                } else {
                    window.location.href = '<?php echo base_url('');?>'
                }
            }
        })
        return false;
    })
</script>
</body>
</html>