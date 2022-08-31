<form id="new_form" class="form form-horizontal">
    <div class="poli_name form-group">
        <label for="poli_name" class="control-label col-md-3">Nama Poli</label>
        <div class="col-md-9">
            <input type="text" name="poli_name" id="poli_name" class="form-control" placeholder="Nama Poli" value="">
        </div>
    </div>
    <div class="poli_kode form-group">
        <label for="poli_kode" class="control-label col-md-3">Kode Poli</label>
        <div class="col-md-9">
            <input type="text" name="poli_kode" size="1" id="poli_kode" class="form-control" placeholder="Kode Poli (MAX 1 karakter)" value="">
        </div>
    </div>
    <div class="loket_id form-group">
        <label class="control-label col-md-3" for="loket_id">Loket Pendaftaran</label>
        <div class="col-md-9">
            <select name="loket_id" id="loket_id" class="form-control">
                <option value="">Pilih Loket</option>
                <?php
                if ($data){
                    foreach ($data as $value){
                        echo '<option value="'.$value->loket_id.'">'.$value->loket_name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="poli_pic form-group">
        <label for="poli_pic" class="control-label col-md-3">Gambar Poli</label>
        <div class="col-md-9">
            <input type="file" name="poli_pic" id="poli_pic" class="form-control" placeholder="Gambar Poli">
        </div>
    </div>
</form>

<script>
    $('#modal1 .modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
                                    '<button type="button" onclick="$(\'#modal1 #new_form\').submit();" class="btn-submit btn btn-primary"><i class="fa fa-check"></i> Simpan</button>');
    $('#modal1 #new_form').submit(function (e) {
        $('#modal1 .btn-submit').html('<i class="fa fa-spin fa-refresh"></i> Simpan').addClass('disabled').prop({'disabled':true});
        $('#modal1 #new_form .has-error').removeClass('has-error');
        var form = $('#modal1 #new_form')[0];
        var formData = new FormData(form);
        $.ajax({
            //url     : base_url + 'admin/add_poli_submit',
            url     : '<?= site_url() ?>/admin/add_poli_submit',
            type    : 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data    : formData,
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