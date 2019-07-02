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
            <h3 class="box-title repeat-flag"><i class="fa fa-calendar"></i> Jadwal Dokter : <a href="javascript:;" uri="<?php echo base_url('dokter/admin_dokter');?>" onclick="load_page(this);return false"><?php echo $user->user_fullname;?></a></h3>

            <div class="box-tools pull-right" >
                <div class="pull-right input-group-sm input-group" style="width: 150px">
                    <input id="table_search" class="form-control pull-right" placeholder="Search" type="text" onkeyup="load_data();">
                    <div class="input-group-btn">
                        <button type="submit" onclick="load_data()" class="btn-cari btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <a title="Tambah Jadwal" href="<?php echo base_url('dokter/add_jadwal/'.$data->dr_id);?>" onclick="show_modal(this);return false" class="btn btn-sm btn-primary mr-5" style="margin-right: 5px">
                    <i class="fa fa-plus"></i> Tambah Jadwal
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover table-data">
                <thead>
                <tr>
                    <th width="*">Hari</th>
                    <th width="200px">Jam Mulai</th>
                    <th width="200px">Jam Selesai</th>
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
        var dr_id       = '<?php echo $data->dr_id;?>';
        $.ajax({
            url     : base_url + 'dokter/admin_jadwal_data',
            type    : 'POST',
            dataType: 'JSON',
            data    : { keyword:keyword, dr_id:dr_id },
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