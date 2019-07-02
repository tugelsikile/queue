<form id="new_form" class="form form-horizontal">
    <input type="hidden" name="dr_id" value="<?php echo $data->dr_id;?>">
    <div class="dr_name form-group">
        <label for="dr_name " class="control-label col-md-3">Nama Dokter</label>
        <div class="col-md-9">
            <input type="text" name="dr_name" id="dr_name" class="form-control" placeholder="Nama Dokter" value="<?php echo $user->user_fullname;?>">
        </div>
    </div>
    <div class="spc_id form-group">
        <label for="spc_id" class="control-label col-md-3">Spesialis</label>
        <div class="col-md-9">
            <select name="spc_id" id="spc_id" class="form-control">
                <option value="">Pilih spesialisasi</option>
                <?php
                if ($spc){
                    foreach ($spc as $val){
                        echo '<option value="'.$val->spc_id.'">'.$val->spc_name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="user_name form-group">
        <label class="control-label col-md-3" for="user_name">Username</label>
        <div class="col-md-9">
            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" value="<?php echo $user->user_name;?>">
        </div>
    </div>
    <div class="user_password form-group">
        <label class="control-label col-md-3" for="user_password">Password</label>
        <div class="col-md-9">
            <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password (kosongkan jika tidak ingin dirubah)" value="">
        </div>
    </div>
    <div class="form-group dr_quota">
        <label class="control-label col-md-3">Max Quota</label>
        <div class="col-md-9">
            <input type="number" name="dr_quota" id="dr_quota" class="form-control" placeholder="Max Quota Pendaftaran" min="1" max="1000" step="1" value="<?php echo $data->dr_quota;?>">
        </div>
    </div>
    <div class="poli_id form-group">
        <label class="control-label col-md-3" for="poli_id">Poli</label>
        <div class="col-md-9">
            <select name="poli_id" id="poli_id" class="form-control">
                <option value="">Pilih Poli</option>
                <?php
                if ($poli){
                    foreach ($poli as $val){
                        echo '<option value="'.$val->poli_id.'">'.$val->poli_name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>

</form>

<script>
    $('#spc_id').val('<?php echo $data->spc_id;?>');
    $('#poli_id').val('<?php echo $data->poli_id;?>');
    $('#modal1 .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                                    '<button type="button" onclick="$(\'#modal1 #new_form\').submit();" class="btn-submit btn btn-primary"><i class="fa fa-check"></i> Simpan</button>');
    $('#modal1 #new_form').submit(function (e) {
        $('#modal1 .btn-submit').html('<i class="fa fa-spin fa-refresh"></i> Simpan').addClass('disabled').prop({'disabled':true});
        $('#modal1 #new_form .has-error').removeClass('has-error');
        $.ajax({
            url     : base_url + 'dokter/edit_dokter_submit',
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