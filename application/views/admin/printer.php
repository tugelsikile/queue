<section class="content-header">
</section>

<!-- Main content -->
<section class="content">
    <form method="post" id="form-printer">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title repeat-flag"><i class="fa fa-road"></i> Printer</h3>
            </div>
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Shared Printer</label>
                        <div class="col-md-4">
                            <input value="<?= $data == null ? '' : $data->name ?>" name="nama_printer" id="nama_printer" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">IP Shared Printer</label>
                        <div class="col-md-4">
                            <input value="<?= $data == null ? '' : $data->ip ?>" id="ip_printer" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary"><i class="fa fa-save"></i> SIMPAN </button>
            </div>
        </div>
    </form>

</section>
<!-- /.content -->
<script>
    $('#form-printer').submit(function () {
        $.ajax({
            url : '<?= site_url()?>/admin/printer_save',
            type : 'post', dataType : 'json',
            data : { nama_printer : $('#nama_printer').val(), ip_printer : $('#ip_printer').val() },
            error : function (e) {
                alert(e.responseJSON.message);
            },
            success : function (e) {
                alert(e.message);
            }
        });
        return false;
    });
    function load_data() {
        //$('.table-data tbody').html('<tr class="row_0"><td colspan="4" align="center"><i class="fa fa-spin fa-refresh"></i> Loading ... </td></tr>');
        $('.btn-cari').html('<i class="fa fa-spin fa-refresh"></i>');
        var keyword     = $('#table_search').val();
        $.ajax({
            url     : '<?= site_url()?>/admin/admin_runing_text_data',
            type    : 'POST',
            dataType: 'JSON',
            data    : { keyword:keyword },
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