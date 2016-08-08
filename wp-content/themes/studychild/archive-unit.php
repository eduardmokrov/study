<?php
/**
 * The units archive template file
 *
 * @package CoursePress
 */
global $coursepress;
$course_id = do_shortcode( '[get_parent_course_id]' );
$course_id = (int) $course_id;
$progress  = do_shortcode( '[course_progress course_id="' . $course_id . '"]' );
//redirect to the parent course page if not enrolled
$coursepress->check_access( $course_id );

global  $current_user;
$instructors = Course::get_course_instructors($course_id);
$ins_id = array();
foreach ($instructors as $instructor) {
    $ins_id[] = $instructor->ID;
}
get_header();
?>
	<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
	<h1><?php echo get_the_title( $course_id ) ?></h1>
	<div class="instructors-content">
		<?php
		// Flat hyperlinked list of instructors
		echo do_shortcode( '[course_instructors style="list-flat" link="true" course_id="' . $course_id . '"]' );
		?>
	</div>
<div class="student_lessons">
<?php

if(!in_array($current_user->ID, $ins_id)) : 
    echo do_shortcode( '[course_unit_archive_submenu]' ) . '&nbsp;';
endif;
?>
</div>
<?php
if ( 100 == (int) $progress ) {
	echo sprintf( '<div class="unit-archive-course-complete">%s %s</div>', '<i class="fa fa-check-circle"></i>', __( 'Course Complete', 'cp' ) );
}
?>

	<div class="clearfix"></div>
	<ul class="units-archive-list">
	<?php
	$units = Course::get_units_with_modules( $course_id );

	if ( ! empty( $units ) && count( $units ) > 0 ) {

		foreach ( $units as $unit_id => $unit ) {
			$post                = $unit['post'];
			$additional_class    = '';
			$additional_li_class = '';

			$is_unit_available = Unit::is_unit_available( $unit_id );
                        if(!in_array($current_user->ID, $ins_id)){
                            if ( ! $is_unit_available ) {
				$additional_class    = 'locked-unit';
				$additional_li_class = 'li-locked-unit';
                            }
                        }
			

			$unit_progress = do_shortcode( '[course_unit_percent course_id="' . $course_id . '" unit_id="' . $unit_id . '" format="true" style="extended"]' );

			?>
			<li class="<?php echo $additional_li_class; ?>">
				<div class='<?php echo $additional_class; ?>'></div>
				<div class="unit-archive-single">
					<?php echo $unit_progress; ?>
					<?php echo do_shortcode( '[course_unit_title unit_id="' . $unit_id . '" link="yes" last_page="yes"]' ); ?>
                                        <?php  if(!in_array($current_user->ID, $ins_id)) : ?>
                                            <?php echo do_shortcode( '[module_status format="true" course_id="' . $course_id . '" unit_id="' . $unit_id . '"]' ); ?>
                                        <?php endif;?>
				</div>
			</li>
			<?php
		}
	} else {
		?>
		<h1 class="zero-course-units"><?php _e( "0 units in the course currently. Please check back later." ); ?></h1>
		<?php
	}

?>
</ul>
</main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar( 'footer' ); ?>
<?php get_footer(); ?>