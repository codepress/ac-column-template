<?php

namespace AC\Custom\COLUMN_NAME;

use ACP\Editing\Editable;
use ACP\Export\Exportable;
use ACP\Filtering\Filterable;
use ACP\Search\Searchable;
use ACP\Sorting\Sortable;

class ColumnPro extends ColumnFree
	implements Editable, Sortable, Filterable, Exportable, Searchable {

	public function editing() {
		return new Editing( $this );
	}

	public function sorting() {

		// Example #1 - Sort any value
		return new Sorting( $this );

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
		return new Export( $this );
	}

	public function filtering() {
		return new Filtering( $this );
	}

	// Smart Filtering (internally named: Search)
	public function search() {
		return new SmartFiltering();
	}

}