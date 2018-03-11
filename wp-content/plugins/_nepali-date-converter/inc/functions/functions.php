<?php
/**
 * check if key/s exists in an array
 *
 * @since Evision Corporate 1.1.0
 */
if ( ! function_exists( 'coder_array_key_exists' ) ) :
    function coder_array_key_exists( $keys, $array ) {
        foreach( $keys as $key )
            if(!array_key_exists( $key,$array ) ){
                return false;
            }
        return true;
    }
endif;

/**
 * convert english date to nepali
 *
 * @since Evision Corporate 1.1.0
 */
if ( ! function_exists( 'eng_to_nep_date' ) ) :
    function eng_to_nep_date( $input_date = array(), $date_format = 'nep_char', $format = 'D, F j, Y' ) {
        if( false == coder_array_key_exists ( array('year','month','day' ),$input_date ) ){
            return sprintf( __( 'Invalid array provided, please pass array in this format: %s', 'nepali-date-converter' ), 'array( "year"=>"2015","month"=>"09","day"=>"11" )' );
        }
        $date_format	= trim($date_format);
        $coder_nepali_calendar = new Coder_Nepali_Calendar();
        return $coder_nepali_calendar->eng_to_nep( $input_date, $date_format, $format );
    }
endif;

/**
 * convert english date to nepali with allow string input
 *
 * @since Evision Corporate 1.1.0
 */
if ( ! function_exists( 'convert_eng_to_nep' ) ) :
    function convert_eng_to_nep( $input_date_str, $date_format = 'nep_char', $format = 'D, F j, Y' ) {
        $input_date_str	= trim( $input_date_str );
        $date_format	= trim( $date_format );
        $input_date_temp= explode( '-',$input_date_str );

        $input_date_array['year']		= (int) $input_date_temp [0];
        $input_date_array['month']		= (int) $input_date_temp [1];
        $input_date_array['day']		= (int) $input_date_temp [2];

        $coder_nepali_calendar = new Coder_Nepali_Calendar();
        return $coder_nepali_calendar->eng_to_nep( $input_date_array, $date_format, $format );
    }
endif;

/**
 * convert nepali date to english
 *
 * @since Evision Corporate 1.1.0
 */
if ( ! function_exists( 'nep_to_eng_date' ) ) :
    function nep_to_eng_date( $input_date = array(), $format = 'D, F j, Y' ) {
        if( false == coder_array_key_exists ( array('year','month','day' ),$input_date ) ){
            return sprintf( __( 'Invalid array provided, please pass array in this format: %s', 'nepali-date-converter' ), 'array( "year"=>"2015","month"=>"09","day"=>"11" )' );
        }
        $coder_nepali_calendar = new Coder_Nepali_Calendar();
        return $coder_nepali_calendar->nep_to_eng( $input_date, $format );
    }
endif;

/**
 * convert english date to nepali with allow string input
 *
 * @since Evision Corporate 1.1.0
 */
if ( ! function_exists( 'convert_nep_to_eng' ) ) :
    function convert_nep_to_eng( $input_date_str, $format = 'D, F j, Y' ) {
        $input_date_str	= trim( $input_date_str );
        $input_date_temp= explode( '-',$input_date_str );

        $input_date_array['year']		= (int) $input_date_temp [0];
        $input_date_array['month']		= (int) $input_date_temp [1];
        $input_date_array['day']		= (int) $input_date_temp [2];

        $coder_nepali_calendar = new Coder_Nepali_Calendar();
        return $coder_nepali_calendar->nep_to_eng( $input_date_array, $format );
    }
endif;