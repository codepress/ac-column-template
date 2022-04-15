<?php

namespace CUSTOM_NAMESPACE\Column\Free;

class COLUMN_NAME extends \AC\Column {

	public function __construct() {

		// Identifier, pick an unique name. Single word, no spaces. Underscores allowed.
		$this->set_type( 'column-COLUMN_NAME' );

		// Default column label.
		$this->set_label( __( 'COLUMN_LABEL', 'ac-COLUMN_NAME' ) );
	}

	/**
	 * Returns the display value for the column.
	 *
	 * @param int $id ID
	 *
	 * @return string Value
	 */
	public function get_value( $post_id ) {

		// get raw value
		$value = $this->get_raw_value( $post_id );

		// optionally you can change the display of the value. In this example we added a post link.
		$value = '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . $value . '</a>';

		return $value;
	}

	/**
	 * Get the raw, underlying value for the column
	 * Not suitable for direct display, use get_value() for that
	 * This value will be used by 'inline-edit' and get_value().
	 *
	 * @param int $id ID
	 *
	 * @return mixed Value
	 */
	public function get_raw_value( $post_id ) {

		// put all the column logic here to retrieve the value you need
		// For example: $value = get_post_meta( $post_id, '_my_custom_field_example', true );

		$value = 'something';

		return $value;
	}

	/**
	 * (Optional) Create extra settings for you column. These are visible when editing a column. You can remove this function is you do not use it!
	 * Write your own settings or use any of the standard available settings.
	 */
	protected function register_settings() {

		// NOTE! When you use any of these settings, you should remove the get_value() method from this column, because the value will be rendered by the AC_Settings_Column_{$type} classes.

		// Display an image preview size settings screen
		// $this->add_setting( new \AC\Settings\Column\Image( $this ) );

		// Display an excerpt length input field in words
		// $this->add_setting( new \AC\Settings\Column\WordLimit( $this ) );

		// Display an excerpt length input field in characters
		// $this->add_setting( new \AC\Settings\Column\CharacterLimit( $this ) );

		// Display a date format settings input field
		// $this->add_setting( new \AC\Settings\Column\Date( $this ) );

		// Display before and after input fields
		// $this->add_setting( new \AC\Settings\Column\BeforeAfter( $this ) );

		// Displays a dropdown menu with user display formats
		// $this->add_setting( new \AC\Settings\Column\User( $this ) );

		// Displays a dropdown menu with post display formats
		// $this->add_setting( new \AC\Settings\Column\Post( $this ) );
	}

	/**
	 * (Optional) Is valid. You can remove this function if you do not use it!
	 * This determines whether the column should be available. If you want to disable this column
	 * for a particular post type you can set this to false.
	 * @return bool True/False Default should be 'true'.
	 */
	public function is_valid() {

		// Example: if the post type does not support thumbnails then return false
		// if ( ! post_type_supports( $this->get_post_type(), 'thumbnail' ) ) {
		//    return false;
		// }

		return true;
	}

	/*
	 * (Optional) Enqueue CSS + JavaScript on the admin listings screen. You can remove this function is you do not use it!
	 *
	 * This action is called in the admin_head action on the listings screen where your column values are displayed.
	 * Use this action to add CSS + JavaScript
	 */
	public function scripts() {

		wp_enqueue_script( 'ac-COLUMN_NAME', plugin_dir_url( __FILE__ ) . "../../../js/column.js" );
		wp_enqueue_style( 'ac-COLUMN_NAME', plugin_dir_url( __FILE__ ) . "../../../css/column.css" );
	}

}
