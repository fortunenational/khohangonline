//NEW DASHBOARD MOBILE MENU AND WIDGET TOGGLING
jQuery(document).ready(function($){
	$('#ewd-otp-dash-mobile-menu-open').click(function(){
		$('.ewd-otp-admin-header-menu .nav-tab:nth-of-type(1n+2)').toggle();
		$('#ewd-otp-dash-mobile-menu-up-caret').toggle();
		$('#ewd-otp-dash-mobile-menu-down-caret').toggle();
		return false;
	});
	$(function(){
		$(window).resize(function(){
			if($(window).width() > 785){
				$('.ewd-otp-admin-header-menu .nav-tab:nth-of-type(1n+2)').show();
			}
			else{
				$('.ewd-otp-admin-header-menu .nav-tab:nth-of-type(1n+2)').hide();
				$('#ewd-otp-dash-mobile-menu-up-caret').hide();
				$('#ewd-otp-dash-mobile-menu-down-caret').show();
			}
		}).resize();
	});	
	$('#ewd-otp-dashboard-support-widget-box .ewd-otp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-otp-dashboard-support-widget-box .ewd-otp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-otp-dash-mobile-support-up-caret').toggle();
		$('#ewd-otp-dash-mobile-support-down-caret').toggle();
	});
	$('#ewd-otp-dashboard-optional-table .ewd-otp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-otp-dashboard-optional-table .ewd-otp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-otp-dash-optional-table-up-caret').toggle();
		$('#ewd-otp-dash-optional-table-down-caret').toggle();
	});
});

/***********************************************
* ORDERS TABLE 
***********************************************/

// REQUIRE CONFIRMATION BEFORE DELETING AN ORDER
jQuery( '.orders #the-list .delete' ).on( 'click', function() {

	var order_id = jQuery( this ).data( 'id' );

	var response = confirm( 'You are about to delete this order' );

	if ( response ) { 

		var data = 'order_id=' + order_id + '&action=ewd_otp_delete_order';
        jQuery.post(ajaxurl, data, function(response) {});

        setTimeout( function() { window.location.reload( true ) }, 150 );
	} 
});

// HIDE AN ORDER
jQuery( '.orders #the-list .hide' ).on( 'click', function() {

	var order_id = jQuery( this ).data( 'id' );

	var data = 'order_id=' + order_id + '&action=ewd_otp_hide_order';
    jQuery.post(ajaxurl, data, function(response) {});

    setTimeout( function() { window.location.reload( true ) }, 150 );
});

// SUBMIT FORM ON 'include_hidden_orders' CHECKBOX TOGGLE
jQuery( '.ewd-otp-admin-table-filter-div input[name="include_hidden_orders"]' ).on( 'change', function() {
	
	jQuery( '#ewd-otp-orders-table' ).submit();
});


/***********************************************
* CUSTOMERS TABLE 
***********************************************/

// REQUIRE CONFIRMATION BEFORE DELETING A CUSTOMER
jQuery( '.customers #the-list .delete' ).on( 'click', function() {

	var customer_id = jQuery( this ).data( 'id' );

	var response = confirm( 'You are about to delete this customer' );

	if ( response ) { 

		var data = 'customer_id=' + customer_id + '&action=ewd_otp_delete_customer';
        jQuery.post(ajaxurl, data, function(response) {});

        setTimeout( function() { window.location.reload( true ) }, 150 );
	} 
});


/***********************************************
* SALES REPS TABLE 
***********************************************/

// REQUIRE CONFIRMATION BEFORE DELETING A SALES REP
jQuery( '.salesreps #the-list .delete' ).on( 'click', function() {

	var sales_rep_id = jQuery( this ).data( 'id' );

	var response = confirm( 'You are about to delete this sales rep' );

	if ( response ) { 

		var data = 'sales_rep_id=' + sales_rep_id + '&action=ewd_otp_delete_sales_rep';
        jQuery.post(ajaxurl, data, function(response) {});

        setTimeout( function() { window.location.reload( true ) }, 150 );
	} 
});


/***********************************************
* CUSTOM FIELDS TABLE 
***********************************************/

jQuery( document ).ready( function() {

	ewd_otp_custom_field_delete_handlers();

	jQuery( '.ewd-otp-custom-fields-add' ).on( 'click', function() {
	
		var max_id = 1;
	
		jQuery( 'input[name="ewd_otp_custom_field_id"]' ).each( function() {
	
			max_id = Math.max( max_id, jQuery( this ).val() );
		});
	
		max_id += 1;
	
		let _template = jQuery( '.ewd-otp-custom-field-template' ).clone();
	
	    _template.hide()
	      .removeClass()
	      .addClass( 'ewd-otp-custom-field' );
	
	    _template.find( 'input[name="ewd_otp_custom_field_id"]' ).val( max_id );

	    jQuery( this ).before( _template );
	
	    _template.fadeIn( 'fast' );
	
		ewd_otp_custom_field_delete_handlers();
	});

	jQuery( '#ewd-otp-custom-fields-table' ).on( 'submit', function() {

		var custom_fields = [];

		jQuery( '.ewd-otp-custom-field' ).each( function() {

			if ( jQuery( this ).find( 'input[name="ewd_otp_custom_field_id"]' ).val() == 0 ) { return; }

			var custom_field = {};

			custom_field.id 				= jQuery( this ).find( 'input[name="ewd_otp_custom_field_id"]' ).val();
			custom_field.name 				= jQuery( this ).find( 'input[name="ewd_otp_custom_field_name"]' ).val();
			custom_field.slug 				= jQuery( this ).find( 'input[name="ewd_otp_custom_field_slug"]' ).val();
			custom_field.type 				= jQuery( this ).find( 'select[name="ewd_otp_custom_field_type"]' ).val();
			custom_field.options 			= jQuery( this ).find( 'input[name="ewd_otp_custom_field_options"]' ).val();
			custom_field.function 			= jQuery( this ).find( 'select[name="ewd_otp_custom_field_function"]' ).val();
			custom_field.required 			= jQuery( this ).find( 'input[name="ewd_otp_custom_field_required"]' ).is( ':checked' );
			custom_field.display 			= jQuery( this ).find( 'input[name="ewd_otp_custom_field_display"]' ).is( ':checked' );
			custom_field.front_end_display	= jQuery( this ).find( 'input[name="ewd_otp_custom_field_front_end_display"]' ).is( ':checked' );
			custom_field.equivalent			= jQuery( this ).find( 'select[name="ewd_otp_custom_field_equivalent"]' ).val();

			custom_fields.push( custom_field ); 
		});

		jQuery( 'input[name="ewd-otp-custom-field-save-values"]' ).val( JSON.stringify( custom_fields ) );
	});

	if ( jQuery( '#ewd-otp-custom-fields-table' ).length ) {

		jQuery( '#ewd-otp-custom-fields-table' ).sortable({
			items: 'div.ewd-otp-custom-field',
			cursor: 'move'
		});
	}
});

function ewd_otp_custom_field_delete_handlers() {

	jQuery( '.ewd-otp-custom-field-delete' ).off( 'click' ).on( 'click', function() {

		jQuery( this ).parent().remove();

	});
}


/***********************************************
* INFINITE TABLE IDs
***********************************************/

jQuery(document).ready(function($){

	$( '.sap-new-admin-add-button' ).on( 'click', function() {

		setTimeout( ewd_otp_field_added_handler, 300);
	});
});

function ewd_otp_field_added_handler() {

	var highest = 0;
	jQuery( '.sap-infinite-table input[data-name="id"]' ).each( function() {
		if ( ! isNaN( this.value ) ) { highest = Math.max( highest, this.value ); }
	});

	jQuery( '.sap-infinite-table  tbody tr:last-of-type span.sap-infinite-table-hidden-value' ).html( highest + 1 );
	jQuery( '.sap-infinite-table  tbody tr:last-of-type input[data-name="id"]' ).val( highest + 1 );
}


// ORDERS TABLE SPECIFIC DATE FILTERING

jQuery(document).ready(function(){

	jQuery( '#ewd-otp-date-filter-link' ).click( function() {
		
		jQuery( '#ewd-otp-filters' ).toggleClass( 'date-filters-visible' );
	});
});
