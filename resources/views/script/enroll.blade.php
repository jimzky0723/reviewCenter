<script>
    function enroll(form)
    {
        var id = form.data('id');
        $('.loading').show();
        var url = "{{ url('center/class/enroll/'.$classID) }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                user_id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data){
                console.log(data);
                var interval = setTimeout(function(){
                    $('.loading').hide();
                    form.parent().parent().fadeOut(300);
                    clearInterval(interval);
                },500);

            }
        });
    }

    function remove(form)
    {
        var id = form.data('id');
        $('.loading').show();
        var url = "{{ url('center/class/remove/'.$classID) }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                user_id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data){
                console.log(data);
                var interval = setTimeout(function(){
                    $('.loading').hide();
                    form.parent().parent().fadeOut(300);
                    clearInterval(interval);
                },500);

            }
        });
    }
</script>