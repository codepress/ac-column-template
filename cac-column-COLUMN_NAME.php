<?php

class CPAC_Column_COLUMN_NAME extends CPAC_Column {

    /**
     * This function will setup the column data
     *
     */
    public function init() {

        // do not delete
    	parent::init();

        // Identifier, pick an unique name. Single word, no spaces. Underscores allowed.
        $this->properties['type'] = 'column-COLUMN_NAME';

        // Default column label.
        $this->properties['label'] = __( 'COLUMN_LABEL', 'cac-COLUMN_NAME' );

        // (optional) You can make it support sorting with the pro add-on enabled. Sorting will done by it's raw value.
        $this->properties['is_sortable'] = true;
    }

    /**
     * Returns the display value for the column.
     *
     * @param int $id ID
     * @return string Value
     */
    public function get_value( $post_id ) {

        // get raw value
        $value = $this->get_raw_value( $post_id );

        // optionally you can change the display of the value. In this example we added a post link.
        $value = '<a href="' . get_permalink( $post_id ) . '">' . $value . '</a>';

        return $value;
    }

    /**
     * Get the raw, underlying value for the column
     * Not suitable for direct display, use get_value() for that
     * This value will be used by 'sorting', 'inline-edit' and get_value().
     *
     * @param int $id ID
     * @return mixed Value
     */
    public function get_raw_value( $post_id ) {

        // put all the column logic here to retrieve the value you
        // For example: $value = get_post_field( 'post_title', $post_id, 'raw' );

        $value = 'something';

        return $value;
    }

    /**
     * (Optional) Apply conditionals. You can remove this function is you do not use it!
     *
     * This determines whether the column should be available. If you want to disable this column
     * for a particular posttype you can set this to false.
     *
     * @return bool True/False Default should be 'true'.
     */
    public function apply_conditional() {

        // Example: if posttype does not support thumbnails then return false
        // if ( ! post_type_supports( $this->get_post_type(), 'thumbnail' ) ) {
        //    return false;
        // }

        return true;
    }

    /**
     * (Optional) Load specific column settings. You can remove this function is you do not use it!
     *
     * Write your own input fields or use any of the standard settings.
     */
    public function display_settings() {

        // You can write your own input fields here, or use the examples below...

        // Here are a few example on different settings that are available out-of-the-box.

        // Display an image preview size settings screen
        // $this->display_field_preview_size();

        // Display an excerpt length input field
        // $this->display_field_excerpt_length();

        // Display a date format settings input field
        // $this->display_field_date_format();

        // Display before and after input fields
        // $this->display_field_before_after();

        // Displays a dropdown menu with user display formats
        // $this->display_field_user_format();
    }
}