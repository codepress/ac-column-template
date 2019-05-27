<?php
namespace AC\Custom\COLUMN_NAME;

class Filtering extends \ACP\Filtering\Model {

	public function get_filtering_data() {
		$data = array(
			'options' => array(
				'value' => 'Label',
			),
		);

		// (Optional) Order the options in the drop down menu
		// $data['order'] = true;

		// (Options) show empty options in the drop down.
		// 	$data['empty_option'] = true;

		return $data;
	}

	public function get_filtering_vars( $vars ) {
		// All actual filtering logic goes here, you'll need to alter the WP_Query.
		// $vars contains all WP_Query vars

		// Example of Meta Query filter
		$vars['meta_query'][] = array(
			'key'   => 'meta_key', // For Meta columns, you can use $column->get_meta_key()
			'value' => $this->get_filter_value(),
		);

		// Example of altering query
		// add_filter( 'posts_where', array( $this, 'filter_by_custom_query' ), 10, 2 );

		// Always return $vars, even when no filtering is done
		return $vars;
	}

	public function filter_by_custom_query( $where, \WP_Query $query ) {
		global $wpdb;

		if ( $query->is_main_query() ) {
			$where .= " AND {$wpdb->posts}.post_title = 'Something'"; // Alter the Where clauses with SQL
		}

		return $where;
	}

}