<form id="new_form" class="form form-horizontal">
    <input type="hidden" name="user_id" value="<?php echo $data->user_id;?>">
    <div class="user_fullname form-group">
        <label for="user_fullname " class="control-label col-md-3">Nama Lengkap</label>
        <div class="col-md-9">
            <input type="text" name="user_fullname" id="user_fullname" class="form-control" placeholder="Nama Lengkap Pengguna" value="<?php echo $data->user_fullname;?>">
        </div>
    </div>
    <div class="user_name form-group">
        <label for="user_name" class="control-label col-md-3">Username</label>
        <div class="col-md-9">
            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" value="<?php echo $data->user_name;?>">
        </div>
    </div>
    <div class="user_password form-group">
        <label for="user_password" class="control-label col-md-3">Password</label>
        <div class="col-md-9">
            <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password Pengguna (Kosongkan jika tidak ingin dirubah)">
        </div>
    </div>
    <div class="user_level form-group">
        <label for="user_level" class="control-label col-md-3">Hak Akses</label>
        <div class="col-md-9">
            <select name="user_level" id="user_level" class="form-control">
                <option value="1">Kasir</option>
                <option value="99">Administrator</option>
            </select>
        </div>
    </div>

</form>

<script>
    $('#user_level').val('<?php echo $data->user_level;?>');
    $('#modal1 .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                                    '<button type="button" onclick="$(\'#modal1 #new_form\').submit();" class="btn-submit btn btn-primary"><i class="fa fa-check"></i> Simpan</button>');
    $('#modal1 #new_form').submit(function (e) {
        $('#modal1 .btn-submit').html('<i class="fa fa-spin fa-refresh"></i> Simpan').addClass('disabled').prop({'disabled':true});
        $('#modal1 #new_form .has-error').removeClass('has-error');
        $.ajax({
            url     : base_url + 'admin/edit_user_submit',
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