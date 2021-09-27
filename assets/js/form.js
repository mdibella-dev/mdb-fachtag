jQuery(function($) {

    window.onload = function() {
        history.replaceState(null, document.title, location.href);
    }


    $("#field_check").change(function(e) {
        if( $("#field_check").prop('checked') ) {
            $("#submit").prop('disabled', false );
        } else {
            $("#submit").prop('disabled', true );
        }
    } );
} );
