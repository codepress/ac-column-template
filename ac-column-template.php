<?php
/**
 * Plugin Name: Admin Columns - COLUMN_LABEL
 * Plugin URI: https://admincolumns.com
 * Description: COLUMN_LABEL column for Admin Columns Pro
 * Version: 1.0
 * Requires PHP: 7.2
 */

const AC_CT_FILE = __FILE__;

add_action(
    'acp/v2/column_types',
    static function ($factories, AC\TableScreen $table_screen) {
        // Require the necessary files for the column or use an autoloader instead
        require_once __DIR__ . '/classes/Column/Column.php';
        require_once __DIR__ . '/classes/Column/Editing.php';
        require_once __DIR__ . '/classes/Column/Export.php';

        // Example #1 - for the custom post type 'post'
        if ((string)$table_screen->get_id() === 'post') {
            $factories[] = AcColumnTemplate\Column\Column::class;
        }

        // Example #2 - for the custom post type 'post'
        //    if ((string)$table_screen->get_key() === 'attachment') {
        //        //Register Column Factory
        //    }

        // Example #3 - for the custom post type 'post'
        //    if ($table_screen instanceof AC\PostType) {
        //        // Register Column Factory
        //    }

        // Example #4 - for users
        //    if ( ! $table_screen instanceof AC\TableScreen\User) {
        //        // Register Column Factory
        //    }

        return $factories;
    },
    10,
    2
);
