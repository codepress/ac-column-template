<?php

namespace CUSTOM_NAMESPACE\Column\Pro;

use ACP;
use CUSTOM_NAMESPACE;

// In this example we extend the free version, but if you only want a pro version, there is no need to write a separate free column
class COLUMN_NAME extends CUSTOM_NAMESPACE\Column\Free\COLUMN_NAME
	implements ACP\Editing\Editable, ACP\Sorting\Sortable, ACP\Filtering\Filterable, ACP\Export\Exportable, ACP\Search\Searchable {

	public function editing() {
		return new CUSTOM_NAMESPACE\Editing\COLUMN_NAME( $this );
	}

	public function sorting() {

		// Example #1 - Sort any value
		return new CUSTOM_NAMESPACE\Sorting\COLUMN_NAME( $this );

		// The following examples are recommended for large datasets. They are optimised queries and much faster.

		// Example #2 - Sorting by custom field values on the posts table
		// return new \ACP\Sorting\Model\Post\Meta( 'my_custom_meta_key' );

		// Example #3 - Sorting by numeric custom field values on the users table
		// return new \ACP\Sorting\Model\User\Meta( 'my_custom_meta_key', new \ACP\Sorting\Type\DataType( 'numeric' ) );

		// Example #4 - Sorting by custom field values on the posts table with custom formatting applied.
		// In this example we want to sort by the Post `Title`, not the Post `ID` that is stored within the custom field.
		// We will convert each Post `ID` to a Post `Title` before we apply sorting.
		// return new \ACP\Sorting\Model\Post\MetaFormat( new \ACP\Sorting\FormatValue\PostTitle(), 'my_custom_meta_key' );

		// Within this directory you will find all available sorting models: `admin-columns-pro/classes/Sorting/Model`.
	}

	public function export() {
		return new CUSTOM_NAMESPACE\Export\COLUMN_NAME( $this );
	}

	public function filtering() {
		return new CUSTOM_NAMESPACE\Filtering\COLUMN_NAME( $this );
	}

	// Smart Filtering (internally named: Search)
	public function search() {
		return new CUSTOM_NAMESPACE\SmartFiltering\COLUMN_NAME();
	}

}