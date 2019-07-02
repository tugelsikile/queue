<form id="new_form" class="form form-horizontal">
    <input type="hidden" name="spc_id" value="<?php echo $data->spc_id;?>">
    <div class="spc_name form-group">
        <label for="spc_name" class="control-label col-md-3">Nama Spesialisasi</label>
        <div class="col-md-9">
            <input type="text" name="spc_name" id="spc_name" class="form-control" placeholder="Nama Spesialisasi" value="<?php echo $data->spc_name;?>">
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
            url     : base_url + 'dokter/edit_spesialis_submit',
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