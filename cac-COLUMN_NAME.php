<?php

/*
Plugin Name: Admin Columns: COLUMN_LABEL
Plugin URI: PLUGIN_URL
Description: DESCRIPTION
Version: 1.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// 1. Set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'cac-COLUMN_NAME', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// 2. Set the type of column.
// Use the type: 'post', 'user', 'comment', 'media' or 'taxonomy'.
add_filter( 'cac/columns/custom/type=post', 'register_column_COLUMN_NAME' );

// 3. Register the column.
function register_column_COLUMN_NAME( $columns ) {

    // Class name and absolute filepath of the new column
    $columns['CPAC_Column_COLUMN_NAME'] = plugin_dir_path( __FILE__ ) . '/cac-column-COLUMN_NAME.php';

    return $columns;
}