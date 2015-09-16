$(function() {
    $( "#reference" ).autocomplete({
        source: function( request, response ) {

            $.ajax({
                dataType: "json",
                type : 'POST',
                data: request,
                url: "autocomplete/",
                success: response,
                error: function(data) {
                    /* $('input.suggest-user').removeClass('ui-autocomplete-loading');*/
                }
            });
        },
        select: function( event, ui ) {
            $('#reference').val(ui.item.value);
            console.log(ui.item.value);
            $( "#article_form" ).submit()
        },
        open: function(event, ui) {
            $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
        }
    });

    $("[name='rememberme']").bootstrapSwitch();
});