<?php
/**
 * Plugin Name: Admin Columns - COLUMN_LABEL
 * Plugin URI: https://admincolumns.com
 * Description: COLUMN_LABEL column for Admin Columns Pro
 * Version: 1.0
 * Requires PHP: 7.2
 */

const AC_CT_FILE = __FILE__;

add_filter('ac/column/types/pro', 'acp_my_custom_column', 10, 2);

function acp_my_custom_column(array $factories, AC\TableScreen $table_screen)
{
    // Require the necessary files for the column or use an autoloader instead
    require_once __DIR__ . '/classes/Column/Column.php';
    require_once __DIR__ . '/classes/Column/Editing.php';
    require_once __DIR__ . '/classes/Column/Export.php';
    require_once __DIR__ . '/classes/Column/Sorting.php';
    require_once __DIR__ . '/classes/Column/Search.php';

    // Example #1 - for any custom post type
    if ($table_screen instanceof AC\PostType) {
        $factories[] = AcColumnTemplate\Column\Column::class;
    }

    // Example #2 - for the custom post type 'page'
    if ('page' === (string)$table_screen->get_id()) {
        // Register Column Factory
    }

    // Example #3 - Check for different table screens based on instance type
    switch (true) {
        case $table_screen instanceof AC\TableScreen\Post:
        case $table_screen instanceof AC\TableScreen\User:
        case $table_screen instanceof AC\TableScreen\Media:
        case $table_screen instanceof ACP\TableScreen\Taxonomy:
            // Register Column Factory
            break;
    }

    return $factories;
}