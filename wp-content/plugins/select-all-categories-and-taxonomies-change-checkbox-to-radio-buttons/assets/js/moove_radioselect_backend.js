
(function($){
    $(document).ready(function(){
        $(document).on('change', '.moove-taxonomy-cnt select', function(){
            if ( $( this ).val() === 'checkbox' ) {
                $( this ).parent().find( '.moove_select_all_btn' ).show();
            } else {
                $( this ).parent().find(' .moove_select_all_btn' ).hide();
            }
        });
        $(document).on( 'click','.moove-radioselect-selectall', function(e){
            e.preventDefault();
            cntid = $( this ).closest('.tabs-panel').attr('id');
            $sector_checkBoxes = $('div#'+cntid+'.tabs-panel input[type="checkbox"]');
            $sector_selected_checkBoxes = $('div#'+cntid+'.tabs-panel input[type="checkbox"]:checked');

            if ($(this).hasClass('moove-radioselect-deselect')) {
                $sector_checkBoxes.attr( "checked", false );
            } else {
                $sector_checkBoxes.attr( "checked", true );
            }
            $( this ).toggleClass( 'moove-radioselect-deselect' ).attr('id');
        });
    });
})(jQuery);
