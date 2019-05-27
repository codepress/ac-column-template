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
		return new Sorting( $this );
	}

	public function export() {
		return new Export( $this );
	}

	// Advanced
	// Filtering
	public function filtering() {
		return new Filtering( $this );
	}

	// Advanced
	// Smart Filtering / Search
	public function search() {
		return new SmartFiltering();
	}

}