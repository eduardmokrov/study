<?php
/**
 * @shortcode for questions
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


function Itstudy_addbuttons() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_alc_custom_tinymce_plugin");
		add_filter('mce_buttons', 'register_alc_custom_button');
	}
}
function register_alc_custom_button($buttons) {
	array_push(
		$buttons,
		"Itstudy"
		); 
	return $buttons;
} 

function add_alc_custom_tinymce_plugin($plugin_array) {
	$plugin_array['ItstudyShortcodes'] = ITSTUDY_URI.'templates/shortcode/shortcode.js';
	return $plugin_array;
}
add_action('init', 'Itstudy_addbuttons');

function sumtips_add_dfe_buttons($buttons)
{
	$buttons[] = 'separator'; //Add separator (optional)
	$buttons['ItstudyShortcodes'] = array(
		'title' => __('Itstudy Shortcodes'), //Button Title
		'onclick' => "tinyMCE.execCommand('alc_itstudy');", //Command to execute
		'both' => true // Show in visual mode. Set 'true' to show in both visual and HTML mode
	);
	
	return $buttons;
}
add_filter( 'wp_fullscreen_buttons', 'sumtips_add_dfe_buttons' );
/******************************************************/



function question_shortcode( $atts ) {
extract(shortcode_atts(array(
	"id" => '',
	"question" => '',
), $atts));

global $post;
global $current_user;
$randomId=  mt_rand(0, 10000);
/*
$question_exists=  get_post($id);
if($question_exists) : ?>
<div class="question-wrap">
    <h4><?php echo $question_exists->post_title;?></h4>
    <p class="question-cotnent"><?php echo $question_exists->post_content; ?></p>
    <?php $status=get_post_meta($id, 'status_'.$current_user->ID, true);
    if($status==1){
        echo '<span class="question-status"><i class="fa fa-check"></i></span>';
    }else{
        echo '<span class="question-status"><i class="fa fa-close"></i></span>';
    }
    ?> 
</div>
<?php else : ?>
 * 
 */
?>
<form id="apfform" action="" method="post"enctype="multipart/form-data">
    <input type="hidden" name="qua_title" value="<?php echo $question; ?>">
    <input type="hidden" name="lesson_id" value="<?php echo get_the_ID();?>">
    <input type="hidden" name="stud_id" value="<?php echo $current_user->ID;?>">
        <div id="apf-text">
 
            <div id="apf-response" style="background-color:#E6E6FA"></div>
 
            <strong><?php echo $question; ?></strong> <br/>
            <textarea id="apfcontents" name="apfcontents"  rows="10" cols="20"></textarea><br />
            <br/>
 
            <a onclick="apfaddpost(apftitle.value,apfcontents.value);" style="cursor: pointer"><b>Create Post</b></a>
 
        </div>
    </form>

<?php /*endif; */


 wp_reset_query(); 
}
// Adds the shortcode
add_shortcode('itstudy_question', 'question_shortcode');

function apf_addpost() {
    $results = '';
 
    $title = $_POST['qua_title'];
    $content =  $_POST['apfcontents'];
    $author = $_POST['stud_id'];
    $parent_lesson = $_POST['lesson_id'];
 
    $post_id = wp_insert_post( array(
        'post_title'        => $title,
        'post_content'      => $content,
        'post_status'       => 'publish',
        'post_author'       => $author,
	'post_type'=>'question',
    ) );
	update_post_meta($post_id, 'parent_lesson', $parent_lesson);
        //update_post_meta($post_id, 'status'_$author, $parent_lesson);
 
    if ( $post_id != 0 )
    {
        $results = '*Post Added';
    }
    else {
        $results = '*Error occurred while adding the post';
    }
    // Return the String
    die($results);
}
   
add_action( 'wp_ajax_nopriv_apf_addpost', 'apf_addpost' );
add_action( 'wp_ajax_apf_addpost', 'apf_addpost' );