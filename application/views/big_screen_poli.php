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

    <link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url('assets/jquery-3.3.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/gistfile1.js');?>"></script>



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
    </script>
    <!-- Google Font -->
    <style>
        body,html{
            background: rgba(240,230,250,.9);
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
        .background{
            background: url("<?php echo base_url('assets/img/big_screen.jpg');?>") no-repeat center center;
            background-size: cover;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
<div class="background"></div>
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
<div class="content">
    <div class="col-md-5" style="padding-left: 0">
        <div class="panel panel-danger antriWrap" style="border-width: 10px">
            <div class="panel-heading" style="text-align: center">
                <strong style="font-size: 30px" class="loket_name">&nbsp;</strong>
            </div>
            <div class="panel-body">
                <div class="nomorAntri">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=gctISVcE"></script>
    <script>

        function read_entry(){
            responsiveVoice.setDefaultVoice("Indonesian Female");
            $.ajax({
                url     : '<?php echo site_url('big_screen/read_entry_poli');?>',
                type    : 'POST',
                dataType: 'JSON',
                success : function (dt) {
                    if (dt.t == 1){
                        $('.loket_name').html(dt.loket_name);
                        $('.nomorAntri').html(dt.que_kode);
                        responsiveVoice.speak(dt.speaker);
                    }
                }
            });
        }
        $(document).ready(function (e) {
            responsiveVoice.setDefaultVoice("Indonesian Female");
            setInterval(function () {
                read_entry();
            },15000)
        });
        read_entry();
    </script>
    <div class="col-md-7" style="padding-right: 0">
        <div class="panel panel-danger">
            <div class="panel-body videoWrapper">

                <div id="jp_container_N" class="jp-video jp-video-270p" role="application" aria-label="media player">
                    <div class="jp-type-playlist">
                        <div id="jquery_jplayer_N" class="jp-jplayer"></div>
                        <div class="jp-gui">
                            <div class="jp-video-play">
                                <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                            </div>
                            <div class="jp-interface" style="display: none">
                                <div class="jp-progress">
                                    <div class="jp-seek-bar">
                                        <div class="jp-play-bar"></div>
                                    </div>
                                </div>
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                <div class="jp-controls-holder" >
                                    <div class="jp-controls">
                                        <button class="jp-previous" role="button" tabindex="0">previous</button>
                                        <button class="jp-play" role="button" tabindex="0">play</button>
                                        <button class="jp-next" role="button" tabindex="0">next</button>
                                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                                    </div>
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                    </div>
                                    <div class="jp-toggles">
                                        <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                        <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                                        <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                    </div>
                                </div>
                                <div class="jp-details">
                                    <div class="jp-title" aria-label="title">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <div class="jp-playlist" style="display: none">
                            <ul>
                                The method Playlist.displayPlaylist() uses this unordered list -->
                                <li>&nbsp;</li>
                            </ul>
                        </div>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="panel panel-default informasi">
        <div class="panel-body">
            <marquee behavior="scroll" scrollamount="4" direction="left">
                    <?php
                    if ($marquee){
                        foreach ($marquee as $value){
                            echo '<span style="margin-right: 200px"><i class="fa fa-warning"></i> '.$value->rt_content.'</span>';
                        }
                    }
                    ?>
            </marquee>
        </div>
    </div>
    <link href="<?php echo base_url('assets/jPlayer-2.9.2/dist/skin/blue.monday/css/jplayer.blue.monday.min.css');?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url('assets/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/jPlayer-2.9.2/dist/add-on/jplayer.playlist.min.js');?>"></script>

    <script>
        var video_width     = $('.videoWrapper').innerWidth() - 30;
        var video_height    = $('.antriWrap').innerHeight() - 10;

        var myPlaylist = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_N",
            cssSelectorAncestor: "#jp_container_N"
        }, [
            <?php
            if ($media){
                $lastElement = end($media);
                foreach ($media as $k => $val){
                    ?>
                    {
                        m4v     : '<?php echo base_url('assets/video/'.$val->media_url);?>',
                        title   : '<?php echo $val->media_name;?>'
                    }
                    <?php
                    if ($val != $lastElement){
                        echo ',';
                    }
                }
            }
            ?>
        ], {
            playlistOptions: {
                enableRemoveControls: true,
                autoPlay            : true
            },
            swfPath             : "<?php echo base_url('assets/jPlayer-2.9.2/dist/jplayer');?>",
            supplied            : "ogv, m4v, oga, mp3",
            useStateClassSkin   : true,
            autoBlur            : false,
            smoothPlayBar       : true,
            keyEnabled          : true,
            audioFullScreen     : true,
            volume              : 0,
            repeat              : true,
            loop                : true,
            size                : {
                width           : video_width,
                height          : video_height
            }
        });



        $('#jp_container_N').css({'width':video_width,'height':video_height});



    </script>
</div>
</body>
</html>
