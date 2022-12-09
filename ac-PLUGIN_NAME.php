<?php
/*
Plugin Name:    Admin Columns - PLUGIN_NAME
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
load_plugin_textdomain( 'ac-CUSTOM_NAMESPACE', false, plugin_dir_path( __FILE__ ) . '/languages/' );

add_action( 'ac/ready', function () {

	// Use the hook below if you only want a free column
	add_action( 'ac/column_types', function ( \AC\ListScreen $list_screen ) {
		require_once( __DIR__ . '/classes/Column/Free/COLUMN_NAME.php' );

		// For more example, see the implementation for the pro column below

		if ( 'page' === $list_screen->get_key() ) {
			// Register a column for the Free version WITHOUT pro features
			$list_screen->register_column_type( new \CUSTOM_NAMESPACE\Column\Free\COLUMN_NAME() );
		}
	} );

	// Register the pro column that extends the free column
	add_action( 'acp/column_types', function ( \AC\ListScreen $list_screen ) {
		// Load all necessary classes or use an autoloader
		require_once( __DIR__ . '/classes/Column/Free/COLUMN_NAME.php' );
		require_once( __DIR__ . '/classes/Column/Pro/COLUMN_NAME.php' );
		require_once( __DIR__ . '/classes/Editing/COLUMN_NAME.php' );
		require_once( __DIR__ . '/classes/Export/COLUMN_NAME.php' );
		require_once( __DIR__ . '/classes/Filtering/COLUMN_NAME.php' );
		require_once( __DIR__ . '/classes/SmartFiltering/COLUMN_NAME.php' );
		require_once( __DIR__ . '/classes/Sorting/COLUMN_NAME.php' );

		// Make your custom column available to a specific WordPress list table:

		// Example #1 - for the custom post type 'page'
		if ( 'page' === $list_screen->get_key() ) {
			// Register column

			// Register a column WITHOUT pro features
			//$list_screen->register_column_type( new \CUSTOM_NAMESPACE\Column\Free\COLUMN_NAME() );

			// Register a column WITH pro features
			$list_screen->register_column_type( new \CUSTOM_NAMESPACE\Column\Pro\COLUMN_NAME() );
		}

		// Example #2 - for media
		// if ( 'attachment' === $list_screen->get_key() ) {
		// Register column
		// }

		// Example #3 - for all post types
		// if ( \AC\MetaType::POST === $list_screen->get_meta_type() ) {
		// Register column
		// }

		// Example #4 - for users
		// if ( \AC\MetaType::USER === $list_screen->get_meta_type() ) {
		// Register column
		// }

		// Example #4 - for categories on the taxonomy list table
		// if ( $list_screen instanceof \ACP\ListScreen\Taxonomy && 'category' === $list_screen->get_taxonomy()) {
		// Register column
		// }

	} );

} );
