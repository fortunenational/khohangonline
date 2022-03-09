<div class='ewd-otp-available-orders-list'>

	<?php foreach ( $this->get_all_orders() as $order ) { ?>
	
		<div class='ewd-otp-available-orders-list-item'>
	
			<a href='<?php echo add_query_arg( 'tracking_number', $order->number ); ?>'>
				<?php echo esc_html( $order->number ); ?>
			</a>
	
		</div>
	
	<?php } ?>

</div>