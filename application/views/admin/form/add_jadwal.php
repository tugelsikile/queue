<form id="new_form" class="form form-horizontal">
    <input type="hidden" name="dr_id" value="<?php echo $data->dr_id;?>">
    <div class="djad_day form-group">
        <label for="djad_day " class="control-label col-md-3">Hari</label>
        <div class="col-md-9">
            <select name="djad_day" id="djad_day" class="form-control">
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
    <div class="form-group djad_jam">
        <label for="djad_start" class="control-label col-md-3">Jam Mulai / Berakhir</label>
        <div class="col-md-3 djad_start">
            <input type="text" name="djad_start" id="djad_start" class="form-control" value="07:00">
        </div>
        <div class="col-md-3 djad_end">
            <input type="text" name="djad_end" id="djad_end" class="form-control" value="12:00">
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
            url     : base_url + 'dokter/add_jadwal_submit',
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
        })
        return false;
    })
</script>