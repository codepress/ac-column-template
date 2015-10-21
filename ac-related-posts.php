<?php

/*
Plugin Name: Admin Columns - Related Posts
Plugin URI: http://www.admincolumns.com
Description: Column for the Related Posts for WP plugin
Version: 1.0
Author: Tobias Schutter
Author URI: http://www.codepress.nl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// 1. Set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'ac-column-related-posts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// 2. Set the type of column.
// Use the type: 'post', 'user', 'comment', 'media' or 'taxonomy'.
add_filter( 'cac/columns/custom/type=post', 'cac_register_column_related_posts' );

// 3. Register the column.
function cac_register_column_related_posts( $columns ) {

    // Class name and absolute filepath of the new column
    $columns['CPAC_Column_Related_Posts'] = plugin_dir_path( __FILE__ ) . 'ac-column-related-posts.php';

    return $columns;
}