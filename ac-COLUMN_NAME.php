<?php

/*
Plugin Name: Admin Columns - COLUMN_LABEL
Plugin URI: PLUGIN_URL
Description: DESCRIPTION
Version: 1.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// 1. Set text domain
/* @link https://codex.wordpress.org/Function_Reference/load_plugin_textdomain */
load_plugin_textdomain( 'ac-COLUMN_NAME', false, plugin_dir_path( __FILE__ ) . '/languages/' );

// 2. Set the type of column.
// Use the type: 'post', 'user', 'comment', 'media' or 'taxonomy'.
add_action( 'ac/column_types/post', 'ac_register_column_COLUMN_NAME' );

// 3. Register the column.
function ac_register_column_COLUMN_NAME( AC_ListScreen $list_screen ) {

	require_once plugin_dir_path( __FILE__ ) . 'ac-column-COLUMN_NAME.php';

	$list_screen->register_column_type( new AC_Column_COLUMN_NAME );
}

// -------------------------------------- //
// This part is for the PRO version only. //
// -------------------------------------- //

// 4. (Optional) Set the type of PRO column.
// Use the type: 'post', 'user', 'comment', 'media' or 'taxonomy'.
add_action( 'acp/column_types/post', 'ac_register_pro_column_COLUMN_NAME' );

// 5. (Optional) Register the PRO column.
function ac_register_pro_column_COLUMN_NAME( AC_ListScreen $list_screen ) {

	require_once plugin_dir_path( __FILE__ ) . 'ac-column-COLUMN_NAME.php';
	require_once plugin_dir_path( __FILE__ ) . 'acp-column-COLUMN_NAME.php';

	$list_screen->register_column_type( new ACP_Column_COLUMN_NAME );
}