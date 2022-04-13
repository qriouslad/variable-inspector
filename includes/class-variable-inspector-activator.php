<?php

/**
 * Fired during plugin activation
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Variable_Inspector
 * @subpackage Variable_Inspector/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Variable_Inspector
 * @subpackage Variable_Inspector/includes
 * @author     Bowo <hello@bowo.io>
 */
class Variable_Inspector_Activator {

	/**
	 * Things to do upon plugin activation
	 *
     * @link http://plugins.svn.wordpress.org/wp-data-logger/tags/2.0.2/class-wp-data-logger.php
	 * @since    1.0.0
	 */
	public static function activate() {

        // Create database table

        global $wpdb;

        $table = $wpdb->prefix . 'variable_inspector';

        $sql = 
        "CREATE TABLE {$table} (
            ID int(11) unsigned NOT NULL auto_increment,
            category varchar(255) NOT NULL default '',
            name varchar(255) NOT NULL default '',
            content longtext NULL default '',
            file_path varchar(255) NOT NULL default '',
            line_number varchar(11) NOT NULL default '',
            date datetime NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (ID)
        ) 
        DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate};";

        dbDelta( $sql );

        return true;

	}

}
