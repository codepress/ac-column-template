<?php

namespace CUSTOM_NAMESPACE\Sorting;

use AC;
use ACP\Sorting;
use ACP\Sorting\Type\DataType;

/**
 * Sorting class. Adds sorting functionality to the column.
 */
class COLUMN_NAME extends Sorting\AbstractModel {

	/**
	 * @var AC\Column
	 */
	private $column;

	public function __construct( AC\Column $column ) {
		parent::__construct( new DataType( DataType::STRING ) );

		$this->column = $column;
	}

	/**
	 * (Optional) Put all the sorting logic here. You can remove this function if you want to sort by raw value only.
	 * @return array
	 */
	public function get_sorting_vars() {
		$array = [];

		// Loops through all the available ID's for `post`, `user` or `comment`.
		foreach ( $this->strategy->get_results() as $id ) {

			// Start editing here.

			// Put all the column logic here to retrieve the value you need
			// For example: $value = get_post_meta( $id, '_my_custom_field_example', true );

			$value = $this->column->get_value( $id );

			// Stop editing.

			$array[ $id ] = $value;
		}

		$ids = ( new Sorting\Sorter() )->sort( $array, $this->data_type );

		if( $this->get_order() === 'DESC' ){
			$ids = array_reverse( $ids );
		}

		// Sorts the array and return all id's to the main query
		return [
			'ids' => $ids,
		];

	}

}