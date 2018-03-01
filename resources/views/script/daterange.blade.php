<link rel="stylesheet" href="{{ asset('public/panel') }}/vendors/timepicker/timepicker.min.css">
<script src="{{ asset('public/panel') }}/vendors/moment/moment.min.js"></script>
<script src="{{ asset('public/panel') }}/vendors/datepicker/daterangepicker.js"></script>
<script src="{{ asset('public/panel') }}/vendors/timepicker/timepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reservation').daterangepicker(null, function(start, end, label) {

        });

        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 30,
            minTime: '7',
            maxTime: '6:00pm',
            defaultTime: '7',
            startTime: '07:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>