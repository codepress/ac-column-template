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


function gp_get_associated_organization_ids($postID) {

    $associatedPostIds = array();

	$terms = get_the_terms(get_the_ID(),'organization_connect');
		if ($terms) {
    		foreach($terms as $term){
	    		$termID = ($term->term_id);
		    	$associatedPostIds[] = ShadowTerms\API\get_post_id($termID);
            // $postID = ShadowTerms\API\get_post_id($termID);
            // $specialty_bearing[] = (bool) get_post_meta( $postID, 'organization_specialty_bearing', true );
		    }
        // if (in_array(true, $specialty_bearing)) {
		// 	return true;
		// } else {
		// 	return false;
		// }
	    }
    return $associatedPostIds;
}

function gp_the_associated_organizations($postID) {
    $specialty_bearing = array();
    $associatedPostIds = gp_get_associated_organization_ids($postID);
    foreach($associatedPostIds as $id){
        $specialty_bearing[] = (bool) get_post_meta( $id, 'organization_specialty_bearing', true );
    }
    if (in_array(true, $specialty_bearing)) {
        return true;
    } else {
        return false;
    }
    // return implode(",",$associatedPostIds);
    // return gp_get_associated_organization_ids($postID);
}
