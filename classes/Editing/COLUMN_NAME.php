<?php

namespace CUSTOM_NAMESPACE\Editing;

use ACP\Editing;

/**
 * Editing class. Adds editing functionality to the column.
 */
class COLUMN_NAME implements Editing\Service {

	public function get_value( int $id ) {
		// Retrieve the value for editing
		// For example: get_post_meta( $id, '_my_custom_field_example', true );
	}

	public function get_view( string $context ): ?Editing\View {
		// Available views: text, textarea, media, float, togglable, select, ajaxselect
		$view = new Editing\View\Text();

		// (Optional) use View specific modifiers
		//$view->set_clear_button( true );
		//$view->set_placeholder( 'Custom placeholder' );
		//$view->set_required( true );

		// (Optional) return a different view or disable editin based on context: bulk or single (index)
		// $context === Service::CONTEXT_BULK

		return $view;
	}

	/**
	 * Saves the value after using inline-edit
	 *
	 * @param int   $id   Object ID
	 * @param mixed $data Value to be saved
	 */
	public function update( int $id, $data ): void {
		// Store the value that has been entered with inline-edit
		// For example: update_post_meta( $id, '_my_custom_field_example', $value );
	}

}