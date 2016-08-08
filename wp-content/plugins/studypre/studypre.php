<?php
/*
  * Plugin Name: Study Pre
  * Description: prepairing plugin for Study
  * 
  * 
  */

function add_role_mentor() {
       add_role( 'mentor', 'Mentor', array( 'read' => true, 'level_0' => true ) );
   }
   register_activation_hook( __FILE__, 'add_role_mentor' );
   
function mentor_review(){
    
}



function student_front_end_form($atts, $content = null ) {
   extract(shortcode_atts(array(
		"mentor_id"=>'',
	), $atts));
    ?>
    <?php
    if(is_user_logged_in()) {
    ?>
    <form id="mentor_review_form" name="mentor_review_form" method="post" action="">
        <p>
            <textarea id="rev_text" tabindex="3" name="rev_text" class="form-control" required="required" cols="30" rows="4" ></textarea>
        </p>
        <p class="text-center"><input type="submit" value="Leave Review" class="col-md-3 rev_submit" tabindex="6" id="submit" name="submit" /></p>
        <input type="hidden" name="post-type" id="post-type" value="review" />
        <input type="hidden" name="action" value="custom_posts" />
        <input type="hidden" name="mentor_id" value="<?php echo $mentor_id;?>" />
        <?php wp_nonce_field('mentor_review_nonce', 'mentor_review_nonce_field'); ?>
    </form>
    <?php
    if ($_POST) {
        student_save_post_data();
    }
    } else{ 
        echo "<h4 class='text-center'><strong>You must Login to leave a review</strong></h4>";
    }
}

add_shortcode('study_rev', 'student_front_end_form');

function student_save_post_data() {

    if (empty($_POST) || !wp_verify_nonce($_POST['mentor_review_nonce_field'], 'mentor_review_nonce')) {
        print 'Sorry, your nonce did not verify.';
        exit;
    } else {

        if (isset($_POST['rev_text'])) {
            $description = wp_strip_all_tags($_POST['rev_text']);
        } else {
            echo 'Please enter the content';
            exit;
        }

// Add the content of the form to $post as an array
        $post = array(
            'post_title' => 'review',
            'post_content' => $description,
            'post_status' => 'pending', // Choose: publish, preview, future, etc.
            'post_type' => 'post'  // Use a custom post type if you want to
        );
        $post_id=wp_insert_post($post);  // http://codex.wordpress.org/Function_Reference/wp_insert_post
        if($post_id){
            update_post_meta($post_id, 'mentor_id', $_POST['mentor_id']);
        }
        //$location = home_url(); // redirect location, should be login page

        header("Refresh:0");
        exit;
    } // end IF
}

function coursepress_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    global $user;
    if(!is_super_admin($user->ID)){
            if ( isset( $user->roles ) && is_array( $user->roles ) ) {

            if ( !in_array( 'mentor', $user->roles )) {
                // redirect them to the default place
                $data_login = get_option('axl_jsa_login_wid_setup');
                $last_lesson=  get_the_author_meta('last_lesson', $user->ID);
                $course_id = (int) get_post_field( 'post_parent', $last_lesson );
                $the_permalink = Unit::get_permalink( $last_lesson, $course_id );
                return $the_permalink;
            } else {
                return home_url().'/settings';
            }
        } else {
            return $redirect_to;
        }
    }else{
        return get_admin_url();
    }
    
}

function study_login(){
    add_filter( 'login_redirect', 'coursepress_redirect');
}
add_action('init', 'study_login');

function get_next($array, $key) {
    $currentKey = current($array);
    while ($currentKey !== null && $currentKey != $key) {
        next($array);
        $currentKey = current($array);
    }
    return next($array);
}
//add_action('init', 'get_next');

function get_prev($array, $key) {
    $currentKey = current($array);
    while ($currentKey !== null && $currentKey != $key) {
        next($array);
        $currentKey = current($array);
    }
    return prev($array);
}

?>
