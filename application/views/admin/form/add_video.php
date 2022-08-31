    <div class="" style="">
        <div class="well text-center">
            <h1>Upload file dengan cepat!</h1>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <form id="uploadForm" class="form-inline" method="post" action="">
                    <input type="hidden" name="x" value="x">
                    <div class="input-group">
                        <label class="input-group-btn">
							<span class="btn btn-danger btn-lg">
								Browse&hellip; <input type="file" id="media" name="media" style="display: none;" required>
							</span>
                        </label>
                        <input type="text" class="form-control input-lg" size="40" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="submit" class="btn btn-lg btn-primary" value="Start upload">
                    </div>
                </form>
                <br>
                <div class="progress" style="display:none">
                    <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0%</span>
                    </div>
                </div>
                <div class="msg alert alert-info text-left" style="display:none"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>



<script>
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });
    //$(document).ready(function() {
    //console.log($('#uploadForm')[0])
        $('#uploadForm').on('submit', function(event){
            event.preventDefault();
            var formdata = new FormData($('#uploadForm')[0]);
            //var files   = $('input[type=file]')[0].files[0];
            //formdata.append('media',files);

            $('.msg').hide();
            $('.progress').show();

            $.ajax({
                xhr : function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e){
                        if(e.lengthComputable){
                            console.log('Bytes Loaded : ' + e.loaded);
                            console.log('Total Size : ' + e.total);
                            console.log('Persen : ' + (e.loaded / e.total));

                            var percent = Math.round((e.loaded / e.total) * 100);

                            $('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
                        }
                    });
                    return xhr;
                },
                type 		: 'POST',
                url 		: '<?= site_url()?>/admin/upload_video',
                data 		: formdata,
                processData : false,
                contentType : false,
                success 	: function(response){
                    $('#uploadForm')[0].reset();
                    $('.progress').hide();
                    $('.msg').show();
                    if (response == "") {
                        alert('File gagal di upload');
                    } else {
                        //var msg = 'File berhasil di upload. ID file = ' + response;
                        //$('.msg').html(msg);
                        $('#modal1').modal('hide');
                        load_data();
                    }
                }
            });
            return false;
        });
    //});

    $('#modal1 .modal-footer').html('');
</script>