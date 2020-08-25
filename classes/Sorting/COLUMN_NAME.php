<?php

namespace CUSTOM_NAMESPACE\Sorting;

/**
 * Sorting class. Adds sorting functionality to the column.
 */
class COLUMN_NAME extends \ACP\Sorting\Model {

	/**
	 * (Optional) Put all the sorting logic here. You can remove this function if you want to sort by raw value only.
	 * @return array
	 */
	public function get_sorting_vars() {
		$values = [];

		// Loops through all the available ID's for `post`, `user` or `comment`.
		foreach ( $this->strategy->get_results() as $id ) {

			// Start editing here.

			// Put all the column logic here to retrieve the value you need
			// For example: $value = get_post_meta( $id, '_my_custom_field_example', true );

			$value = $this->column->get_raw_value( $id );

			// Stop editing.

			$values[ $id ] = $value;
		}

		// Sorts the array and return all id's to the main query
		return [
			'ids' => $this->sort( $values ),
		];

	}

}