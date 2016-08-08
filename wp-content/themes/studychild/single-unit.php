<?php
/**
 * The Template for displaying single unit posts with modules
 *
 * @package CoursePress
 */
global $coursepress, $wp, $wp_query;

$course_id = do_shortcode('[get_parent_course_id]');
$progress = do_shortcode('[course_progress course_id="' . $course_id . '"]');

$course = new Course( $course_id );
add_thickbox();

$paged = ! empty( $wp->query_vars['paged'] ) ? absint($wp->query_vars['paged']) : 1;
//redirect to the parent course page if not enrolled or not preview unit/page
while ( have_posts() ) : the_post();
    $coursepress->check_access($course_id, get_the_ID());
endwhile;

get_header();

$post = $unit->details;



$instructors = Course::get_course_instructors($course_id);
$ins_id = array();
$ins_id_str='';
foreach ($instructors as $instructor) {
    $ins_id[] = $instructor->ID;
    $ins_id_str.=$instructor->ID;
}

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main unit-single-child" role="main">
        <?php
                global $current_user;
                update_user_meta($current_user->ID, 'last_lesson', $unit->details->ID);
                update_user_meta($current_user->ID, 'last_'.$course_id.'_lesson', $unit->details->ID);
                $last_lesson=  get_the_author_meta('last_lesson', $current_user->ID);
                if(is_user_logged_in()) : ?>
                    
                    <div class="row user-banner">
                        <?php  if(!in_array($current_user->ID, $ins_id)) : ?>
                        <div class="col-md-4 course-progress">
                            <h5><?php echo $post->post_title;?></h5>
                            <?php
                            
                            $units  = $course->get_units( $course_id, 'publish' );
                            $counter=1;
                            foreach ($units as $unititem){
                                $unit_status=  Student_Completion::calculate_unit_completion($current_user->ID, $course_id, $unititem['post']->ID);
                                //$unit_status=do_shortcode( '[course_unit_progress course_id="' . $course_id . '" unit_id="' . $unititem['id']. '"]' );
                                
                                $color_class=$unit_status==100 ? 'color-green' : '';
                                if($unit_status==100){
                                    $the_permalink = Unit::get_permalink( $unititem['post']->ID, $course_id );
                                    echo '<a href="'.$the_permalink.'">';
                                }
                                if($counter<4){
                                    echo '<span class="unit-item '.$color_class.'">'.$counter.'</span>';
                                }
                                
                                if($unit_status==100){
                                    echo '</a>';
                                }
                                $counter++;
                               
                               
                            }
                            if($counter>4){
                                echo '<span class="unit-item-more">....</span>';
                                echo '<span class="unit-item '.$color_class.'">'.--$counter.'</span>';
                            }
                            
                            ?>
                        </div>
                        <div class="col-md-4 user-nots text-center">
                            <h4 class="st-not">Notice</h4>
                        </div>
                        <?php else : ?>
                        <div class="col-md-3 mentor-banner-area">
                            <div class="course-banner">
                                <?php
                                    echo '<h4>'.$course->get_course($course_id)->post_title.'</h4>';
                                    $studs=$course->get_number_of_students($course_id);
                                    echo '<p>Students: '.$studs.'</p>';
                                ?>
                            </div>
                            <div class="course-add-lesson">
                                <h4><a href="<?php echo admin_url( 'admin.php?page=course_details&tab=units&course_id='.$course_id.'&action=add_new_unit' );?>">Add Lesson</a></h4>
                            </div>
                        </div>
                        <div class="col-md-5 banner-students">
                            <?php
                            global $wpdb;
                            $myrows = 
                            $students_ids=$course->get_course_students_ids($course_id);
                           foreach ($students_ids as $ids){
                               $stundent_item=  get_user_by('ID', $ids);
                               $mess_count=$wpdb->get_var( "SELECT COUNT(`message`) FROM `wp_chat_message` WHERE `chat_id`=".$stundent_item->ID.$ins_id_str );
                               echo '<a href="?student_id='.$stundent_item->ID.'" class="mentor-student-item">'.$stundent_item->user_firstname.'<small>'.$mess_count.'</small></a>';
                           }
                           ?>
                        </div>
                            
                        
                        
                        
                        <?php endif;?>
                        <div class="col-md-4 user-info text-right">
                           
                            <div class="dropdown">
                                    <div class="dropdown-toggle" type="button" id="<?php echo 'usermenu'.$current_user->ID;?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <h4> <?php echo 'Hello '.$current_user->first_name; ?></h4>
                                        <i class="fa fa-user"></i>
                                        <i class="fa fa-cog"></i>
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="<?php echo 'usermenu'.$current_user->ID;?>">
                                        <li><a href="<?php echo home_url().'/settings';?>">Profile</a></li>
                                        <li><a href="<?php echo home_url().'/courses-dashboard/'; ?>">Courses</a></li>
                                        <li><a href="<?php echo wp_logout_url();?>">Logout</a></li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                <?php endif;?>
        <?php $stud_less_id=isset($_GET['student_id']) ? $_GET['student_id'] : '';?>
        <div class="row">
            <div class="col-md-5 custom-chat-area">
                 <?php /* if(in_array($current_user->ID, $ins_id)) : ?>
                    <?php echo do_shortcode('[chat id="'.$stud_less_id.$ins_id_str.'"]'); ?>
                <?php else : ?>
                    <?php echo do_shortcode('[chat id="'.$current_user->ID.$ins_id_str.'"]'); ?>
                <?php endif;*/?>
               
                <div id="cometchat_embed_chatrooms_container" style="display:inline-block; border:1px solid #CCCCCC;"></div>
<script src="/cometchat/js.php?type=core&name=embedcode" type="text/javascript"></script>
<script>var iframeObj = {};iframeObj.module="chatrooms";iframeObj.src="/cometchat/modules/chatrooms/index.php?id=0";iframeObj.width="500";iframeObj.height="300";if(typeof(addEmbedIframe)=="function"){addEmbedIframe(iframeObj);}</script>               
            </div>
            <div class="col-md-7 custom-lesson-area">
                <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('unit-single'); ?> >
                        <header class="entry-header">
                            <h3 class="entry-title course-title"><?php echo do_shortcode('[course_title course_id="' . $course_id . '"]'); ?></h3>
                            <?php
                            //echo do_shortcode('[course_unit_details unit_id="' . get_the_ID() . '" field="parent_course"]');
                            ?>
                        </header><!-- .entry-header -->
                        <div class="instructors-content"></div>
                        <?php
                        // echo do_shortcode('[course_unit_archive_submenu course_id="' . $course_id . '"]');
                        ?>

                        <div class="clearfix"></div>

                        <?php echo do_shortcode( '[course_unit_page_title unit_id="' . $unit->details->ID . '" title_tag="h6" show_unit_title="yes"]' ); ?>

                        <?php
                       
                       if(!in_array($current_user->ID, $ins_id)){
                           
                           Unit_Module::get_modules_front($unit->details->ID);
                       }else{
                           echo '<div class="unit-view-mentor">';
                           ?>
                        <div class="lesson_edit_wrap">
                            <a class="mentor_edit_lesson" href="<?php 
                                                        echo admin_url( 'admin.php?page=course_details&tab=units&course_id=' 
                                                        . $course_id . '&unit_id=' 
                                                        . $unit->details->ID . '&action=edit'); ?>">
                                <?php _e( 'Edit Lesson', 'coursepress' ); ?>
                            </a>
                        </div>
                        
                                            
                        <?php
                          // Unit_Module::get_modules_front($unit->details->ID);
                            $modules = Unit_Module::get_modules(get_the_ID());

                            $input_modules_count = 0;
                            if(isset($stud_less_id) && $stud_less_id!=''){
                                foreach ($modules as $mod) {
                                    $class_name = $mod->module_type;
                                    if (class_exists($class_name)) {
                                        if (constant($class_name . '::FRONT_SAVE')) {
                                            $input_modules_count ++;
                                        }
                                    }

                                ?>
                                <?php
                                if($class_name!=='text_module'){
                                    echo '<p class="mentor-module-title">'.$mod->post_title.'</p>';
                                    }
                                    if (isset($mod->post_content) && $mod->post_content !== '') {?>
                                    <div class="module_response_description <?php echo $class_name;?>">
                                     <label><?php //echo $module_response_description_label; ?></label>
                                    <?php echo $mod->post_content; ?>
                                     </div>
                                <?php } ?>
                                <?php 
                                    
                                    echo call_user_func($class_name . '::get_response_form', $stud_less_id, $mod->ID);
                                    if($class_name!=='text_module'){
                                       echo '<div class="grade-wrap">';
                                        $response = call_user_func( $class_name . '::get_response', $stud_less_id, $mod->ID );
                                        $grade_data = Unit_Module::get_response_grade( $response->ID );
                                        if (count($response) >= 1) {
                                            if (isset($grade_data)) {
                                                    echo $grade_data['grade'].'%';
                                                } else {
                                                    _e('Pending grade', 'coursepress');
                                                }
                                                ?>
                                                <a class="assessment-view-response-link pull-right" href="<?php 
                                                echo admin_url( 'admin.php?page=assessment&course_id=' 
                                                        . $course_id . '&unit_id=' 
                                                        . $unit->details->ID . '&user_id='
                                                        . $stud_less_id . '&module_id=' 
                                                        . $mod->ID . '&response_id=' . $response->ID . '&assessment_page=1'); ?>"><?php _e( ' Grade answer', 'coursepress' ); ?></a>
                                            <?php
                                        }else{
                                            echo "not answered yet";
                                        }
                                        echo '</div>';
                                    }
                                     
                                     
                                }
                            }else{
                                echo 'Choose Student to view units';
                            }
                            echo '</div>';

                       }
                        
                        ?>
                    </article>
                
                <?php endwhile; // end of the loop. ?>
                <div class="unit-nav">
                <?php
                    $units_pag  = $course->get_units( $course_id, 'publish' );
                    $cur_unit_status=  Student_Completion::calculate_unit_completion($current_user->ID, $course_id, get_the_ID());
                    $unit_ids=array_keys($units_pag);
                    $cur_id=get_the_id();
                    $next_url='';
                    $url_end= current_user_can('mentor') ? '?student_id='.$stud_less_id : '';
                    $last_id=count($unit_ids)-1;
                    //if(!current_user_can('mentor')){
                        if($cur_id!=$unit_ids[0]){
                            $prev_url=Unit::get_permalink( get_prev($unit_ids, $cur_id), $course_id );
                            echo '<a href="'.$prev_url.$url_end.'" class="prev_lesson"><i class="fa fa-angle-left"></i>Previuos Lesson</a>';
                        }
                  //  }
                    if($cur_id!==$unit_ids[$last_id]){
                        
                        if($cur_unit_status==100 || current_user_can('mentor')){
                            $next_url.=Unit::get_permalink( get_next($unit_ids, $cur_id), $course_id );
                            echo '<a href="'.$next_url.$url_end.'" class="next_lesson">Next Lesson<i class="fa fa-angle-right"></i></a>';
  
                        }else{
                            echo '<span class="nav-locked">You have to finish this Lesson</span>';
                        }
                    }
                ?>
               </div>
            </div>
        </div>
       
    </main><!-- #main -->
</div><!-- #primary -->
<?php //get_sidebar('footer'); ?>
<?php get_footer(); ?>
