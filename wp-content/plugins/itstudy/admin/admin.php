<?php
/**
 * Admin functions for the plugin.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Set up the admin functionality. */
add_action( 'admin_menu', 'itstudy_admin_setup' );

/* Adds new submenu for sorting of itstudy items */
add_action( 'admin_menu', 'itstudy_register_itstudy_menu' );

/* Adds support of AJAX for the sorting pages*/
add_action( 'wp_ajax_itstudy_itstudy_update_post_order', 'itstudy_itstudy_update_post_order' );
add_action('wp_ajax_itstudy_lesson_update_post_order', 'itstudy_lesson_update_post_order');



/**
 * Adds actions where needed for setting up the plugin's admin functionality.
 * @return void
 */
function itstudy_admin_setup() {

	/* Custom columns on the edit itstudy items screen. */
	add_filter( 'manage_edit-itstudy_columns', 'itstudy_edit_itstudy_columns' );
	add_action( 'manage_itstudy_posts_custom_column', 'itstudy_manage_itstudy_columns', 10, 2 );
}

/**
 * Sets up custom columns on the itstudy items edit screen.
 *
 * @access public
 * @param  array  $columns
 * @return array
 */
function itstudy_edit_itstudy_columns( $columns ) {

	unset( $columns['title'] );

	$new_columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Courses', ITSTUDY_DOMAIN )
	);

	if ( current_theme_supports( 'post-thumbnails' ) )
		$new_columns['thumbnail'] = __( 'Thumbnail', ITSTUDY_DOMAIN );

	return array_merge( $new_columns, $columns );
}

/**
 * Displays the content of custom itstudy item columns on the edit screen.
 *
 * @access public
 * @param  string  $column
 * @param  int     $post_id
 * @return void
 */
function itstudy_manage_itstudy_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'thumbnail' :

			if ( has_post_thumbnail() )
				the_post_thumbnail( array( 40, 40 ) );
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}



/**
 * Add new submenu for sorting.
 *
 * @access public
 * @return void
 */
function itstudy_register_itstudy_menu() {
        add_submenu_page(
		'edit.php?post_type=course',
		'Order Courses',
		'Sort courses',
		'edit_pages', 'itstudy-itstudy-order',
		'itstudy_itstudy_order_page'
	);
       add_submenu_page(
		'edit.php?post_type=course',
		'Order Lessons',
		'Sort lessons',
		'edit_pages', 'itstudy-lesson-order',
		'itstudy_lesson_order_page'
	);
}

/**
 * Callback function for add_submenu_page function
 * Returns the output for the sorting page
 *
 * @access public
 * @return void
 */
function itstudy_itstudy_order_page() 
{
	?></pre>
	<div class="wrap">
        <h2>Sort Items</h2>
        Simply drag the items up or down and they will be saved in that order.
        
        <?php $courses = new WP_Query( array( 'post_type' => 'course', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
        <table id="sortable-table-itstudy" class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th class="column-order">Order</th>
                    <th class="column-title">Title</th>
                    <th class="column-thumbnail">Thumbnail</th>
         
                </tr>
            </thead>
            <tbody data-post-type="course">
				<?php if( $courses->have_posts() )  : ?>
                    <?php while ($courses->have_posts()): $courses->the_post(); ?>
                        <tr id="post-<?php the_ID(); ?>">
                            <td class="column-order"><img title="" src="<?php echo ITSTUDY_URI . 'assets/images/move-icon.png'; ?>" alt="Move Icon" width="32" height="32" /></td>
                            <td class="column-title"><strong><?php the_title(); ?></strong></td>
                    		<td class="column-thumbnail"><?php the_post_thumbnail( 'small' ); ?></td>
                         </tr>
                    <?php endwhile; ?>
                <?php else : ?>        
                    <p>No course items found, make sure you <a href="post-new.php?post_type=course">create one</a>.</p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>	
            </tbody>
            <tfoot>
                <tr>
                    <th class="column-order">Order</th>
                    <th class="column-title">Title</th>
                    <th class="column-thumbnail">Thumbnail</th>
                </tr>
            </tfoot>
        </table>
 	</div>
	<pre>
	<!-- .wrap -->	
	<?php 
}

/**
 * Callback function for add_submenu_page function
 * Returns the output for the sorting lessons
 *
 * @access public
 * @return void
 */
function itstudy_lesson_order_page() 
{
	?></pre>
	<div class="wrap">
        <h2>Sort Items</h2>
        Simply drag the items up or down and they will be saved in that order.
        
        <?php $lessons = new WP_Query( array( 'post_type' => 'lesson', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
        <table id="sortable-table-itstudy" class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th class="column-order">Order</th>
                    <th class="column-title">Title</th>
                    <th class="column-thumbnail">Course</th>
         
                </tr>
            </thead>
            <tbody data-post-type="lesson">
				<?php if( $lessons->have_posts() )  : ?>
                    <?php while ($lessons->have_posts()): $lessons->the_post(); ?>
                        <tr id="post-<?php the_ID(); ?>">
                            <td class="column-order"><img title="" src="<?php echo ITSTUDY_URI . 'assets/images/move-icon.png'; ?>" alt="Move Icon" width="32" height="32" /></td>
                            <td class="column-title"><strong><?php the_title(); ?></strong></td>
                            <td class="column-title">
                                <?php
                                $course_id=get_post_meta(get_the_ID(), 'lesson_parent_course', true);
                                $course=  get_post($course_id);
                                echo $course->post_title;
                                ?>
                            </td>
                         </tr>
                    <?php endwhile; ?>
                <?php else : ?>        
                    <p>No Lesson items found, make sure you <a href="post-new.php?post_type=lesson">create one</a>.</p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>	
            </tbody>
            <tfoot>
                <tr>
                    <th class="column-order">Order</th>
                    <th class="column-title">Title</th>
                    <th class="column-thumbnail">Course</th>
                </tr>
            </tfoot>
        </table>
 	</div>
	<pre>
	<!-- .wrap -->	
	<?php 
}
/**
 * Handle function for AJAX
 * Saves the order of sorted courses
 *
 * @access public
 * @return void
 */
function itstudy_itstudy_update_post_order() {
	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	if ($post_type !== "course") {
		wp_die("YOU NEED PERMISSIONS FOR THIS KIND OF OPERATION");
	}

	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	wp_die(false);
}


/**
 * Handle function for AJAX
 * Saves the order of sorted Lessons
 *
 * @access public
 * @return void
 */
function itstudy_lesson_update_post_order() {
	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	if ($post_type !== "lesson") {
		wp_die("YOU NEED PERMISSIONS FOR THIS KIND OF OPERATION");
	}

	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	wp_die(false);
}
// parent course name in lesson list
add_filter('manage_edit-lesson_columns' , 'add_lesson_columns');
 
function add_lesson_columns($columns) {
    $columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'parnet_course' => __( 'Course' ),
		'date' => __( 'Date' )
	);
    
    return $columns;
}
 
// diplay new column content
add_action('manage_lesson_posts_custom_column' , 'lesson_custom_columns', 10, 2 );
 
function lesson_custom_columns( $column, $post_id ) {
    switch ( $column ) {
 
    case 'parnet_course' :
        $course_id=get_post_meta($post_id, 'lesson_parent_course', true);
        $course=  get_post($course_id);
        echo $course->post_title;
        break;
    }
}


//make new column sortable
add_filter( 'manage_edit-lesson_sortable_columns', 'custom_lesson_sortable_columns' );

function custom_lesson_sortable_columns( $columns ) {

	$columns['parnet_course'] = 'parnet_course';

	return $columns;
}


?>
