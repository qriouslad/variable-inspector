<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Variable_Inspector
 * @subpackage Variable_Inspector/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Variable_Inspector
 * @subpackage Variable_Inspector/admin
 * @author     Bowo <hello@bowo.io>
 */
class Variable_Inspector_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The database table name for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $table;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		global $wpdb;

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->table = $wpdb->prefix . 'variable_inspector';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Variable_Inspector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Variable_Inspector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/variable-inspector-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Variable_Inspector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Variable_Inspector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/variable-inspector-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add a variable to the inspector
	 *
	 * @since 1.0.0
	 */
	public function vi_inspect_variable( $args = array() ) {

		global $wpdb;

		$result = wp_cache_get( 'var_inspect_' . $args[0], 'variable-inspector' );

		if ( false === $result ) {

			$variable_name = sanitize_text_field( $args[0] );

			$variable_content = sanitize_text_field( maybe_serialize( $args[1] ) );

			if ( !empty( $args[2] ) ) {

				$file_path = sanitize_text_field( str_replace( ABSPATH, '', $args[2] ) );

			} else {

				$file_path = '';

			}

			// Line number in origin script

			if ( !empty( $args[3] ) ) {

				$line_number = absint( $args[3] );

			} else {

				$line_number = '';

			}

			// Add to databaase

			$result = $wpdb->insert( 
				$this->table, 
				array(
					'name'			=> $variable_name,
					'content'		=> $variable_content,
					'file_path'		=> $file_path,
					'line_number'	=> $line_number,
				),
				array(
					'%s',
					'%s',
					'%s',
					'%d',
				)
			);

			// Cache the result for 1 seconds. This is to prevent duplicate entries in the DB table.
			wp_cache_set( 'var_inspect_' . $args[0], $result, 'variable-inspector', 1 );

		}

	}

	/**
	 * Clear database table
	 *
	 * @since 1.0.0
	 */
	public function vi_clear_results() {

		global $wpdb;

		$sql = "TRUNCATE {$this->table}";

		$wpdb->query( $sql );

		wp_die( json_encode( array( 'success' => true ) ) );

	}

	/**
	 * The variable inspector
	 *
	 * @since 1.0.0
	 */
	public function vi_inspection_results() {

		// Perform several test inspections

		// $count = 1024;
		// do_action( 'inspect', [ 'count', $count ] );

		// $is_valid = true;
		// do_action( 'inspect', [ 'is_valid', $is_valid ] );

		// $description = 'Lorem ipsum dolor siamet.';
		// do_action( 'inspect', [ 'description', $description ] );

		// $vehicles = array( 'Car', 'Bicycle', 'Bus' );
		// do_action( 'inspect', [ 'vehicles', $vehicles ] );

		// $vehicle_details = array(
		// 	'vehicle'		=> 'Bicycle',
		// 	'wheels'		=> 2,
		// 	'ecofriendly'	=> true,
		// );
		// do_action( 'inspect', [ 'vehicle_details', $vehicle_details ] );

		// $vehicle_types = array(
		// 	'bicycle'	=> array(
		// 		'fuel'			=> 'food',
		// 		'wheels'		=> 2,
		// 		'ecofriendly'	=> true,
		// 	),
		// 	'car'	=> array(
		// 		'fuel'			=> 'gasoline',
		// 		'wheels'		=> 4,
		// 		'ecofriendly'	=> false,
		// 	),
		// );
		// do_action( 'inspect', [ 'vehicle_types', $vehicle_types, __FILE__, __LINE__ ] );

		// global $wp_roles;
		// do_action( 'inspect', [ 'wp_roles', $wp_roles ] );

		// Get inspection results

		global $wpdb;

		$limit = 100;

		$sql = $wpdb->prepare( "SELECT * FROM {$this->table} ORDER BY ID DESC LIMIT %d", array( $limit ) );

		$inspection_results = $wpdb->get_results( $sql, ARRAY_A );

		// Output inspection results

		$output = '';

		if ( empty( $inspection_results ) || ! is_array( $inspection_results ) ) {

			$output .= '<p>There is no data in the inspection log.</p>';

		} else {

			$output .= '<div class="inspector-header"><h2>Results</h2><a class="button clear-results" href="" data-status="info">Clear Results</a></div>';

			$output .= '<div id="inspection-results" class="inspection-results">';

			foreach( $inspection_results as $variable ) {

				$inspection_time = date( 'H:i:s', strtotime( $variable['date'] ) );
				$variable_name = '$' . $variable['name'];
				$variable_type = gettype( maybe_unserialize( $variable['content'] ) );
				$variable_content = $variable['content'];
				$origin_script_path = $variable['file_path'];
				$origin_script_line = $variable['line_number'];

				if ( ( $variable_type == 'object' ) || ( $variable_type == 'array' ) ) {

					$type_tag = '<span class="variable-type">' . esc_html( $variable_type ) . '</span>';

				} else {

					$type_tag = '';

				}

				if ( !empty( $origin_script_path ) ) {

					if ( !empty( $origin_script_line ) ) {

						$origin_script = $origin_script_path . ':' . $origin_script_line;

					} else {

						$origin_script = $origin_script_path;

					}

				}

				$output .= '<div class="inspection-result">';

				$output .= '<div class="inspection-time">' . esc_html( $inspection_time ) . '</div>';

				$output .= '<div class="accordion inspection-accordion">';
				
				$output .= '<div class="accordion__control">' . esc_html( $variable_name ) . $type_tag . '<span class="accordion__indicator"></span></div>';

				$output .= '<div class="accordion__panel"><pre>' . print_r( maybe_unserialize( $variable_content ), true ) . '</pre></div>';

				if ( !empty( $origin_script_path ) ) {

					$output .= '<div class="inspection-origin">' . esc_html( $origin_script ) .  '</div>';

				}

				$output .='</div>';

				$output .='</div>';

			}

			$output .='</div>';

		}

		return $output;
	
	}

	/**
	 * Add the main page in wp-admin
	 *
	 * @since 1.0.0
	 */
	public function vi_main_page() {

		if ( class_exists( 'CSF' ) ) {

			// Set a unique slug-like ID

			$prefix = 'variable-inspector';

			CSF::createOptions ( $prefix, array(

				'menu_title' 		=> 'Variable Inspector',
				'menu_slug' 		=> 'variable-inspector',
				'menu_type'			=> 'submenu',
				'menu_parent'		=> 'tools.php',
				'menu_position'		=> 1,
				'framework_title' 	=> 'Variable Inspector <small>by <a href="https://bowo.io" target="_blank">bowo.io</a></small>',
				'framework_class' 	=> 'vi',
				'show_bar_menu' 	=> false,
				'show_search' 		=> false,
				'show_reset_all' 	=> false,
				'show_reset_section' => false,
				'show_form_warning' => false,
				'sticky_header'		=> true,
				'save_defaults'		=> true,
				'show_footer' 		=> false,
				'footer_credit'		=> '<a href="https://wordpress.org/plugins/variable-inspector/" target="_blank">Variable Inspector</a> (<a href="https://github.com/qriouslad/variable-inspector" target="_blank">github</a>) is built with the <a href="https://github.com/devinvinson/WordPress-Plugin-Boilerplate/" target="_blank">WordPress Plugin Boilerplate</a>, <a href="https://wppb.me" target="_blank">wppb.me</a> and <a href="https://github.com/Codestar/codestar-framework" target="_blank">CodeStar</a>.',

			) );

			CSF::createSection( $prefix, array(

				'title'		=> 'The Inspector',
				'fields'	=> array(

					array(
						'type'		=> 'content',
						'title'		=> '',
						'class'		=> 'vi-body',
						'content'	=> $this->vi_inspection_results(),
					),

				),

			) );

		}

	}

	/**
	 * Add "Access Now" plugin action link
	 *
	 * @since 1.0.0
	 */
	public function vi_plugin_action_links( $links ) {

		$action_link = '<a href="tools.php?page=' . $this->plugin_name . '">Access Now</a>';

		array_unshift( $links, $action_link );

		return $links;

	}

	/**
	 * Register a submenu directly with WP core function
	 *
	 * @since 1.0.0
	 */
	public function vi_register_submenu() {

		add_submenu_page(
			'tools.php',
			'Variable Inspector',
			'Variable Inspector',
			'manage_options',
			'variable-inspector',
			'vi_register_submenu_callback'
		);
	}

	/**
	 * Skeleton callback function for submenu registration
	 *
	 * @since 1.0.0
	 */
	public function vi_register_submenu_callback() {

		echo 'Nothing to show here...';

	}

	/**
	 * Remove CodeStar framework welcome / ads page
	 *
	 * @since 1.0.0
	 */
	public function vi_remove_codestar_submenu() {

		remove_submenu_page( 'tools.php', 'csf-welcome' );

	}

}
