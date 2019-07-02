<form id="new_form" class="form form-horizontal">
    <input type="hidden" name="loket_id" value="<?php echo $data->loket_id;?>">
    <div class="loket_name form-group">
        <label for="loket_name " class="control-label col-md-3">Nama Loket</label>
        <div class="col-md-9">
            <input type="text" name="loket_name" id="loket_name" class="form-control" placeholder="Nama Loket" value="<?php echo $data->loket_name;?>">
        </div>
    </div>
    <div class="loket_kode form-group">
        <label for="loket_kode" class="control-label col-md-3">Kode Loket</label>
        <div class="col-md-9">
            <input type="text" name="loket_kode" size="1" id="loket_kode" class="form-control" placeholder="Kode Loket (MAX 1 karakter)" value="<?php echo $data->loket_kode;?>">
        </div>
    </div>
    <div class="loket_poli form-group">
        <label class="control-label col-md-3">Poli</label>
        <div class="col-md-9">
            <?php
            if (!$poli){
                echo 'Tidak ada data poli yang tersedia';
            } else {
                echo '<ul class="list-unstyled">';
                foreach ($poli as $value){
                    $checked = '';
                    if ($value->check == 1){
                        $checked = 'checked';
                    }
                    echo '<li>
                            <input type="checkbox" name="poli_id[]" value="'.$value->poli_id.'" '.$checked.'>
                            '.$value->poli_name.'
                          </li>';
                }
                echo '</ul>';
            }
            ?>
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
            url     : base_url + 'admin/edit_loket_submit',
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