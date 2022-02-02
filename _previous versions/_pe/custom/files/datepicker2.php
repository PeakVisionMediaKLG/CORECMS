<input id="datepicker2" width="276" />
    <script>
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            disableDaysOfWeek: [0, 6],
            disableDates:  function (date) {
                var disabled = [10,15,20,25];
                if (disabled.indexOf(date.getDate()) == -1 ) {
                    return true;
                } else {
                    return false;
                }
            } 

            
            
            
        });
</script>