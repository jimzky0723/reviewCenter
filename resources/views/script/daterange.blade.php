<script src="{{ asset('public/panel') }}/vendors/moment/moment.min.js"></script>
<script src="{{ asset('public/panel') }}/vendors/datepicker/daterangepicker.js"></script>
<script>
    $(document).ready(function() {
        $('#reservation').daterangepicker(null, function(start, end, label) {

        });
    });
</script>