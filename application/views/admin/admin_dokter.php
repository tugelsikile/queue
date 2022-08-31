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
            <h3 class="box-title repeat-flag"><i class="fa fa-user-md"></i> Dokter</h3>

            <div class="box-tools pull-right" >
                <div class="pull-right input-group-sm input-group" style="width: 150px">
                    <input id="table_search" class="form-control pull-right" placeholder="Search" type="text" onkeyup="load_data();">
                    <div class="input-group-btn">
                        <button type="submit" onclick="load_data()" class="btn-cari btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="pull-right input-group input-group-sm" style="width: 150px;margin-right: 5px">
                    <select class="form-control spc_id" id="spc_id" onchange="load_data();">
                        <option value="">Pilih Spesialisasi</option>
                        <?php
                        if ($data){
                            foreach ($data as $value){
                                echo '<option value="'.$value->spc_id.'">'.$value->spc_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <a title="Tambah Dokter" href="<?php echo site_url('dokter/add_dokter');?>" onclick="show_modal(this);return false" class="btn btn-sm btn-primary mr-5" style="margin-right: 5px">
                    <i class="fa fa-plus"></i> Tambah Dokter
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-data">
                <thead>
                <tr>
                    <th width="*">Nama Dokter</th>
                    <th width="">Username</th>
                    <th width="200px">Spesialisasi</th>
                    <th width="50px">Quota</th>
                    <th width="">Jadwal</th>
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
    function load_data() {
        //$('.table-data tbody').html('<tr class="row_0"><td colspan="4" align="center"><i class="fa fa-spin fa-refresh"></i> Loading ... </td></tr>');
        $('.btn-cari').html('<i class="fa fa-spin fa-refresh"></i>');
        var keyword     = $('#table_search').val();
        var spc_id      = $('.spc_id').val();
        $.ajax({
            //url     : base_url + 'dokter/admin_dokter_data',
            url     : '<?= site_url() ?>/dokter/admin_dokter_data',
            type    : 'POST',
            dataType: 'JSON',
            data    : { keyword:keyword, spc_id:spc_id },
            success : function (dt) {
                if (dt.t == 0){
                    $('.btn-cari').html('<i class="fa fa-search"></i>');
                    $('.table-data tbody').html('<tr class="row_0"><td colspan="4" align="center">'+dt.msg+'</td></tr>');
                } else {
                    $('.btn-cari').html('<i class="fa fa-search"></i>');
                    $('.table-data tbody').html(dt.html);
                }
            }
        })
    }
    load_data();
</script>