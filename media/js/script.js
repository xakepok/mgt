jQuery(document).ready(function () {
    jQuery('#mgt-filter').bind('submit', function () {
        var date_1 = jQuery("input[name='date_1']").val();
        var date_2 = jQuery("input[name='date_2']").val();
        var vehicle = jQuery("input[name='vehicle']").val();
        var route = jQuery("input[name='route']").val();
        var park = jQuery("select[name='park'] :selected").val();
        console.log('date_1: ' + date_1 + ', date_2: ' + date_2 + ', vehicle: ' + vehicle + ', park: ' + park + ', route: ' + route);
        if (date_1 != date_2 && park == '' && vehicle == '' && route == '')
        {
            showError(1);
            return false;
        }
    });
    jQuery("input[name='vehicle']").change(function () {
        if (jQuery("input[name='vehicle']").val() != '') jQuery("input[name='route']").val('');
    });
    jQuery("input[name='route']").change(function () {
        console.log(this.value);
        if (jQuery("input[name='route']").val() != '') jQuery("input[name='vehicle']").val('');
    });
    jQuery(".mgt-cur-date").bind('click', function () {
        jQuery("input[name='date_2']").val(jQuery("input[name='date_1']").val());
    });
});

function showError(code) {
    jQuery("#mgt-alert").text(errors[code]).show();
}

var errors = [];
errors[1] = 'Слишком большой временной промежуток. Укажите больше параметров в фильтре.';