$(function () {
	Date.format = 'dd/mm/yy';
        
    $(function () {
        $(".date-picker").datepicker({
            changeMonth: true,
            changeYear: true,
            currentText: 'Today',
            dateFormat: 'mm/dd/yy',
            duration: 'fast',
            maxDate: new Date(2030, 1 - 1, 1),
            minDate: new Date(1940, 1 - 1, 1),
            showAnim: 'drop',
            showButtonPanel: false,
            yearRange: '1950:2030'
        });
    });
    
    $("table").delegate('td', 'mouseover mouseleave', function (e) {
        if (e.type == 'mouseover') {
            $(this).parent().addClass("hover");
            $("colgroup").eq($(this).index()).addClass("hover");
        } else {
            $(this).parent().removeClass("hover");
            $("colgroup").eq($(this).index()).removeClass("hover");
        }
    });
    
});