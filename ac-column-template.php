<?php
/**
 * Plugin Name: Admin Columns - COLUMN_LABEL
 * Plugin URI: https://admincolumns.com
 * Description: COLUMN_LABEL column for Admin Columns Pro
 * Version: 1.0
 * Requires PHP: 7.2
 */

const AC_CT_FILE = __FILE__;

// 1. Register column type
add_action('acp/column_types', static function (AC\ListScreen $list_screen): void {
    // Check for version requirement
    if (ACP()->get_version()->is_lte(new AC\Plugin\Version('6.3'))) {
        return;
    }

    // Load necessary files
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

// 2. Optionally: load a text domain
load_plugin_textdomain('ac-column-template', false, __DIR__ . '/languages/');
