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
        $(document).ready(function() {
// Create two variable with the names of the months and days in an array
            var monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember" ];
            var dayNames= ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"]

// Create a newDate() object
            var newDate = new Date();
// Extract the current date from Date object
            newDate.setDate(newDate.getDate());
// Output the day, date, month and year
            $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

            setInterval( function() {
                // Create a newDate() object and extract the seconds of the current time on the visitor's
                var seconds = new Date().getSeconds();
                // Add a leading zero to seconds value
                $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
            },1000);

            setInterval( function() {
                // Create a newDate() object and extract the minutes of the current time on the visitor's
                var minutes = new Date().getMinutes();
                // Add a leading zero to the minutes value
                $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
            },1000);

            setInterval( function() {
                // Create a newDate() object and extract the hours of the current time on the visitor's
                var hours = new Date().getHours();
                // Add a leading zero to the hours value
                $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
            }, 1000);
        });
        function show_info(msg) {
            $('#modalConfirm .modal-body').html(msg)
            $('#modalConfirm').modal('show');
        }
    </script>
    <!-- Google Font -->
    <style>
        body,html{
            background: #F0E6FA;
        }
        .header{
            padding: 10px;
        }
        /* jam */
        @import url('https://fonts.googleapis.com/css?family=Do+Hyeon');
        .clock {
            font-family: 'Do Hyeon', sans-serif;
            width: 300px;
            margin: 0 auto;
            padding: 0px;
            text-align:center;
            /*background: #FFF;*/
            color: #000;
        }

        #Date {
            text-align: center;
        }

        .clock ul {
            width: 300px;
            margin: 0 auto;
            padding: 0px;
            padding-right: 20px;
            list-style: none;
            text-align: center;
        }

        .clock ul li {
            display: inline;
            font-size: 3em;
            text-align: right;
            font-family: 'Do Hyeon', sans-serif;
        }

        #point {
            position: relative;
            -moz-animation: mymove 1s ease infinite;
            -webkit-animation: mymove 1s ease infinite;
            padding-left: 5px;
            padding-right: 5px;
        }

        /* Simple Animation */
        @-webkit-keyframes mymove {
            0% {opacity: 1.0;

            }

            50% {
                opacity: 0;

            }

            100% {
                opacity: 1.0;

            }
        }

        @-moz-keyframes mymove {
            0% {
                opacity: 1.0;

            }

            50% {
                opacity: 0;

            }

            100% {
                opacity: 1.0;

            };
        }

        .content{
            padding: 10px;
        }
        .nomorAntri{
            font-size: 100px;
            text-align: center;
            font-family: 'Do Hyeon', sans-serif;
            min-height: 310px;
            vertical-align: middle;
            line-height: 310px;
            color: #CC0000;
        }
        .informasi marquee{
            font-family: 'Do Hyeon', sans-serif;
            font-size: 24px;
        }
        .content .btn{
            margin-bottom: 20px;
            /*height: 130px;*/
        }
        .content button{
            height: 130px;
            font-size: 25px;
        }
        .masking{
            background: rgba(0,0,0,.5);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            color: #FFF;
            font-size: 60px;
            text-align: center;
            vertical-align: middle;
            line-height: 90px;
        }
        .btn{
            border: solid 2px #000 !important;
        }
        .heading-poli{
            border: solid 2px #000;
            margin: 15px;
            padding: 10px;
            border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius:5px ;
            font-size: 25px; text-align: center; font-weight: bold; background: #FFF;
        }
    </style>
</head>
<body>
<div id="modalConfirm" class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Informasi</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="masking"><i class="fa fa-spin fa-refresh"></i> </div>
<div class="header">
    <img src="<?php echo base_url('assets/img/logo.png');?>" width="250px">
    <div class="jam pull-right">
        <div class="clock">
            <div id="Date"></div>
            <ul class="fontsforweb_fontid_1091">
                <li id="hours"></li>
                <li id="point">:</li>
                <li id="min"></li>
                <li id="point">:</li>
                <li id="sec"></li>
            </ul>
        </div>
    </div>
</div>
<div class="iframe" style="display: none">
    <iframe name="printing" id="printing" src="" width="100%"></iframe>
</div>
<div class="content">





</div>
<script>
    var window_height = $(window).height();
    $('.masking').css({'line-height':window_height+'px'}).hide();

    function show_poli() {
        $('.masking').show();
        $('.content').load(base_url+'entry/show_poli',function (e) {
            $('.masking').hide();
        });
    }
    show_poli();
    function show_dokter(ob) {
        var poli_id = $(ob).attr('poli');
        $('.masking').show();
        $.ajax({
            url     : base_url + 'entry/show_dokter',
            data    : { poli_id:poli_id },
            type    : 'POST',
            dataType: 'JSON',
            success : function (dt) {
                if(dt.t == 0){
                    $('.masking').hide();
                    $('.content').html(dt.msg);
                } else {
                    $('.masking').hide();
                    $('.content').html(dt.html);
                }
            }
        })
    }
    function insert_queue(ob) {
        var dr_id   = $(ob).attr('data-id');
        $('.masking').show();
        $.ajax({
            url     : base_url + 'cetak/insert_queue',
            type    : 'POST',
            dataType: 'JSON',
            data    : { dr_id:dr_id },
            success : function (dt) {
                if (dt.t == 0){
                    $('.masking').hide();
                    alert(dt.msg);
                } else {
                    $('.masking').hide();
                    show_poli();
                }
            }
        });
    }
    function pilih_poli(ob) {
        var poli_id = $(ob).attr('poli');
        var loket_id= $(ob).attr('loket');
        if (poli_id.length > 0 && loket_id > 0){
            $('.masking').show();
            $.ajax({
                url     : '<?php echo base_url('home/insert_queue');?>',
                type    : 'POST',
                dataType: 'JSON',
                data    : { poli_id:poli_id, loket_id:loket_id},
                success : function (dt) {
                    if (dt.t == 1){
                        if (dt.nxt == 1){
                            //$('.pl_'+poli_id).hide();
                            $('.pl_'+poli_id).find('button').addClass('btn-default').removeClass('btn-danger').attr({'onclick':''});
                            $('.pl_'+poli_id+' button strong').after('<br><small>(Tiket Habis)</small>');
                        }
                        $('.iframe').load('<?php echo base_url('cetak/cetak_struk/');?>'+dt.id);

                        //$('#printing').attr({'src':'<?php //echo base_url('home/cetak_antrian/');?>'+dt.id});
                        //window.frames["printing"].focus();
                        //window.frames["printing"].print();
                    }
                    $('.masking').hide();
                }
            })
        }
    }
</script>
</body>
</html>
