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
            <h3 class="box-title repeat-flag">Daftar Antrian</h3>

            <div class="box-tools pull-right" >
                <div class="pull-right input-group-sm input-group" style="width: 150px">
                    <input id="table_search" class="form-control pull-right" placeholder="Search" type="text" onkeyup="load_data();">
                    <div class="input-group-btn">
                        <button type="submit" onclick="load_data()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="pull-right input-group input-group-sm" style="width: 150px;margin-right: 5px">
                    <select class="form-control antri-loket-id" id="loket_id" onchange="load_data();">
                        <option value="">Pilih Loket</option>
                        <?php
                        if ($loket){
                            foreach ($loket as $value){
                                echo '<option value="'.$value->loket_id.'">'.$value->loket_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-data">
                <thead>
                <tr>
                    <th width="50px">No</th>
                    <th width="150px">Nomor Antrian</th>
                    <th width="*">Poli</th>
                    <th width="200px">Tanggal/Jam</th>
                    <th width="200px"></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

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
    function panggil_antri(ob) {
        var que_id  = $(ob).attr('que');
        if (que_id.length > 0){
            $.ajax({
                url     : base_url + 'home/insert_call',
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
    function load_data() {
        var keyword     = $('#table_search').val();
        var loket_id    = $('.antri-loket-id').val();
        $.ajax({
            url     : base_url + 'home/data_antri',
            type    : 'POST',
            dataType: 'JSON',
            data    : { keyword:keyword, loket_id:loket_id},
            success : function (dt) {
                if (dt.t == 0){
                    $('.table-data tbody').html('<tr class="row_0"><td colspan="5" align="center">'+dt.msg+'</td></tr>');
                } else {
                    $('.table-data tbody').html(dt.html);
                }
            }
        })
    }
    load_data();
    if ($('.repeat-flag').text() == 'Daftar Antrian'){
        var reload_page = setInterval(function () {
            if ($('.repeat-flag').text() == 'Daftar Antrian'){
                load_data();
            } else {
                clearInterval(reload_page);
            }
        },10000)
    }

</script>