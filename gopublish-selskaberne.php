<?php
/**
 * Plugin Name:       Go:Publish Selskaberne
 * Plugin URI:        https://github.com/Retrofitterdk/gopublish-selskaberne
 * Description:       COLUMN_LABEL column for Admin Columns Pro
 * Version:           0.1.0
 * Requires at least: 6.1
 * Requires PHP:      7.2
 * Requires Plugins:  shadow-terms
 * Version:           0.1.0
 * Author:            Retrofitter
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gopublish-selskaberne
 * Domain Path:       /languages
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
* Load plugin textdomain.
*
* @since 0.1.0
*/

if ( ! function_exists( 'gp_selskaberne_load_textdomain' ) ) {
	function gp_selskaberne_load_textdomain() {
		load_plugin_textdomain( 'gopublish-selskaberne', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
}
add_action( 'plugins_loaded', 'gp_selskaberne_load_textdomain' );

/**
* Loads files from the '/inc' folder.
*
* @since  0.1.0
* @access public
* @return void
*/

if ( ! function_exists( 'gp_selskaberne_loader' ) ) {

	function gp_selskaberne_loader() {
        require_once plugin_dir_path( __FILE__ ) . '/inc/import-functions.php';
        require_once plugin_dir_path( __FILE__ ) . '/inc/functions-posttypes.php';
	}
}
add_action( 'plugins_loaded', 'gp_selskaberne_loader' );

// Change default slugs for post types organization, person and collection
function gp_set_organization_slug () {
    return 'organisationer';
}
add_filter( 'organization_rewrite_slug', 'gp_set_organization_slug' );
add_filter( 'organization_archive_slug', 'gp_set_organization_slug' );

function gp_set_person_slug () {
    return 'personer';
}
add_filter( 'person_rewrite_slug', 'gp_set_person_slug' );
add_filter( 'person_archive_slug', 'gp_set_person_slug' );

function gp_set_collection_slug () {
    return 'temaer';
}
add_filter( 'collection_rewrite_slug', 'gp_set_collection_slug' );
add_filter( 'collection_archive_slug', 'gp_set_collection_slug' );

/**
 * Change labels for collection post type
 */

if ( ! function_exists( 'gp_selskaberne_change_collection_labels' ) ) {

    function gp_selskaberne_change_collection_labels( $args ) {

        $args['label'] = esc_html__( "Themes", "gopublish-selskaberne" );
        $args['labels']['name'] = esc_html__( "Theme", "gopublish-selskaberne" );
        $args['labels']['singular_name'] = esc_html__( "Themes", "gopublish-selskaberne" );
        $args['labels']['menu_name'] = esc_html__( "Themes", "gopublish-selskaberne" );
        $args['labels']['all_items'] = esc_html__( "All Themes", "gopublish-selskaberne" );
        $args['labels']['add_new'] = esc_html__( "Add new", "gopublish-selskaberne" );
        $args['labels']['add_new_item'] = esc_html__( "Add new Theme", "gopublish-selskaberne" );
        $args['labels']['edit_item'] = esc_html__( "Edit Theme", "gopublish-selskaberne" );
        $args['labels']['new_item'] = esc_html__( "New Theme", "gopublish-selskaberne" );
        $args['labels']['view_item'] = esc_html__( "View Theme", "gopublish-selskaberne" );
        $args['labels']['view_items'] = esc_html__( "View Themes", "gopublish-selskaberne" );
        $args['labels']['search_items'] = esc_html__( "Search Themes", "gopublish-selskaberne" );
        $args['labels']['not_found'] = esc_html__( "No Themes found", "gopublish-selskaberne" );
        $args['labels']['not_found_in_trash'] = esc_html__( "No Themes found in trash", "gopublish-selskaberne" );
        $args['labels']['parent'] = esc_html__( "Parent Theme", "gopublish-selskaberne" );
        $args['labels']['featured_image'] = esc_html__( "Featured image for this Theme", "gopublish-selskaberne" );
        $args['labels']['set_featured_image'] = esc_html__( "Set featured image for this Theme", "gopublish-selskaberne" );
        $args['labels']['remove_featured_image'] = esc_html__( "Remove featured image for this Theme", "gopublish-selskaberne" );
        $args['labels']['use_featured_image'] = esc_html__( "Use as featured image for this Theme", "gopublish-selskaberne" );
        $args['labels']['archives'] = esc_html__( "Theme archives", "gopublish-selskaberne" );
        $args['labels']['insert_into_item'] = esc_html__( "Insert into Theme", "gopublish-selskaberne" );
        $args['labels']['uploaded_to_this_item'] = esc_html__( "Upload to this Theme", "gopublish-selskaberne" );
        $args['labels']['filter_items_list'] = esc_html__( "Filter Themes list", "gopublish-selskaberne" );
        $args['labels']['items_list_navigation'] = esc_html__( "Themes list navigation", "gopublish-selskaberne" );
        $args['labels']['items_list'] = esc_html__( "Themes list", "gopublish-selskaberne" );
        $args['labels']['attributes'] = esc_html__( "Themes attributes", "gopublish-selskaberne" );
        $args['labels']['name_admin_bar'] = esc_html__( "Theme", "gopublish-selskaberne" );
        $args['labels']['item_published'] = esc_html__( "Theme published", "gopublish-selskaberne" );
        $args['labels']['item_published_privately'] = esc_html__( "Theme published privately", "gopublish-selskaberne" );
        $args['labels']['item_reverted_to_draft'] = esc_html__( "Theme reverted to draft", "gopublish-selskaberne" );
        $args['labels']['item_trashed'] = esc_html__( "Theme trashed", "gopublish-selskaberne" );
        $args['labels']['item_scheduled'] = esc_html__( "Theme scheduled", "gopublish-selskaberne" );
        $args['labels']['item_updated'] = esc_html__( "Theme updated", "gopublish-selskaberne" );
        $args['labels']['parent_item_colon'] = esc_html__( "Parent Theme:", "gopublish-selskaberne" );

        return $args;
    }
}
add_filter( 'register_collection_post_type_args', 'gp_selskaberne_change_collection_labels' );



// Get IDs of associated organizations
function gp_get_associated_organization_ids($postID) {

    $associatedPostIds = array();
    // Get organization terms of post
	$terms = get_the_terms($postID,'organization_connect');
    // Get IDs of posts associated with organization terms
		if ($terms) {
    		foreach($terms as $term){
	    		$termID = ($term->term_id);
		    	$associatedPostIds[] = ShadowTerms\API\get_post_id($termID);
		    }
	    }
    return $associatedPostIds;
}

// Get specialty bearing status of associated organizations
function gp_get_associated_organization_status($postID) {
    $specialty_bearing = array();
    // Get IDs of associated organizations
    $associatedPostIds = gp_get_associated_organization_ids($postID);
    // Create array of bearing status of associated organizations
    foreach($associatedPostIds as $id){
        $specialty_bearing[] = (bool) get_post_meta( $id, 'organization_specialty_bearing', true );
    }
    // Return true if any associated organization has specialty bearing status
    if (in_array(true, $specialty_bearing)) {
        return true;
    } else {
        return false;
    }
}

// Set specialty bearing status of person
function gp_set_associated_organization_status($post) {
    $postID = $post->ID;
    // Get specialty bearing status of associated organizations
    $specialty_bearing = gp_get_associated_organization_status($postID);
    // Set post meta for specialty bearing status of person
    update_post_meta($postID, 'person_specialty_bearing', $specialty_bearing);
}
add_action( 'rest_after_insert_person', 'gp_set_associated_organization_status', 100, 1 );

// set specialty bearing status of person after updating associated organizations
function gp_after_organization_update($post) {
    // Get post ID of organization
    $postID = $post->ID;
  
    // Get term ID of organization
    $termID = ShadowTerms\API\get_term_id($postID);

    // Get IDs of associated persons
    $args = array(
        'fields' => 'ids',
        'post_type' => 'person',
        'post_status' => 'publish',
        'numberposts' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'organization_connect',
                'field' => 'term_id',
                'terms' => $termID,
            ),
        ),
    );
    $associatedPostIds = get_posts( $args );

    if ($associatedPostIds) {
        foreach($associatedPostIds as $postID){
            // Set specialty bearing status of person
            gp_set_associated_organization_status(get_post($postID));
        }
    }
}
add_action( 'rest_after_insert_organization', 'gp_after_organization_update', 100, 1 );