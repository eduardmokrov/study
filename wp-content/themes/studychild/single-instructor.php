<?php
/**
 * The Template for displaying instructor profile.
 *
 * @package CoursePress
 */
get_header();

$user = $vars['user']; //get user info from the CoursePress plugin
global $current_user;
$instructor = new Instructor($user->ID);
$assigned_courses = $instructor->get_assigned_courses_ids('publish');
?>

<div id="primary" class="content-area content-instructor-profile">
    <main id="main" class="site-main" role="main">
        <div class="row mentor-wrap">
            <div class="col-md-3 mentor-img">
               <?php echo do_shortcode('[course_instructor_avatar instructor_id="' . $user->ID . '" thumb_size="235" class="instructor_avatar_full"]');?>
            </div>
            <div class="col-md-7">
                 <h1 class="instructor-title"><?php echo $instructor->display_name; ?></h1>
                 <?php echo get_user_meta($user->ID, 'description', true); ?>             
            </div>
            <div class="col-md-8 col-md-offset-2 mentor-review-wrap">
               
                <h3 class="text-center">Reviews</h3>
                <ul>
                    <?php 

                        $args = array(
                            'meta_query' => array(
                              //  'post_type' => 'review',                              
                                array(
                                    'key'       => 'mentor_id',
                                    'value'     => $user->ID
                                )
                               ),
                            );              

                        $the_query = new WP_Query( $args );
                        if($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); 
                        ?>
                            <li>
                                <?php the_content(); ?><span>--<?php the_author();?></span></li>
                    <?php endwhile; endif;
                    wp_reset_postdata();?>

                    </ul>
                <?php if($current_user->ID!==$user->ID) :?>
                 <?php echo do_shortcode('[study_rev mentor_id="' . $user->ID . '"]')//if (function_exists("wdqs_quick_status")) wdqs_quick_status();?>
                <?php endif;?>
                <!--
                <form class="review-form text-center">
                    <textarea class="form-control"></textarea>
                    <input type="submit" class="btn bnt-success" value="Leave Review"/>
                </form>
                -->
            </div>
        </div>


       <!-- <h2 class=''><?php _e('Courses', 'cp'); ?></h2> -->

        <?php
        // Course List
       // echo do_shortcode('[course_list instructor="' . $user->ID . '" class="course" left_class="enroll-box-left" right_class="enroll-box-right" course_class="enroll-box" title_link="yes"]');
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php //get_sidebar( 'footer' ); ?>
<?php get_footer(); ?>