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
    if ('person' === $list_screen->get_key()) {
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
load_plugin_textdomain('gopublish-selskaberne', false, __DIR__ . '/languages/');

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