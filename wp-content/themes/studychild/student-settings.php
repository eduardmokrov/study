<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php if (is_user_logged_in()) { ?>
        <div class="row profile-wrap">
            <?php global $current_user;
            if(!current_user_can('mentor')):?>
            <div class="col-md-12 student_profile">
                <?php echo do_shortcode(' [user-meta-profile form="student_edit"]'); ?>
            </div>
            <div class="student-courses col-md-12">   
             <a class="btn btn-primary" role="button" data-toggle="collapse" href="#student_course_list" aria-expanded="false" aria-controls="student_course_list">My Courses</a>
                <div class="collapse" id="student_course_list">
                    <div class="well text-left ">
                        <?php
                            $stud       = new Student( $current_user->ID );
                            $course_ids = $stud->get_assigned_courses_ids( );
                            foreach ($course_ids as $student_course_id){?>
                            <div class="student-course-item">
                                <h3><a href="<?php echo get_the_permalink($student_course_id); ?>">
                                    <?php echo get_the_title($student_course_id); ?>
                                    </a></h3>
                            <?php

                                $st_course = new Course( $student_course_id );
                                $st_units  = $st_course->get_units( $student_course_id, 'publish' );
                                $counter=1;
                                foreach ($st_units as $st_unititem){
                                    $unit_status=  Student_Completion::calculate_unit_completion($current_user->ID, $student_course_id, $st_unititem['post']->ID);
                                    $color_class=$unit_status==100 ? 'color-green' : '';
                                    echo '<span class="unit-item '.$color_class.'">'.$counter.'</span>';
                                    $counter++; 
                                }?>
                            </div>
                            <?php }?>
                    </div>
                </div>
                
            </div>
            <?php else :?>
            <div class="col-md-12 mentor-profile-banner">
                
            </div>
            <div class="col-md-3 mentor-left-part">
                <?php echo get_avatar( $current_user->ID, 250 ); ?>
            </div>
            <div class="col-md-6 mentor-right-part">
                <h2 class="mentor-name"><?php echo $current_user->display_name;?></h2>
                <p class="mentor-desc">
                    <?php echo get_the_author_meta('description', $current_user->ID);?>
                </p>
            </div>
            <div class="col-md-12 text-right">
                <a class="btn btn-primary" role="button" data-toggle="collapse" href="#mentor_prof_edit" aria-expanded="false" aria-controls="mentor_prof_edit">Edit Profile</a>
                <div class="collapse" id="mentor_prof_edit">
                    <div class="well text-left pull-left">
                        <?php echo do_shortcode(' [user-meta-profile form="mentor_edit"]'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mentor_students">
                <?php $mentor= new  Instructor($current_user->ID);
                $ins_courses_ids=$mentor->get_assigned_courses_ids($status='all');
                
                ?>
                <table class="table table-responsive table-bordered">
                <?php
                foreach ($ins_courses_ids as $single_course_id){
                    echo '<thead><tr>';
                    $course = new Course( $single_course_id );
                    $students_ids=$course->get_course_students_ids($single_course_id);
                    $units  = $course->get_units( $single_course_id, 'publish' );
                    echo '<th>Student name</th>';
                    echo '<th>'.  get_the_title($single_course_id).'</th>';
                    echo '</tr></thead><tbody>';
                    foreach ($students_ids as $ids){
                        $st_last_lesson=  get_the_author_meta('last_'.$single_course_id.'_lesson', $ids);
                        $st_course_id = (int) get_post_field( 'post_parent', $st_last_lesson );
                        $st_the_permalink = Unit::get_permalink( $st_last_lesson, $st_course_id );
                               $stundent_item=  get_user_by('ID', $ids);
                               echo '<tr><td><a href="'.$st_the_permalink.'?student_id='.$ids.'">'.$stundent_item->display_name.'</a></td>';
                               $counter=1;
                               echo '<td>';
                                foreach ($units as $unititem){
                                    $unit_status=  Student_Completion::calculate_unit_completion($stundent_item->ID, $single_course_id, $unititem['post']->ID);
                                    //$unit_status=do_shortcode( '[course_unit_progress course_id="' . $course_id . '" unit_id="' . $unititem['id']. '"]' );

                                    $color_class=$unit_status==100 ? 'color-green' : '';
                                    echo '<span class="unit-item '.$color_class.'">'.$counter.'</span>';
                                    $counter++; 
                                }
                                echo '</td></tr>';
                           }
                           ?>
                        <?php
                }
                
                            
                ?>
                </tbody>
                </table>
            </div>
            <?php endif;?>
        </div>
       
           
        <?php } else {
            // if( defined('DOING_AJAX') && DOING_AJAX ) { cp_write_log('doing ajax'); }
            wp_redirect(get_option('use_custom_login_form', 1) ? CoursePress::instance()->get_signup_slug(true) : wp_login_url() );
            exit;
        }
        ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
