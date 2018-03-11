<?php
add_action( 'wp_ajax_nepali_date_converter_ajax', 'nepali_date_converter_ajax_callback' );
add_action( 'wp_ajax_nopriv_nepali_date_converter_ajax', 'nepali_date_converter_ajax_callback' );

if ( ! function_exists( 'nepali_date_converter_ajax_callback' ) ) :

    function nepali_date_converter_ajax_callback(){
        $from = $_POST['from'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        $result_format = $_POST['result_format'];
        $date = array(
            'year' => $year,
            'month' => $month,
            'day' => $day
        );
        if( 'from-eng' == $from ){
            $lang = $_POST['lang'];
            $result = eng_to_nep_date( $date,$lang,$result_format );
        }
        else {
            $result = nep_to_eng_date( $date, $result_format);
        }
        echo $result['result'];
        exit;
    }

endif;
