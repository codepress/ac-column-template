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

// 2. Register the column.
add_action( 'ac/column_types', 'ac_register_column_COLUMN_NAME' );

function ac_register_column_COLUMN_NAME( AC_ListScreen $list_screen ) {

	// Use the type: 'post', 'user', 'comment' or 'media'.
	if ( 'post' === $list_screen->get_group() ) {

		require_once plugin_dir_path( __FILE__ ) . 'ac-column-COLUMN_NAME.php';

		$list_screen->register_column_type( new AC_Column_COLUMN_NAME );
	}
}

// -------------------------------------- //
// This part is for the PRO version only. //
// -------------------------------------- //

// 3. (Optional) Register the PRO column.
add_action( 'ac/column_types', 'ac_register_pro_column_COLUMN_NAME' );

function ac_register_pro_column_COLUMN_NAME( AC_ListScreen $list_screen ) {
	if ( ! class_exists( 'ACP' ) ) {
		return;
	}

	// Use the type: 'post', 'user', 'comment', 'media' or 'taxonomy'.
	if ( 'post' === $list_screen->get_group() ) {

		require_once plugin_dir_path( __FILE__ ) . 'ac-column-COLUMN_NAME.php';
		require_once plugin_dir_path( __FILE__ ) . 'acp-column-COLUMN_NAME.php';

		$list_screen->register_column_type( new ACP_Column_COLUMN_NAME );
	}
}