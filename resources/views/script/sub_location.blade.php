<script>
    var province = "{{ isset($data['provCode']) ? $data['provCode']: '' }}";
    var muncity = "{{ isset($data['muncityCode']) ? $data['muncityCode']: '' }}";
    var barangay = "{{ isset($data['barangayCode']) ? $data['barangayCode']: '' }}";

    if(province){
        filterProvince2(province);
    }

    if(muncity)
    {
        $('#muncity2').val(muncity);
        filterMuncity2(muncity);
    }

    if(barangay)
    {
        $('#barangay2').val(barangay);
    }

    $('#province2').on('change',function(){
        $('.loading').show();
        var provCode = $(this).val();
        filterProvince2(provCode);
    });

    $('#muncity2').on('change',function(){
        $('.loading').show();
        var muncityCode = $(this).val();
        filterMuncity2(muncityCode);
    });

    function filterProvince2(provCode)
    {
        $('#muncity2').empty()
            .append($('<option>', {
                value: "",
                text : "Select Municipality / City..."
            }));
        var data = getMuncity2(provCode);
        jQuery.each(data, function(i,val){
            $('#muncity2').append($('<option>', {
                value: val.muncityCode,
                text : val.desc
            }));

        });
        $('#barangay2').empty()
            .append($('<option>', {
                value: "",
                text : "Select Barangay..."
            }));
    }

    function filterMuncity2(muncityCode)
    {
        $('#barangay2').empty()
            .append($('<option>', {
                value: "",
                text : "Select Barangay..."
            }));
        var data = getBarangay2(muncityCode);
        jQuery.each(data, function(i,val){
            $('#barangay2').append($('<option>', {
                value: val.code,
                text : val.desc
            }));

        });
    }

    function getMuncity2(provCode)
    {
        var url = "{{ url('location/muncity') }}";
        var tmp;
        $.ajax({
            url: url+"/"+provCode,
            type: 'get',
            async: false,
            success : function(data){
                tmp = data;
                $('.loading').hide();
            }
        });
        return tmp;

    }

    function getBarangay2(muncityCode)
    {
        var url = "{{ url('location/barangay') }}";
        var tmp;
        $.ajax({
            url: url+"/"+muncityCode,
            type: 'get',
            async: false,
            success : function(data){
                tmp = data;
                $('.loading').hide();
            }
        });
        return tmp;
    }
</script>