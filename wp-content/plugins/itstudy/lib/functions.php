<?php
/**
 * Various functions, filters, and actions used by the plugin.
 *
 * @package itstudy
 * @subpackage lib
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Returns the default settings for the plugin.
 *
 * @access public
 * @return array
 */
function course_get_default_settings() {

	$settings_course = array(
		'course_root'      		=> 'course',
		'course_base'      		=> '',          // defaults to 'itsduty_root'
		'course_item_base' 		=> '%course%',
	);

	return $settings_course;
}
function lesson_get_default_settings() {

	$settings_lesson = array(
		'lesson_root'      		=> 'lesson',
		'lesson_base'      		=> '',          // defaults to 'itsduty_root'
		'lesson_item_base' 		=> '%lesson%',
	);

	return $settings_lesson;
}

/**
 * Enqueues scripts and styles
 *
 * @access public
 * @return void
 */
function itsudy_admin_assets($hook_suffix){
    if (false === strpos($hook_suffix, 'course'))
        return;

   
    wp_enqueue_script('jquery-ui-sortable');
    wp_register_script('itsduty_admin_scripts', ITSTUDY_URI . 'assets/js/scripts_admin.js', array('jquery', 'jquery-ui-sortable'), ITSTUDY_VERSION, true);
    wp_enqueue_script('itsduty_admin_scripts');
}
add_action( 'admin_enqueue_scripts', 'itsudy_admin_assets' );

function itsduty_load_assets() {
     wp_enqueue_script('jquery');
    wp_enqueue_style('itsduty_admin', ITSTUDY_URI . 'assets/css/styles_admin.css', array(), ITSTUDY_VERSION, 'all');
    
}

add_action( 'admin_enqueue_scripts', 'itsduty_load_assets' );


/**
 * Itstudy Frontend styles and scripts
 * @access public
 * @return void                                            
 */
function itsduty_frontend_scripts_styles() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap_scr', ITSTUDY_URI.'assets/js/bootsrap.min.js', array('jquery'), ITSTUDY_VERSION, true);
    wp_enqueue_script('itstudy_scripts', ITSTUDY_URI.'assets/js/scripts.js', array('jquery'), ITSTUDY_VERSION, true);
    
    wp_register_style('bootstrap', ITSTUDY_URI.'assests/css/bootstrap.min.caa', array(), ITSTUDY_VERSION, 'all');
    wp_enqueue_style('bootstrap');
    wp_register_style('font_awesome', ITSTUDY_URI.'assets/css/font-awesome.min.css', array(), ITSTUDY_VERSION, 'all');
    wp_enqueue_style('font_awesome');
    wp_register_style('itsduty_styles', ITSTUDY_URI . 'assets/css/styles.css', array(), ITSTUDY_VERSION, 'all');
    wp_enqueue_style(array('bootstrap', 'font_awesome', 'itsduty_styles'));
}

add_action('wp_enqueue_scripts', 'itsduty_frontend_scripts_styles'); 

/**
 * Itstudy template files - lessons
 * @access public
 * @return void                                     
 */
//prawilniy  pokaz dlya shablonov ili kursov
if (!function_exists('template_redirect_course')) {

    function template_redirect_course() {
        global $wp_query, $post, $posts;
        if (get_query_var('course')) {
            if (file_exists(get_template_directory() . '/course.php')) {
                include( get_template_directory() . '/course.php' );
            } else {
                include( ITSTUDY_DIR . 'templates/course.php' );
            }
            exit();
        }
    }

}

// Adds templates for single and archive pages
add_action( 'template_redirect', 'template_redirect_course' ); 

if (!function_exists('template_redirect_lesson')) {

    function template_redirect_lesson() {
        global $wp_query, $post, $posts;
        if (get_query_var('lesson')) {
            if (file_exists(get_template_directory() . '/lesson.php')) {
                include( get_template_directory() . '/lesson.php' );
            } else {
                include( ITSTUDY_DIR . 'templates/lesson.php' );
            }
            exit();
        }
    }

}

// Adds templates for single and archive pages
add_action( 'template_redirect', 'template_redirect_lesson' ); 
/**
 * Itstudy SHORTCODE 
 * @access public
 * @return string            
 */
//shortcode dlya sozdaniya woprosow dlq kavdogo uroka 
/*
function question_shortcode( $atts ) {
	ob_start();
        include( ITSTUDY_DIR.'templates/shortcode/shortcode.php' );
        include( ITSTUDY_DIR.'templates/shortcode/ui.php' );
    return ob_get_clean();
}

*/
/*

function assign_course_to_user(){
    global $current_user;
    $courses=  get_posts('post_type=course');
    $checked_sids=array();
    $i=1;
    
    foreach ($courses as $course){
        $a=get_post_meta($course->ID, 'course_students');
        if(count($a) && in_array($current_user->ID, $a)){
            update_user_meta($current_user->ID, 'st_assigned_course', $course->ID);
        }
        
    }
    
}
add_action('init', 'assign_course_to_user');
 * 
 */



