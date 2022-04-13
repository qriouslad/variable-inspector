<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Variable_Inspector
 * @subpackage Variable_Inspector/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Variable_Inspector
 * @subpackage Variable_Inspector/includes
 * @author     Bowo <hello@bowo.io>
 */
class Variable_Inspector_Deactivator {

	/**
	 * Things to do upon plugin deactivation
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

        // Drop/delete database table

        global $wpdb;

        $table = $wpdb->prefix . 'variable_inspector';

        $sql = "DROP TABLE IF EXISTS {$table};";

        $wpdb->query( $sql );

	}

}
