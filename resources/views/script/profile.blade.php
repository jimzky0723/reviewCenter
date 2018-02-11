<script>
    $('.btn-check').on('click',function(){
        $('.loading').show();
        var form = $('.form-submit');
        var content = '';
        var input = $('#addProfile');
        var data = {
            '_token' : "{{ csrf_token() }}",
            'fname' : input.find('.fname').val(),
            'mname' : input.find('.mname').val(),
            'lname' : input.find('.lname').val()
        };

        form.find('.fname').val(data.fname);
        form.find('.mname').val(data.mname);
        form.find('.lname').val(data.lname);

        $.ajax({
            url: "{{ url('param/checkProfile') }}",
            type: "POST",
            data: data,
            success: function(record){
                if(record.length > 0)
                {
                    content += '<table class="table table-hover">';
                    jQuery.each(record, function(i,val){
                        var name = val.fname+' '+val.mname+' '+val.lname;
                        var level = val.level;
                        level = level.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        });
                        var link = "{{ url('center/') }}/"+val.level+'/'+val.id;
                        content += '<tr>' +
                           '<td>' +
                            '<strong><a href="'+link+'"> '+name+'</a></strong>' +
                            '<br />' +
                            '<small class="text-success">'+level+'</small>' +
                            '</td>' +
                            '</tr>';
                    });
                    content += '</table>';
                    $('#addProfile').find('.modal-body').html(content);
                    $('#addProfile').find('.btn-check').hide();
                }else{
                    $('#addProfile').modal('hide');
                }
                $('.loading').hide();
            }
        });
    });

    $('#username').on('keyup blur',function(){
        var id = $(this).data('id');
        var data = {
            '_token' : "{{ csrf_token() }}",
            'username' : $(this).val(),
            'id': id
        };
        console.log(data);
        $.ajax({
            url: "{{ url('param/checkUsername') }}",
            type: "POST",
            data: data,
            success: function(record){
                if(record==1){
                    $('.username-block').removeClass('hide');
                    $('#saveProfile').attr('disabled','disabled');
                }else{
                    $('.username-block').addClass('hide');
                    $('#saveProfile').attr('disabled',false);
                }
            }
        });
    });
</script>