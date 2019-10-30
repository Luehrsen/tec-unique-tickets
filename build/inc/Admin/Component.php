<?php
/**
 * Base Component Class that handles the admin side of the plugin.
 *
 * @package tecut/admin
 */

namespace tecut\Admin;
use tecut\Component_Interface;
use function add_action;
use function load_plugin_textdomain;

/**
 * A class to handle textdomains and other i18n related logic..
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the plugin component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() {
		return 'admin';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'tribe_events_tickets_metabox_edit_advanced', array( $this, 'ticket_edit_advanced' ), 10, 2 );
		add_action( 'event_tickets_after_save_ticket', array( $this, 'add_ticket' ), 10, 3 );
	}

	/**
	 * Allows for the insertion of additional content into the ticket edit form - advanced section
	 *
	 * @since 4.6
	 *
	 * @param int      $post_id  Post ID.
	 * @param int|null $ticket_id  Ticket ID.
	 */
	public function ticket_edit_advanced( $post_id, $ticket_id ) {
		ob_start();
		include 'views/unique_tickets.php';
		$content = ob_get_contents();
		ob_end_clean();

		echo $content;
	}

	/**
	 * Save the additional post meta needed for our purpose.
	 *
	 * @param int    $post_id The post id.
	 * @param object $ticket The ticket object.
	 * @param array  $data The data array.
	 */
	public function add_ticket( $post_id, $ticket, $data ) {
		update_post_meta( $ticket->ID, '_unique_items', $data['ticket_unique_items'] );
	}
}
