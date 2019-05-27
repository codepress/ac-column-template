<?php
/*
Plugin Name:    Admin Columns - COLUMN_LABEL
Plugin URI:     PLUGIN_URL
Description:    DESCRIPTION
Version:        1.0
Author:         AUTHOR_NAME
Author URI:     AUTHOR_URL
License:        GPLv2 or later
License URI:    http://www.gnu.org/licenses/gpl-2.0.html
*/

// 1. Set text domain
/* @link https://codex.wordpress.org/Function_Reference/load_plugin_textdomain */
load_plugin_textdomain( 'ac-COLUMN_NAME', false, plugin_dir_path( __FILE__ ) . '/languages/' );

add_action( 'ac/ready', function () {
	\AC\Autoloader::instance()->register_prefix( 'AC\COLUMN_NAME', __DIR__ . '/classes/' );

	add_action( 'ac/column_types', function ( \AC\ListScreen $list_screen ) {

		// Use the type: 'post', 'user', 'comment' or 'media'.
		if ( 'post' === $list_screen->get_group() ) {
			// Load this one if you only want to load the column without pro features
			//$list_screen->register_column_type( new \AC\COLUMN_NAME\ColumnFree() );

			// Load this one if you wrote the column for Pro
			$list_screen->register_column_type( new \AC\COLUMN_NAME\ColumnPro() );
		}

	} );

} );
