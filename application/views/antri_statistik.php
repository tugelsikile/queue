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
            <h3 class="box-title repeat-flag">Statistik Antrian</h3>

            <div class="box-tools pull-right" >
                <div class="pull-right input-group-sm input-group" style="width: 150px">
                    <input id="table_search" class="form-control pull-right" placeholder="Search" type="text" onkeyup="load_data();">
                    <div class="input-group-btn">
                        <button type="submit" onclick="load_data()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="pull-right input-group input-group-sm" style="width: 100px;margin-right: 5px">
                    <select class="form-control loket_id" onchange="load_data();">
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
                <div class="pull-right input-group input-group-sm" style="width: 150px;margin-right: 5px">
                    <select class="form-control poli_id" onchange="load_data();">
                        <option value="">Pilih Poli</option>
                        <?php
                        if ($poli){
                            foreach ($poli as $value){
                                echo '<option value="'.$value->poli_id.'">'.$value->poli_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="pull-right input-group input-group-sm" style="width: 70px;margin-right: 5px">
                    <select class="form-control tahun" onchange="load_data();">
                        <option value="">Tahun</option>
                        <?php
                        $min = $year;
                        $max = date('Y');
                        if ($min == $max){
                            echo '<option value="'.$max.'">'.$max.'</option>';
                        } else {
                            for ($i = $min; $i <= $max; $i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="pull-right input-group input-group-sm" style="width: 100px;margin-right: 5px">
                    <select class="form-control bulan" onchange="load_data();">
                        <option value="">Bulan</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">Nopember</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="pull-right input-group input-group-sm" style="width: 70px;margin-right: 5px">
                    <select class="form-control tgl" onchange="load_data();">
                        <option value="">Tgl</option>
                        <?php
                        for($i = 1; $i <= 31; $i++){
                            echo '<option value="'.str_pad($i,2,"0",STR_PAD_LEFT).'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>
        </div>
        <div class="box-body">
            <input type="hidden" class="order" value="ASC">
            <input type="hidden" class="order_by" value="poli_id">
            <table class="table table-bordered table-hover table-data">
                <thead>
                <tr>
                    <th width="100px">Nomor Antri</th>
                    <th width="150px">Loket</th>
                    <th width="*">Poli</th>
                    <th width="200px">Tanggal</th>
                    <th width="200px">Waktu Tunggu</th>
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
    function load_data(page=false,order_by=false,order=false) {
        var keyword     = $('#table_search').val();
        var loket_id    = $('.loket_id').val();
        var poli_id     = $('.poli_id').val();
        var tgl         = $('.tgl').val();
        var bulan       = $('.bulan').val();
        var tahun       = $('.tahun').val();
        $.ajax({
            url     : '<?= site_url()?>/home/data_statistik',
            type    : 'POST',
            dataType: 'JSON',
            data    : { keyword:keyword, loket_id:loket_id, poli_id:poli, tgl:tgl, bulan:bulan, tahun:tahun},
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


</script>