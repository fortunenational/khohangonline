<div class='ewd-otp-customer-order-form-field'>

	<div class='ewd-otp-customer-order-form-label'>
		<?php echo esc_html( $this->custom_field->name ); ?>:
	</div>
	
	<div class='ewd-otp-customer-order-form-value'>
		<input name='ewd_otp_custom_field_<?php echo $this->custom_field->id; ?>' type='text' <?php echo ( $this->custom_field->required ? 'required' : '' ); ?> />
	</div>
	
</div>