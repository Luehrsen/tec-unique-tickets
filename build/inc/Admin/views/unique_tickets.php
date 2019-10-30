<?php
/**
 * The file that renders our view for the 'advanced_fields' section of the ticket
 * edit screen.
 *
 * @package tecut/admin
 */

?>

<div class="input_block">
	<label class="ticket_form_label ticket_form_left" for="ticket_unique_items"><?php esc_html_e( 'Unique Tickets:', 'tec-unique-tickets' ); ?></label>
	<div class="ticket_form_right">
		<input
			autocomplete="off"
			type="text"
			class="ticket_field"
			name="ticket_unique_items"
			id="ticket_unique_items"
			value="<?php echo esc_attr( get_post_meta( $ticket_id, '_unique_items', true ) ); ?>"
		/>
	</div>
</div>
