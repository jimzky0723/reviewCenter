<script src="{{ asset('public/panel') }}/vendors/moment/moment.min.js"></script>
<script src="{{ asset('public/panel') }}/vendors/datepicker/daterangepicker.js"></script>
<script>

    $(document).ready(function() {
        $('#birthday').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            calender_style: "picker_3"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });

        $('#dateOpen').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            calender_style: "picker_3"
        }, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>