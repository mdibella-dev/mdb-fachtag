jQuery(function($) {

    $(document).ready( function() {

        // Hamburger-Menü an/aus
        $( '.hamburger' ).click( function() {
		    $( this ).toggleClass( 'is-active' );
            $( '#primary-aux' ).toggleClass( 'is-active' );
            event.stopPropagation();
	    } );

    } );

} );
