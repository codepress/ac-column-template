<?php

/**
 * --------------------------------------------
 * This column is for the PRO version only.
 * This adds editing and sorting to the column.
 * --------------------------------------------
 */
class ACP_Column_COLUMN_NAME extends AC_Column_COLUMN_NAME
	implements \ACP\Editing\Editable, \ACP\Sorting\Sortable, \ACP\Export\Exportable, \ACP\Filtering\Filterable, \ACP\Search\Searchable {

	public function editing() {
		return new ACP_Editing_Model_COLUMN_NAME( $this );
	}

	public function sorting() {
		return new ACP_Sorting_Model_COLUMN_NAME( $this );
	}

	public function export() {
		return new ACP_Export_Model_COLUMN_NAME( $this );
	}

	// Advanced
	// Filtering
	public function filtering() {
		return new ACP_Filtering_Model_COLUMN_NAME( $this );
	}

	// Advanced
	// Smart Filtering / Search
	public function search() {
		return new ACP_Search_Model_COLUMN_NAME();
	}

}

/**
 * Editing class. Adds editing functionality to the column.
 */
class ACP_Editing_Model_COLUMN_NAME extends \ACP\Editing\Model {

	/**
	 * Editing view settings
	 * @return array Editable settings
	 */
	public function get_view_settings() {

		// available types: text, textarea, media, float, togglable, select, select2_dropdown and select2_tags
		$settings = array(
			'type' => 'text',
		);

		// (Optional) Only applies to type: togglable, select, select2_dropdown and select2_tags
		// $settings['options'] = array( 'value_1', 'value_2', 'etc.' );

		// (Optional) If a selector is provided, editable will be delegated to the specified targets
		// $settings['js']['selector'] = 'a.my-class';

		// (Optional) Only applies to the type 'select2_dropdown'. Populates the available select2 dropdown values through ajax.
		// Ajax callback used is 'get_editable_ajax_options()'.
		// $settings['ajax_populate'] = true;

		return $settings;
	}

	/**
	 * Saves the value after using inline-edit
	 *
	 * @param int   $id    Object ID
	 * @param mixed $value Value to be saved
	 */
	public function save( $id, $value ) {

		// Store the value that has been entered with inline-edit
		// For example: update_post_meta( $id, '_my_custom_field_example', $value );

	}

}

/**
 * Sorting class. Adds sorting functionality to the column.
 */
class ACP_Sorting_Model_COLUMN_NAME extends \ACP\Sorting\Model {

	/**
	 * (Optional) Put all the sorting logic here. You can remove this function if you want to sort by raw value only.
	 * @return array
	 */
	public function get_sorting_vars() {
		$values = array();

		// Loops through all the available post/user/comment id's
		foreach ( $this->strategy->get_results() as $id ) {

			// Start editing here.

			// Put all the column logic here to retrieve the value you need
			// For example: $value = get_post_meta( $id, '_my_custom_field_example', true );

			$value = $this->column->get_raw_value( $id );

			// Stop editing.

			$values[ $id ] = $value;
		}

		// Sorts the array and return all id's to the main query
		return array(
			'ids' => $this->sort( $values ),
		);

	}

}

/**
 * Export class. Adds export functionality to the column.
 */
class ACP_Export_Model_COLUMN_NAME extends \ACP\Export\Model {

	public function get_value( $id ) {

		// Start editing here.

		// Add the value you would like to be exported.
		// For example: $value = get_post_meta( $id, '_my_custom_field_example', true );

		$value = $this->column->get_raw_value( $id );

		// Stop editing.

		return $value;
	}

}

class ACP_Filtering_Model_COLUMN_NAME extends \ACP\Filtering\Model {

	public function get_filtering_data() {
		$data = array(
			'options' => array(
				'key' => 'Label',
			), // Key => Value pair for the available options in the drop down
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
		add_filter( 'posts_where', array( $this, 'filter_by_custom_query' ), 10, 2 );

		// Always return $vars, even when no filtering is done
		return $vars;
	}

	public function filter_by_custom_query( $where, WP_Query $query ) {
		global $wpdb;

		if ( $query->is_main_query() ) {
			$where .= ''; // Alter the Where clauses with SQL
		}

		return $where;
	}

}

class ACP_Search_Model_COLUMN_NAME extends \ACP\Search\Comparison {

	public function __construct() {
		$operators = new \ACP\Search\Operators( array(
			\ACP\Search\Operators::EQ, // EQ = equal, NEW = not Equal, CONTAINS, NOT_CONTAINS, GT = Greater than, LT = Less than, IS_EMPTY, NOT_IS_EMPTY, BETWEEN
		) );

		$value = \ACP\Search\Value::STRING; // DATE, INT, DECIMAL

		parent::__construct( $operators, $value );
	}

	protected function create_query_bindings( $operator, \ACP\Search\Value $value ) {
		$binding = new \ACP\Search\Query\Bindings\Post();

		// Example altering the meta_query
		$binding->meta_query( array(
			'key'     => 'acf_text',
			'value'   => 'aaa',
			'compare' => $operator,
		) );

		// Example for altering the where clause
		$binding->where( '1=1' );

		return $binding;
	}

}