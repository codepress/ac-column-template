<?php

/**
 * --------------------------------------------
 * This column is for the PRO version only.
 * This adds editing and sorting to the column.
 * --------------------------------------------
 */
class ACP_Column_COLUMN_NAME extends AC_Column_COLUMN_NAME
	implements \ACP\Editing\Editable, \ACP\Sorting\Sortable, \ACP\Export\Exportable {

	public function editing() {
		return new ACP_Editing_Model_COLUMN_NAME( $this );
	}

	public function sorting() {
		return new ACP_Sorting_Model_COLUMN_NAME( $this );
	}

	public function export() {
		return new ACP_Export_Model_COLUMN_NAME( $this );
	}

}

/**
 * Editing class. Adds editing functionality to the column.
 */
class ACP_Editing_Model_COLUMN_NAME extends \ACP\Editing\Model {

	/**
	 * Editing view settings
	 *
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
	 *
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