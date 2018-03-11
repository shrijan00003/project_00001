<?php
/**
 * enqueue css/js
 *
 */
if ( ! function_exists( 'nepali_date_converter_enqueue_scripts' ) ) :

    function nepali_date_converter_enqueue_scripts(){
        wp_enqueue_script('jquery');
    }
endif;