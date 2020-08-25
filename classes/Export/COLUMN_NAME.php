<?php

namespace CUSTOM_NAMESPACE\Export;

/**
 * Export class. Adds export functionality to the column.
 */
class COLUMN_NAME extends \ACP\Export\Model {

	public function get_value( $id ) {

		// Start editing here.

		// Add the value you would like to be exported.
		// For example: $value = get_post_meta( $id, '_my_custom_field_example', true );

		$value = $this->column->get_raw_value( $id );

		// Stop editing.

		return $value;
	}

}