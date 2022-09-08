<section class="content-header"></section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title repeat-flag">
                <i class="fa fa-calendar"></i>
                Jadwal Poli :
                <a href="javascript:;" uri="<?= site_url('admin/admin_poli') ?>" onclick="load_page(this);return false">
                    <?= $data->poli_name ?>
                </a>
            </h3>

            <div class="box-tools pull-right" >
                <div class="pull-right input-group-sm input-group" style="width: 150px">
                    <input id="table_search" class="form-control pull-right" placeholder="Search" type="text" onkeyup="load_data();">
                    <div class="input-group-btn">
                        <button type="submit" onclick="load_data()" class="btn-cari btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <a title="Tambah Jadwal" href="<?php echo site_url('admin/schedule_poli_add/'.$data->poli_id);?>" onclick="show_modal(this);return false" class="btn btn-sm btn-primary mr-5" style="margin-right: 5px">
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
                    <th width="200px">Quota</th>
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
        var dr_id       = '<?php echo $data->poli_id;?>';
        $.ajax({
            //url     : base_url + 'dokter/admin_jadwal_data',
            url     : '<?= site_url()?>/admin/schedule_poli_data',
            type    : 'POST',
            dataType: 'JSON',
            data    : { keyword:keyword, poli_id:dr_id },
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