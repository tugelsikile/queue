<div class="col-md-7" style="margin-left: -10px;margin-right: 20px">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-list"></i> Antrian Sekarang</div>
        <div class="panel-body text-center">
            <strong data-id="" style="font-size: 100px; line-height: 200px" class="cur-antri">&nbsp;</strong>
        </div>
        <div class="panel-footer">
            <a style="margin-right: 20px;" href="javascript:;" onclick="ulangi_panggil();return false" class="disabled btn-panggil pull-left btn btn-success btn-md">
                <i class="fa fa-microphone"></i> Ulangi Panggilan
            </a>
            <a id="sendPoly" style="margin-right: 20px;" href="javascript:;" class="disabled btn-panggil pull-left btn btn-success btn-md">
                <i class="fa fa-paper-plane"></i> Kirim Ke Poly
            </a>
            <a href="javascript:;" onclick="next_antri();return false" class="disabled btn-next pull-left btn btn-primary btn-md">
                Panggil Selanjutnya <i class="fa fa-arrow-circle-right"></i>
            </a>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="data-antri col-md-5" style="margin-right: -10px;margin-left: -10px">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-list"></i> Daftar Antrian
            <a title="Refresh Table" href="javascript:;" onclick="load_antrian();return false" class="pull-right btn btn-xs btn-default"><i class="fa fa-refresh"></i> </a>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-antrian">
                <thead>
                    <tr>
                        <th width="100px">Kode Antri</th>
                        <th>Pukul</th>
                        <th>Status Panggil</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <span class="pull-left">Terpanggil : <strong class="terpanggil"></strong></span>
            <span class="pull-right">Menunggu : <strong class="tunggu"></strong></span>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<input type="hidden" value="" id="que_id">
<script>
    load_antrian();

    function load_antrian() {
        $('.loading').show();
        var loket_id = '<?php echo $loket->loket_id; ?>'
        $.ajax({
            url: '<?= site_url() ?>/home/load_antrian',
            type: 'POST',
            dataType: 'JSON',
            data: {
                loket_id: loket_id
            },
            success: function(dt) {
                if (dt.t == 0) {
                    $('.loading').hide();
                    $('.table-antrian tbody').html('<tr><td align="center">' + dt.msg + '</td></tr>');
                } else {
                    $('.loading').hide();
                    $('.table-antrian tbody').html(dt.html);
                }
            }
        });
    }

    function next_antri() {
        var next_antri = $('.data-antri').find('.label-primary').eq($('.data-antri').find('.label-primary').length - 1).parents('tr').next('tr').attr('class');
        if (!next_antri) {
            next_antri = $('.table-antrian tbody tr').eq(0).attr('class');
        }
        next_antri = next_antri.replace("row_", "");
        //console.log(next_antri);
        var ob = {
            'data-id': next_antri
        };
        call_antri(ob);

        var cur_antri_id = $('.cur-antri').attr('data-id');
        var next_antri_id = $('.table-antrian tbody').find('.row_' + cur_antri_id).next('tr').length;
        if (next_antri_id == 0) {
            $('.btn-next').addClass('disabled');
        }
        var wait = parseInt($('.tunggu').text());
        var call = parseInt($('.terpanggil').text());
        $('.tunggu').text(wait - 1);
        $('.terpanggil').text(call + 1);
    }

    function ulangi_panggil() {
        var que_id = $('.cur-antri').attr('data-id');
        var ob = {
            'data-id': que_id
        };
        call_antri(ob);
    }

    function call_antri(ob) {
        var que_id = $(ob).attr('data-id');
        if (que_id) {
            $('.loading').show();
            $.ajax({
                url: '<?= site_url() ?>/home/call_antri',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    que_id: que_id
                },
                success: function(dt) {
                    if (dt.t == 0) {
                        $('.loading').hide();
                        show_info(dt.msg);
                    } else {
                        $('.loading').hide();
                        $('.cur-antri').html(dt.kode);
                        $('.cur-antri').attr({
                            'data-id': que_id
                        });
                        //update table
                        $('.call_' + que_id).html('<a title="Ulangi panggilan" href="javascript:;" class="btn btn-xs btn-default" onclick="call_antri(this);return false" data-id="' + que_id + '">' +
                            '                        <i class="fa fa-microphone"></i>' +
                            '                    </a>' +
                            '                    <span class="label label-primary">Terpanggil</span>');
                        // opening(dt.kode, 0);
                        $('#que_id').val(que_id);

                        load_antrian();
                    }
                }
            })
        }
    }

    $('#sendPoly').on('click', function() {
        let que_kode = $('.cur-antri').html();
        let queue_id = $('#que_id').val();
        $.ajax({
            url: '<?= site_url() ?>/home/sendToPoly',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'que_id': queue_id,
            },
            error : function(e){
                console.log(e.responseText);
                alert(e.responseText);
            },
            success: function(res) {
                alert(res);
                console.log(res);
            }
        });
    });
</script>
<style>
    table {
        width: 100%;
    }

    thead,
    tbody,
    tr,
    td,
    th {
        display: block;
    }

    tr:after {
        content: ' ';
        display: block;
        visibility: hidden;
        clear: both;
    }

    thead th {
        height: 30px;

        /*text-align: left;*/
    }

    tbody {
        height: 170px;
        overflow-y: auto;
    }

    thead {
        /* fallback */
    }


    tbody td,
    thead th {
        width: 33%;
        float: left;
    }
</style>