<?php
/**
 * Plugin Name: Admin Columns - COLUMN_LABEL
 * Plugin URI: https://admincolumns.com
 * Description: COLUMN_LABEL column for Admin Columns Pro
 * Version: 1.0
 * Requires PHP: 7.2
 */

const AC_CT_FILE = __FILE__;

add_filter(
    'ac/column/types/pro',
    static function ($factories, AC\TableScreen $table_screen) {
        // Require the necessary files for the column or use an autoloader insteead
        require_once __DIR__ . '/classes/Column/Column.php';
        require_once __DIR__ . '/classes/Column/Editing.php';
        require_once __DIR__ . '/classes/Column/Export.php';
        require_once __DIR__ . '/classes/Column/Sorting.php';
        require_once __DIR__ . '/classes/Column/Search.php';

        // Example #1 - for the custom post type 'post'
        if ((string)$table_screen->get_id() === 'post') {
            $factories[] = AcColumnTemplate\Column\Column::class;
        }

        // Example #2 - Check for different table screens based on instance
        switch (true) {
            case $table_screen instanceof AC\TableScreen\User:
            case $table_screen instanceof AC\TableScreen\Post:
            case $table_screen instanceof AC\TableScreen\Media:
            case $table_screen instanceof ACP\TableScreen\Taxonomy:
                // Register Column Factory
                break;
            default:
                break;
        }

        return $factories;
    },
    10,
    2
);
