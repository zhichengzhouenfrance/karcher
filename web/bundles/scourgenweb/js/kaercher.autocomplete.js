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
        }
    });

    $("[name='rememberme']").bootstrapSwitch();
});