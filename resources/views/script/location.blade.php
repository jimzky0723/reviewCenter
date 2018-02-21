<script>
    var province = "{{ isset($data['provCode']) ? $data['provCode']: '' }}";
    var muncity = "{{ isset($data['muncityCode']) ? $data['muncityCode']: '' }}";
    var barangay = "{{ isset($data['barangayCode']) ? $data['barangayCode']: '' }}";

    if(province){
        filterProvince(province);
    }

    if(muncity)
    {
        $('#muncity').val(muncity);
        filterMuncity(muncity);
    }

    if(barangay)
    {
        $('#barangay').val(barangay);
    }

    $('#province').on('change',function(){
        $('.loading').show();
        var provCode = $(this).val();
        filterProvince(provCode);
    });

    $('#muncity').on('change',function(){
        $('.loading').show();
        var muncityCode = $(this).val();
        filterMuncity(muncityCode);
    });

    function filterProvince(provCode)
    {
        $('#muncity').empty()
            .append($('<option>', {
                value: "",
                text : "Select Municipality / City..."
            }));
        var data = getMuncity(provCode);
        jQuery.each(data, function(i,val){
            $('#muncity').append($('<option>', {
                value: val.muncityCode,
                text : val.desc
            }));

        });
        $('#barangay').empty()
            .append($('<option>', {
                value: "",
                text : "Select Barangay..."
            }));
    }

    function filterMuncity(muncityCode)
    {
        $('#barangay').empty()
            .append($('<option>', {
                value: "",
                text : "Select Barangay..."
            }));
        var data = getBarangay(muncityCode);
        jQuery.each(data, function(i,val){
            $('#barangay').append($('<option>', {
                value: val.code,
                text : val.desc
            }));

        });
    }

    function getMuncity(provCode)
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

    function getBarangay(muncityCode)
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