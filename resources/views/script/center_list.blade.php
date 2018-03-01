<script>
    $('#filter_center').on('change',function(){
        var id = $(this).val();
        var link = "{{ url('/subjects/') }}/"+id;
        var content = '';
        if(id){
            $.ajax({
                url: link,
                type: 'GET',
                success: function(data){
                    if(data.length>0){
                        $('.show_subjects').removeClass('hide');
                        content += '<ul>';
                        $.each(data, function(key,val){
                            console.log(val);
                            var available = 'Open until '+val.date_close;
                            if(val.date_close==null)
                            {
                                available = 'Always open';
                            }
                            content += '<li><label class="input text-success"> ' +
                                '<input type="checkbox" name="subjects[]" value="'+val.id+'"> ' + val.code +
                                '</label>' +
                                '<small> (<span class="text-primary">'+val.days+', '+val.time+'</span>. '+available+') </small>' +
                                '</li>'
                        });
                        content += '</ul>';
                        $('.list_subjects').html(content);
                    }else{
                        $('.show_subjects').addClass('hide');
                    }
                }
            });
        }else{
            $('.show_subjects').addClass('hide');
        }
    });
</script>