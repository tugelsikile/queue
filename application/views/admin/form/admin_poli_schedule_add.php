<form id="new_form" class="form form-horizontal">
    <input type="hidden" name="poli" value="<?= $data->poli_id; ?>">
    <div class="poli_name form-group">
        <label for="poli_name" class="control-label col-md-3">Poli</label>
        <div class="col-md-9">
            <input class="form-control" value="<?= $data->poli_name ?>" disabled>
        </div>
    </div>
    <div class="form-group hari_name">
        <label for="hari_name" class="control-label col-md-3">Hari</label>
        <div class="col-md-9">
            <select name="hari" class="form-control" id="hari_name">
                <option value="7">Minggu</option>
                <option value="1">Senin</option>
                <option value="2">Selasa</option>
                <option value="3">Rabu</option>
                <option value="4">Kamis</option>
                <option value="5">Jum'at</option>
                <option value="6">Sabtu</option>
            </select>
        </div>
    </div>
    <div class="form-group jam_buka">
        <label for="jam_buka" class="control-label col-md-3">Jam Buka</label>
        <div class="col-md-4">
            <input class="form-control" value="07:00" name="jam_buka" id="jam_buka">
        </div>
    </div>
    <div class="form-group jam_tutup">
        <label for="jam_tutup" class="control-label col-md-3">Jam Tutup</label>
        <div class="col-md-4">
            <input class="form-control" value="12:00" name="jam_tutup" id="jam_tutup">
        </div>
    </div>
    <div class="form-group quota">
        <label class="col-md-3 control-label" for="quota">Quota</label>
        <div class="col-md-4">
            <input class="form-control" value="0" name="quota" id="quota">
            <small>0 untuk tak terbatas</small>
        </div>
    </div>
</form>

<script>
    $('#modal1 .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
        '<button type="button" onclick="$(\'#modal1 #new_form\').submit();" class="btn-submit btn btn-primary"><i class="fa fa-check"></i> Simpan</button>');
    $('#modal1 #new_form').submit(function (e) {
        $('#modal1 .btn-submit').html('<i class="fa fa-spin fa-refresh"></i> Simpan').addClass('disabled').prop({'disabled':true});
        $('#modal1 #new_form .has-error').removeClass('has-error');
        $.ajax({
            url     : '<?= site_url()?>/admin/schedule_poli_add',
            type    : 'POST',
            dataType: 'JSON',
            data    : $(this).serialize(),
            success : function (dt) {
                if (dt.t == 0){
                    show_info(dt.msg);
                    $('.'+dt.class).addClass('has-error');
                    $('#modal1 .btn-submit').html('<i class="fa fa-check"></i> Simpan').removeClass('disabled').prop({'disabled':false});
                } else {
                    $('#modal1').modal('hide');
                    $('#modal1 .btn-submit').html('<i class="fa fa-check"></i> Simpan').removeClass('disabled').prop({'disabled':false});
                    show_info(dt.msg);
                    load_data();
                }
            }
        });
        return false;
    })
</script>