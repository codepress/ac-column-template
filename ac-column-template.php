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

const AC_CT_FILE = __FILE__;

// 1. Set text domain
/* @link https://codex.wordpress.org/Function_Reference/load_plugin_textdomain */
load_plugin_textdomain('ac-column-template', false, __DIR__ . '/languages/');

// 2. Register column type
add_action('acp/column_types', static function (AC\ListScreen $list_screen): void {
    // Load all necessary files
    require_once __DIR__ . '/classes/Column/Column.php';
    require_once __DIR__ . '/classes/Column/Editing.php';
    require_once __DIR__ . '/classes/Column/Export.php';
    require_once __DIR__ . '/classes/Column/Search.php';
    require_once __DIR__ . '/classes/Column/Sorting.php';

    // Make your custom column available to a specific WordPress list table:

    // Example #1 - for the custom post type 'page'
    if ('page' === $list_screen->get_key()) {
        // Register column
        $list_screen->register_column_type(
            new AcColumnTemplate\Column\Column()
        );
    }

    // Example #2 - for media
    // if ( 'attachment' === $list_screen->get_key() ) {
    // Register column
    // }

    // Example #3 - for all post types
    // if ( AC\MetaType::POST === $list_screen->get_meta_type() ) {
    // Register column
    // }

    // Example #4 - for users
    // if ( AC\MetaType::USER === $list_screen->get_meta_type() ) {
    // Register column
    // }

    // Example #4 - for categories on the taxonomy list table
    // if ( $list_screen instanceof ACP\ListScreen\Taxonomy && 'category' === $list_screen->get_taxonomy()) {
    // Register column
    // }

});
