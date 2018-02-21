<script>
    var url = "{{ asset('login/validate') }}";
    var btn = $('.btn-login');
    var error = '';

    btn.on('click',function(){
        var user = $('.username').val();
        var pass = $('.password').val();

        if(!user){
            error = errorMsg('Please enter your username');
            $('.username').siblings('.help-block').html(error);
        }else{
            $('.username').siblings('.help-block').html('');
        }
        if(!pass){
            error = errorMsg('Please enter your password');
            $('.password').siblings('.help-block').html(error);
        }else{
            $('.password').siblings('.help-block').html('');
        }

        if(user && pass)
        {
            btn.html('<i class="fa fa-spinner fa-spin"></i> Validating...');
            btn.attr('disabled','disabled');
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    user: user,
                    pass: pass
                },
                success: function(data){
                    if(data==='success')
                    {
                        window.location.replace("{{ asset('validate') }}");
                    }else if(data==='pending'){
                        btn.html('LOGIN');
                        btn.attr('disabled',false);
                        error = errorMsg('Your account is not yet activated!');
                        $('.username').siblings('.help-block').html(error);
                    }else{
                        btn.html('LOGIN');
                        btn.attr('disabled',false);
                        error = errorMsg('Invalid username / password. Please try again!');
                        $('.username').siblings('.help-block').html(error);
                    }
                }
            });
        }
    });

    function errorMsg(msg)
    {
        return "<ul class='list-unstyled'><li>"+msg+"</li></ul>";
    }
</script>