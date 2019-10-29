<?php
/**
 * _Lhpbp\Blocks\Component class
 *
 * @package tecut
 */

namespace tecut\Blocks;
use tecut\Component_Interface;
use function add_action;
use function register_block_type;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_register_script;
use function wp_set_script_translations;

/**
 * A class to handle the plugins blocks.
 */
class Component implements Component_Interface {
	/**
	 * Associative array of blocks, keyed by their slug.
	 *
	 * @var array
	 */
	protected $block_list = [];

	/**
	 * Constructor function to populate class vars.
	 */
	public function __construct() {
		$this->block_list = array(
			'tecut/hello-there' => array(),
		);
	}

	/**
	 * Gets the unique identifier for the plugin component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() {
		return 'blocks';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'init', array( $this, 'register_scripts_styles' ) );
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'init', array( $this, 'register_i18n' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );

		add_action( 'get_footer', array( $this, 'enqueue_footer_styles' ) );
	}

	/**
	 * Register needed scripts and styles for our free tier
	 */
	public function register_scripts_styles() {
		wp_register_script(
			'tecut-blocks-helper',
			TECUT_URL . 'js/blocks-helper.min.js',
			array(),
			'<%= pkg.version %>',
			true
		);

		wp_add_inline_script(
			'tecut-blocks-helper',
			'window.tecut = {};',
			'before'
		);

		wp_register_script(
			'tecut-blocks-editor',
			TECUT_URL . 'js/blocks.min.js',
			array( 'tecut-blocks-helper', 'wp-block-library' ),
			'<%= pkg.version %>',
			false
		);

		wp_register_script(
			'tecut-blocks-frontend',
			TECUT_URL . 'js/blocks-frontend.min.js',
			array( 'jquery' ),
			'<%= pkg.version %>',
			true
		);

		wp_localize_script(
			'tecut-blocks-editor',
			'tecutPlugin',
			array(
				'plugin_url' => TECUT_URL,
			)
		);

		wp_register_style(
			'tecut-blocks-editor-style',
			TECUT_URL . 'css/blocks-editor.min.css',
			array(),
			'<%= pkg.version %>'
		);

		wp_register_style(
			'tecut-blocks-style',
			TECUT_URL . 'css/blocks.min.css',
			array(),
			'<%= pkg.version %>'
		);
	}

	/**
	 * Enqueue needed scripts in the frontend
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'tecut-blocks-frontend' );
	}

	/**
	 * Enqueue needed styles for the frontend, but only load in footer.
	 *
	 * @return void
	 */
	public function enqueue_footer_styles() {
		wp_enqueue_style( 'tecut-blocks-style' );
	}

	/**
	 * Enqueue needed assets to display blocks in the edtior
	 *
	 * @return void
	 */
	public function enqueue_block_assets() {
		global $current_screen;
		$is_editor = ( ( $current_screen instanceof WP_Screen ) && $current_screen->is_block_editor() );

		if ( $is_editor ) {
			wp_enqueue_style( 'tecut-blocks-style' );
		}
	}
	/**
	 * Register the blocks for our free tier
	 */
	public function register_blocks() {

		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		foreach ( $this->block_list as $block => $args ) {
			$defaults = array(
				'editor_script' => 'tecut-blocks-editor',
				'editor_style'  => 'tecut-blocks-editor-style',
			);

			$args = wp_parse_args( $args, $defaults );

			register_block_type(
				$block,
				$args
			);
		}
	}

	/**
	 * Register the text domain for our plugin
	 */
	public function register_i18n() {
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'tecut-blocks-editor', 'tecut' );
		}
	}
}
