<?php 
/**
 * Plugin Name: Itstudy
 * Description: Custom LMS plugin for itsdudy
 * Version: 1.0.0
 * Text Domain: itstudy
 * Domain Path: /locale/
 */

// check if path comes from wp root directory
if(!defined('ABSPATH')){
    exit;
}

class Itstudy{
    
    /**
     * initialization function
     */
    public static function init() {
        
        /* Set the constants needed by the plugin. */
        add_action('plugins_loaded', array(get_called_class(), 'constants'), 1);
        
        
        /* Internationalize the text strings used. */
        add_action('plugins_loades', array(get_called_class(), 'i18n'), 2);
        
        /* Load the functions files. */
        add_action('plugins_loaded', array(get_called_class(), 'includes'), 3);
        
        /* Load the admin files. */
        add_action('plugins_loaded', array(get_called_class(), 'admin'), 4);
        
        /* Register activation hook. */
        register_activation_hook(__FILE__, array(get_called_class(), 'activation'));

    }
    
    /**
     *  define constants for plugin files
     */
    public static function constants() {
        /* Set the text domain */
        define('ITSTUDY_DOMAIN', 'itstudy');

        /* Set the version */
        define('ITSTUDY_VERSION', '1.0.0');

        /* Set constant path to the plugin directory. */
        define('ITSTUDY_DIR', trailingslashit(plugin_dir_path(__FILE__)));
        
        /* Set the constant path to the plugin directory URI. */
        define('ITSTUDY_URI', trailingslashit(plugin_dir_url(__FILE__)));
        
        /* Set the constant path to the includes directory. */
        define('ITSTUDY_LIB', ITSTUDY_DIR.trailingslashit('lib'));

        /* Set the constant path to the admin directory. */
        define('ITSTUDY_ADMIN', ITSTUDY_DIR.trailingslashit('admin'));
        
        /* shortcode needed files */
        define('ITSUDY_SHORTCODES',  ITSTUDY_DIR . '/templates/shortcode/ui.php' );
      //  define ( 'SHORT_JS_PATH' , ITSTUDY_DIR.'templates/shortcode/shortcode.js');
    }
    
    /**
     * Loads the translation files.
     * @return void
     */
    public static function i18n() {
        /* Load the translation of the plugin. */
        load_plugin_textdomain(ITSTUDY_DOMAIN, false, ITSTUDY_DIR . '/locale/');
    }

    /**
     * Loads the initial files needed by the plugin.
     * @return void
     */
    public static function includes() {
        foreach (glob(ITSTUDY_LIB . "*.php") as $file) {
            require_once $file;
        }
        require_once ITSTUDY_DIR.'templates/shortcode/shortcode.php';
    }
    
    /**
     * Loads the admin functions and files.
     * @return void
     */
    public static function admin() {
        if (is_admin()) {
            foreach (glob(ITSTUDY_ADMIN . "*.php") as $file) {
                require_once $file;
            }
        }
    }

    /**
     * Method that runs only when the plugin is activated.
     * @return void
     */
    public static function activation() {
        $role=  get_role('administrator');
        $role_mentor=get_role('mentor');
        $role_student=get_role('student');
        
        //give permissions for courses
        if(!empty($role)){
            $role->add_cap('read_course_items');
            $role->add_cap('edit_course_items');
            $role->add_cap('delete_course_items');
            $role->add_cap('read_lesson_items');
            $role->add_cap('edit_lesson_items');
            $role->add_cap('delete_lesson_items');
        }
        
        //give permissions to Mentors
        if(empty($role_mentor)){
            add_role('mentor', 'Mentor');
            $role_mentor->add_cap('read_course_items');
            $role_mentor->add_cap('edit_course_items');
            $role_mentor->add_cap('delete_course_items');
            $role_mentor->add_cap('read_lesson_items');
            $role_mentor->add_cap('edit_lesson_items');
            $role_mentor->add_cap('delete_lesson_items');
        }
        
        if(empty($role_student)){
            add_role('student', 'Student');
        }
        
        
    }

}

Itstudy::init();