( function( $ ) {
	FLBuilderSubscribeForm = function( settings )
	{
		this.settings	= settings;
		this.nodeClass	= '.fl-node-' + settings.id;
		this.form 		= $( this.nodeClass + ' .njba-subscribe-form' );
		this.button		= this.form.find( 'a.njba-btn' );
		this._init();
		//console.log(this.nodeClass); 
		//console.log(this.settings); 
		//console.log(this.button); 
	};
	FLBuilderSubscribeForm.prototype = {
		settings	: {},
		nodeClass	: '',
		form		: null,
		button		: null,
		_init: function()
		{
			this.button.on( 'click', $.proxy( this._submitForm, this ) );
		},
		_submitForm: function( e )
		{
			var postId      	= this.form.closest( '.fl-builder-content' ).data( 'post-id' ),
				templateId		= this.form.data( 'template-id' ),
				templateNodeId	= this.form.data( 'template-node-id' ),
				nodeId      	= this.form.closest( '.fl-module' ).data( 'node' ),
				buttonText  	= this.button.find( 'a.njba-btn' ).text(),
				waitText    	= this.button.closest( '.njba-form-button' ).data( 'wait-text' ),
				name        	= this.form.find( 'input[name=njba-subscribe-form-name]' ),
				email       	= this.form.find( 'input[name=njba-subscribe-form-email]' ),
				re          	= /\S+@\S+\.\S+/,
				valid       	= true;
				/*console.log(buttonText); */
			e.preventDefault();
			name.on('focus', this._removeErrorClass);
			email.on('focus', this._removeErrorClass);
			if ( this.button.hasClass( 'njba-form-button-disabled' ) ) {
				return; // Already submitting
			}
			if ( name.length > 0 && name.val() == '' ) {
				name.addClass( 'njba-form-error' );
				name.siblings( '.njba-form-error-message' ).show();
				valid = false;
			}
			/*if ( '' == email.val() || ! re.test( email.val() ) ) {
				email.addClass( 'njba-form-error' );
				email.siblings( '.njba-form-error-message' ).show();
				valid = false;
			}
			*/
			if( email.val() !=''){
				if ( ! re.test( email.val() ) ) {
					email.addClass( 'njba-form-error' );
					email.siblings( '.njba-form-error-message' ).show();
					valid = false;
				}
			}
			if ( '' == email.val()  ) {
				email.addClass( 'njba-form-error' );
				email.siblings( '.njba-form-error-msg' ).show();
				valid = false;
			}
			if ( valid ) {
				this.form.find( '> .njba-form-error-message' ).hide();
				this.button.find( '.njba-button-text' ).text( waitText );
				this.button.data( 'original-text', buttonText );
				this.button.addClass( 'njba-form-button-disabled' );
				$.post( FLBuilderLayoutConfig.paths.wpAjaxUrl, {
					action  			: 'fl_builder_subscribe_form_submit',
					name    			: name.val(),
					email   			: email.val(),
					post_id 			: postId,
					template_id 		: templateId,
					template_node_id 	: templateNodeId,
					node_id 			: nodeId
				}, $.proxy( this._submitFormComplete, this ) );
			}
		},
		_removeErrorClass: function(){
			$( this ).removeClass('njba-form-error');
			$( this ).siblings('.njba-form-error-message').hide();
			$( this ).siblings('.njba-form-error-msg').hide();
		},
		_submitFormComplete: function( response )
		{
			var data        = JSON.parse( response ),
				buttonText  = this.button.data( 'original-text' );
			if ( data.error ) {
				if ( data.error ) {
					this.form.find( '> .njba-form-error-message' ).text( data.error );
				}
				this.form.find( '> .njba-form-error-message' ).show();
				this.button.removeClass( 'njba-form-button-disabled' );
				this.button.find( '.fl-button-text' ).text( buttonText );
			}
			else if ( 'message' == data.action ) {
				this.form.find( '> *' ).hide();
				this.form.append( '<div class="njba-form-success-message">' + data.message + '</div>' );
			}
			else if ( 'redirect' == data.action ) {
				window.location.href = data.url;
			}
		},
	}
})(jQuery);