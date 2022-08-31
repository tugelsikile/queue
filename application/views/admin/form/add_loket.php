<form id="new_form" class="form form-horizontal">
    <div class="loket_name form-group">
        <label for="loket_name " class="control-label col-md-3">Nama Loket</label>
        <div class="col-md-9">
            <input type="text" name="loket_name" id="loket_name" class="form-control" placeholder="Nama Loket" value="">
        </div>
    </div>
    <div class="loket_kode form-group">
        <label for="loket_kode" class="control-label col-md-3">Kode Loket</label>
        <div class="col-md-9">
            <input type="text" name="loket_kode" id="loket_kode" class="form-control" size="1" placeholder="Kode Loket (MAX 1 karakter)" value="">
        </div>
    </div>
    <div class="loket_poli form-group">
        <label class="control-label col-md-3">Poli</label>
        <div class="col-md-9">
            <?php
            if (!$data){
                echo 'Tidak ada data poli yang tersedia';
            } else {
                echo '<ul class="list-unstyled">';
                foreach ($data as $value){
                    echo '<li>
                            <input type="checkbox" name="poli_id[]" value="'.$value->poli_id.'">
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
            url     : '<?= site_url()?>/admin/add_loket_submit',
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