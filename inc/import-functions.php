<?php

function gp_convert_timestamp($timestamp) {
	$dateTimeFormat = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
	return wp_date( $dateTimeFormat, $timestamp );
}

function gp_get_date_time ($value) {
    $processor = new WP_HTML_Tag_Processor( $value );
    if ( $processor->next_tag( 'time' ) ) {
        $datetime = $processor->get_attribute( 'datetime' );
        $value = $datetime;
    }
    return $value;
}



function gp_fix_post_meta($value, $post_id, $key) {
    
    // Only check 'organization_specialty_bearing'.
    if ($key == 'organization_specialty_bearing') {

        // Check if it has the right value.
        if ($value == 'Ikke-specialebærende selskab') {
			
            $value = null;

        }
    }
	
	// Only check 'person_is_phone_public'.
    if ($key == 'person_is_phone_public') {

        // Check if it has the right value.
        if ($value == 'Nej') {
			
            $value = null;

        }
    }
	
	// Only check 'person_is_email_public'.
    if ($key == 'person_is_email_public') {

        // Check if it has the right value.
        if ($value == 'Nej') {
			
            $value = null;

        }
    }
	// Only check 'person_address'.
    if ($key == 'person_address') {
        $value = wp_strip_all_tags($value);

    }
    // Only check event_start_string.
    if ($key == 'event_start_string') {
        $value = gp_get_date_time($value);
    }

    // Only check event_end_string.
    if ($key == 'event_end_string') {
        $value = gp_get_date_time($value);
    }
    // Only check event_start_date.
    if ($key == 'event_start_date') {
        $value = wp_strip_all_tags($value);
        $value = wp_date( get_option( 'date_format' ), $value );
    }

    // Only check event_end_date.
    if ($key == 'event_end_date') {
        $value = wp_strip_all_tags($value);
        $value = wp_date( get_option( 'date_format' ), $value );

    }

    // Only check event_start_time.
    if ($key == 'event_start_time') {
        $value = wp_strip_all_tags($value);
        $value = wp_date( get_option( 'time_format' ), $value );
    }
    
    
    // Only check event_end_time.
    if ($key == 'event_end_time') {
        $value = wp_strip_all_tags($value);
        $value = wp_date( get_option( 'time_format' ), $value );
    }

    return $value;

}
add_filter('pmxi_custom_field', 'gp_fix_post_meta', 10, 3);


function gp_get_url_by_image_id ($image_id, $post_type = 'image') {
    if(!$image_id) {
        return false;
    }

    $args = array(
        'meta_key' => 'image_id',
        'meta_value' => $image_id,
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);

    $post = $posts[0];

    $postID = $post->ID;
    $thumbnail_id = get_post_thumbnail_id($postID);
    $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full', 'string');
    $thumbnail_url = $thumbnail_src[0];
    return $thumbnail_url;
}

function gp_get_attachment_type_test () {
    $media_id = 947;
    $media_url = gp_get_url_by_image_id($media_id);
    var_dump($media_url);
}
// add_action('wp_head', 'gp_get_attachment_type_test');

function gp_get_attachment_type ($uuid) {

    $args = array(
        'meta_key' => 'image_uuid',
        'meta_value' => $uuid,
        'post_type' => array('video', 'vector', 'image', 'audio', 'embed', 'document'),
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);

    $post = $posts[0];

    $postID = $post->ID;
    $attachment_type = get_post_type($postID);
    return $attachment_type;
}

function gp_get_media_id ($uuid) {

    $args = array(
        'meta_key' => 'image_uuid',
        'meta_value' => $uuid,
        'post_type' => array('video', 'vector', 'image', 'audio', 'embed', 'document'),
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);

    $post = $posts[0];

    $postID = $post->ID;
    return $postID;
}

function gp_get_thumbnail_id ($uuid, $post_type = 'image') {

    $args = array(
        'meta_key' => 'image_uuid',
        'meta_value' => $uuid,
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);

    $post = $posts[0];

    $postID = $post->ID;
    $thumbnail_id = get_post_thumbnail_id($postID);
    return $thumbnail_id;
}

function gp_get_thumbnail_url ($uuid, $post_type = 'image') {

    $thumbnail_id = gp_get_thumbnail_id($uuid, $post_type);
    if(!$thumbnail_id) {
        return false;
    }
    $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full', 'string');
    $thumbnail_url = $thumbnail_src[0];
    return $thumbnail_url;
}

function gp_edit_media_attributes ($articleData) {
    $html = $articleData['post_content'];

    $processor = new WP_HTML_Tag_Processor( $html );

    while ( $processor->next_tag( [ 'tag_name' => 'drupal-media', 'tag_closers' => 'skip' ] ) ) {
        
        $image_caption = $processor->get_attribute('data-caption');
        $uuid = $processor->get_attribute('data-entity-uuid');
        if ( ! $uuid ) {
            continue;
        }
        $thumbnail_id = gp_get_thumbnail_id($uuid);
        $thumbnail_url = gp_get_thumbnail_url($uuid);
        if($thumbnail_url) {
            $processor->set_attribute( 'src',$thumbnail_url );
            // $processor->set_attribute( 'data-entity-type','image' );

        }
        if ($caption && $thumbnail_id) {
            wp_update_post( array(
                'ID'           => $thumbnail_id,
                'post_excerpt' => $image_caption,
            ) );
        }
        $attachment_type = gp_get_attachment_type($uuid);
        $processor->set_attribute( 'data-entity-type',$attachment_type );
        if ($attachment_type == 'embed') {
            $media_id = gp_get_media_id($uuid);
            if ($media_id) {
                $embed_url = get_post_meta($media_id, 'embed_url', true);
                $processor->set_attribute( 'src',$embed_url );
            }
        }
        if ($attachment_type == 'video') {
            $media_id = gp_get_media_id($uuid);
            if ($media_id) {
                $video_url = get_post_meta($media_id, 'video_url', true);
                $processor->set_attribute( 'src',$video_url );
            }
        }

    }
    $articleData['post_content'] = $processor->get_updated_html();
    return $articleData;
}
add_filter('pmxi_article_data', 'gp_edit_media_attributes', 10, 1);

function gp_add_attachment_data($postID) {
    $thumbnail_id = get_post_thumbnail_id($postID);
    if(!$thumbnail_id) {
        $media = get_attached_media( '', $postID );
        foreach($media as $attachment) {
            $thumbnail_id = $attachment->ID;
        }    
    }
    if ($thumbnail_id) {
        $image_copyright = get_post_meta($postID, 'image_copyright', true);
        if ($image_copyright) {
            update_post_meta($thumbnail_id, 'media_credit', $image_copyright);
        }
        $image_id = get_post_meta($postID, 'image_id', true);
        if ($image_id) {
            update_post_meta($thumbnail_id, 'media_id', $image_id);
        }
        $image_uuid = get_post_meta($postID, 'image_uuid', true);
        if ($image_uuid) {
            update_post_meta($thumbnail_id, 'media_uuid', $image_uuid);
        }
        $image_category = get_post_meta($postID, 'image_category', true);
        if ($image_category) {
            wp_set_post_terms( $thumbnail_id, $image_category, 'media_category' );
        }
        $document_name = get_post_meta($postID, 'document_name', true);
        $document_description = get_post_meta($postID, 'document_description', true);
        if ($document_description || $document_name ) {
            $attachment = array(
                'ID'           => $thumbnail_id,
                'post_title'   => $document_name,
                'post_content' => $document_description,
            );
            // Update the post into the database
            wp_update_post( $attachment );
        }

    }
}
add_action('pmxi_saved_post', 'gp_add_attachment_data', 10, 1);


function gp_add_links_to_content($articleData, $import, $post_to_update, $current_xml_node) {
	// Grab the content
	$content = $articleData['post_content'];
    // Turn the XML node into an array.
    $xml_data = json_decode( json_encode( (array) $current_xml_node ), 1 );
	// Grab the links
	$links = $xml_data['links'];
	if($links) {
        $html = gp_get_links_html ($links);
		$articleData['post_content'] = $content . $html;
	}
	return $articleData;
}
add_filter('pmxi_article_data', 'gp_add_links_to_content', 10, 4);

function gp_get_links_html ($links) {
    $html = '';
	// Convert comma separated list to array.
	$links = explode(",",$links);
    if($links) {

		// Process each link.	
		foreach($links as $link) {
			
			$link = explode(";",$link);

            if($link[0]) {
                $html .= '<!-- wp:list-item --><li><a href="' . $link[1] . '">' . $link[0] . '</a></li><!-- /wp:list-item -->';
            }
		}
        if($html) {
            $html = '<!-- wp:list --><ul>' . $html . '</ul><!-- /wp:list -->';
            $html = '<!-- wp:heading --><h2 class="wp-block-heading">Links</h2><!-- /wp:heading -->' . $html;
            $html = '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="links wp-block-group">' . $html . '</div><!-- /wp:group -->';
        }
    }
    return $html;
}


function gp_add_documents_to_content($articleData, $import, $post_to_update, $current_xml_node) {
	// Grab the content
	$content = $articleData['post_content'];
    // Turn the XML node into an array.
    $xml_data = json_decode( json_encode( (array) $current_xml_node ), 1 );
	// Grab the links
	$dokumenter = $xml_data['dokumenter'];
	if($dokumenter) {
		$html = gp_get_document_html ($dokumenter);
		$articleData['post_content'] = $content . $html;
	}
	return $articleData;
}
add_filter('pmxi_article_data', 'gp_add_documents_to_content', 20, 4);

function gp_get_document_html ($dokumenter) {
    $html = '';
    $dokumenter = explode(",",$dokumenter);
    if($dokumenter) {
        foreach($dokumenter as $dokument) {
            $dokument_url = gp_get_document_thumbnail_url($dokument);
            $dokument_title = gp_get_document_thumbnail_title($dokument);
            $html .= '<!-- wp:list-item --><li><a href="' . $dokument_url . '">' . $dokument_title . '</a></li><!-- /wp:list-item -->';
        }
        $html = '<!-- wp:list --><ul>' . $html . '</ul><!-- /wp:list -->';
        $html = '<!-- wp:heading --><h2 class="wp-block-heading">Materialer</h2><!-- /wp:heading -->' . $html;
        $html = '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="documents wp-block-group">' . $html . '</div><!-- /wp:group -->';


    }
    return $html;
}

function gp_get_document_thumbnail_url ($image_id, $post_type = 'document') {
    $thumbnail_id = gp_get_document_thumbnail_id($image_id, $post_type);
    // $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full', 'string');
    // $thumbnail_url = $thumbnail_src[0];
    $thumbnail_url = wp_get_attachment_url($thumbnail_id);

    return $thumbnail_url;
}

function gp_get_document_thumbnail_title ($image_id, $post_type = 'document') {
    $thumbnail_id = gp_get_document_thumbnail_id($image_id, $post_type);
    $attachment_title = get_the_title($thumbnail_id);
    return $attachment_title;
}

function gp_get_document_thumbnail_id ($image_id, $post_type = 'document') {

    $args = array(
        'meta_key' => 'image_id',
        'meta_value' => $image_id,
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);

    $post = $posts[0];

    $postID = $post->ID;

    $media = get_attached_media( '', $postID );
    foreach($media as $attachment) {
        $thumbnail_id = $attachment->ID;
    }

    return $thumbnail_id;
}

function gp_rest_after_insert_after_import( $post_id, $xml, $is_update ) {
	$post = get_post($post_id);
	$post_type = get_post_type($post_id);
	if ( $post_type == 'person' ) {
 		gp_set_associated_organization_status($post);
	}
}
add_action('pmxi_saved_post', 'gp_rest_after_insert_after_import', 10, 3);


