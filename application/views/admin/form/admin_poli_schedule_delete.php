<form id="new_form" class="form form-horizontal" style="text-align: center">
    <input type="hidden" name="id" value="<?php echo $data->id;?>">
    Anda yakin ingin menghapus data jadwal <strong><?= $this->dbase->dataRow('poli', ['poli_id' => $data->poli_id])->poli_name;?></strong> untuk hari <strong><?= $this->conv->hariIndo($data->hari) ?></strong> ?
</form>

<script>
    $('#modalConfirm .modal-footer').html('<div class="col-md-6"><button type="button" class="btn-block btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button></div>' +
                                    '<div class="col-md-6"><button type="button" onclick="$(\'#modalConfirm #new_form\').submit();" class="btn-block btn-submit btn btn-warning"><i class="fa fa-check"></i> Ya</button></div>');
    $('#modalConfirm #new_form').submit(function (e) {
        $('#modalConfirm .btn-submit').html('<i class="fa fa-spin fa-refresh"></i> Ya').addClass('disabled').prop({'disabled':true});
        $.ajax({
            url     : '<?= site_url()?>/admin/schedule_poli_delete',
            type    : 'POST',
            dataType: 'JSON',
            data    : $(this).serialize(),
            success : function (dt) {
                if (dt.t == 0){
                    show_info(dt.msg);
                    $('#modalConfirm .btn-submit').html('<i class="fa fa-check"></i> Ya').removeClass('disabled').prop({'disabled':false});
                } else {
                    $('#modalConfirm').modal('hide');
                    $('#modalConfirm .btn-submit').html('<i class="fa fa-check"></i> Ya').removeClass('disabled').prop({'disabled':false});
                    show_info(dt.msg);
                    load_data();
                }
            }
        });
        return false;
    })
</script>