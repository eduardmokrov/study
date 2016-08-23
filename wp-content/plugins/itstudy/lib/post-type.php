<?php
/**
 * File for registering custom post types.
 * @package itstudy
 * @subpackage lib
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Itstudy_post_type_course
{	
	function __construct()
	{
		/* Register custom post types on the 'init' hook. */
		add_action( 'init', array( &$this, 'itstudy_register_post_type' ) );	
	}

	/**
	 * Registers post types needed by the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function itstudy_register_post_type() {

		/* Get the plugin settings. */
		$settings_course = course_get_default_settings();

		/* Set up the arguments for the itstudy item post type. */
		$args = array(
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => null,
			'menu_icon'           => 'dashicons-book',
			'can_export'          => true,
			'hierarchical'        => false,
			'has_archive'         => $settings_course['course_root'],
			'query_var'           => 'course',
			'capability_type'     => 'course',
			'map_meta_cap'        => false,
			'capabilities' => array(

				// meta caps (don't assign these to roles)
				'edit_post'              => 'edit_course_items',
				'read_post'              => 'read_course_items',
				'delete_post'            => 'delete_course_items',

				// primitive caps used outside of map_meta_cap()
				'edit_posts'             => 'edit_course_items',
				'edit_others_posts'      => 'edit_course_items',
				'publish_posts'          => 'read_course_items',
				'read_private_posts'     => 'read_course_items',

				// primitive caps used inside of map_meta_cap()
				'read'                   => 'read_course_items',
				'delete_posts'           => 'delete_course_items',
				'delete_private_posts'   => 'delete_course_items',
				'delete_published_posts' => 'delete_course_items',
				'delete_others_posts'    => 'delete_course_items',
				'edit_private_posts'     => 'edit_course_items',
				'edit_published_posts'   => 'edit_course_items'
			),

			/* The rewrite handles the URL structure. */
			'rewrite' => false,/*array(
				'slug'       => !empty( $settings['itstudy_item_base'] ) ? "{$settings['itstudy_root']}/{$settings['itstudy_item_base']}" : $settings['itstudy_root'],
				'with_front' => false,
				'pages'      => true,
				'feeds'      => true,
				'ep_mask'    => EP_PERMALINK,
			),
                         * 
                         */

			/* What features the post type supports. */
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions'
			),

			/* Labels used when displaying the posts. */
			'labels' => array(
				'name'               => __( 'Course Items',                   ITSTUDY_DOMAIN ),
				'singular_name'      => __( 'Course Item',                    ITSTUDY_DOMAIN ),
				'menu_name'          => __( 'Course',                         ITSTUDY_DOMAIN ),
				'name_admin_bar'     => __( 'Course Item',                    ITSTUDY_DOMAIN ),
				'add_new'            => __( 'Add New',                           ITSTUDY_DOMAIN ),
				'add_new_item'       => __( 'Add New Course Item',            ITSTUDY_DOMAIN ),
				'edit_item'          => __( 'Edit Course Item',               ITSTUDY_DOMAIN ),
				'new_item'           => __( 'New Course Item',                ITSTUDY_DOMAIN ),
				'view_item'          => __( 'View Course Item',               ITSTUDY_DOMAIN ),
				'search_items'       => __( 'Search Course',                  ITSTUDY_DOMAIN ),
				'not_found'          => __( 'No course items found',          ITSTUDY_DOMAIN ),
				'not_found_in_trash' => __( 'No course items found in trash', ITSTUDY_DOMAIN ),
				'all_items'          => __( 'Course Items',                   ITSTUDY_DOMAIN ),
			)
		);

		/**
		 * Itstudy update messages.
		 *
		 * See /wp-admin/edit-form-advanced.php
		 *
		 * @param array $messages Existing itstudy update messages.
		 *
		 * @return array Amended itstudy update messages with new CPT update messages.
		 */
		function course_updated_messages( $messages ) {
			$post             = get_post();
			$post_type        = get_post_type( $post );
			$post_type_object = get_post_type_object( $post_type );

			$messages['course'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Course Item updated.', ITSTUDY_DOMAIN ),
				2  => __( 'Custom field updated.', ITSTUDY_DOMAIN ),
				3  => __( 'Custom field deleted.', ITSTUDY_DOMAIN ),
				4  => __( 'Course Item updated.', ITSTUDY_DOMAIN ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Course Item restored to revision from %s', ITSTUDY_DOMAIN ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => __( 'Course Item published.', ITSTUDY_DOMAIN ),
				7  => __( 'Course Item saved.', ITSTUDY_DOMAIN ),
				8  => __( 'Course Item submitted.', ITSTUDY_DOMAIN ),
				9  => sprintf(
					__( 'Course Item scheduled for: <strong>%1$s</strong>.', ITSTUDY_DOMAIN ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', ITSTUDY_DOMAIN ), strtotime( $post->post_date ) )
				),
				10 => __( 'Course Item draft updated.', ITSTUDY_DOMAIN )
			);

			if ( $post_type_object->publicly_queryable ) {
				$permalink = get_permalink( $post->ID );

				$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Course Item', ITSTUDY_DOMAIN ) );
				$messages['course'][1] .= $view_link;
				$messages['course'][6] .= $view_link;
				$messages['course'][9] .= $view_link;

				$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
				$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Course Item', ITSTUDY_DOMAIN ) );
				$messages['course'][8]  .= $preview_link;
				$messages['course'][10] .= $preview_link;
			}

			return $messages;
		}

		/* Register the itstudy item post type. */
		register_post_type( 'course', $args );
		add_filter( 'post_updated_messages', 'course_updated_messages' );
	}
}

new Itstudy_post_type_course;

class Itstudy_post_type_lesson
{	
	function __construct()
	{
		/* Register custom post types on the 'init' hook. */
		add_action( 'init', array( &$this, 'itstudy_register_post_type' ) );	
	}

	/**
	 * Registers post types needed by the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function itstudy_register_post_type() {

		/* Get the plugin settings. */
		$settings_lesson = lesson_get_default_settings();

		/* Set up the arguments for the itstudy item post type. */
		$args = array(
			'description'         => '',
			'public'              => true,
			'publicly_queryable'  => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=course',
			'menu_position'       => null,
			'menu_icon'           => '',
			'can_export'          => true,
			'hierarchical'        => false,
			'has_archive'         => $settings_lesson['lesson_root'],
			'query_var'           => 'lesson',
			'capability_type'     => 'lesson',
			'map_meta_cap'        => false,
			'capabilities' => array(

				// meta caps (don't assign these to roles)
				'edit_post'              => 'edit_lesson_items',
				'read_post'              => 'read_lesson_items',
				'delete_post'            => 'delete_lesson_items',

				// primitive caps used outside of map_meta_cap()
				'edit_posts'             => 'edit_lesson_items',
				'edit_others_posts'      => 'edit_lesson_items',
				'publish_posts'          => 'read_lesson_items',
				'read_private_posts'     => 'read_lesson_items',

				// primitive caps used inside of map_meta_cap()
				'read'                   => 'read_lesson_items',
				'delete_posts'           => 'delete_lesson_items',
				'delete_private_posts'   => 'delete_lesson_items',
				'delete_published_posts' => 'delete_lesson_items',
				'delete_others_posts'    => 'delete_lesson_items',
				'edit_private_posts'     => 'edit_lesson_items',
				'edit_published_posts'   => 'edit_lesson_items'
			),

			/* The rewrite handles the URL structure. */
			'rewrite' => false,/*array(
				'slug'       => !empty( $settings['itstudy_item_base'] ) ? "{$settings['itstudy_root']}/{$settings['itstudy_item_base']}" : $settings['itstudy_root'],
				'with_front' => false,
				'pages'      => true,
				'feeds'      => true,
				'ep_mask'    => EP_PERMALINK,
			),
                         * 
                         */

			/* What features the post type supports. */
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions'
			),

			/* Labels used when displaying the posts. */
			'labels' => array(
				'name'               => __( 'Lesson Items',                   ITSTUDY_DOMAIN ),
				'singular_name'      => __( 'Lesson Item',                    ITSTUDY_DOMAIN ),
				'menu_name'          => __( 'Lesson',                         ITSTUDY_DOMAIN ),
				'name_admin_bar'     => __( 'Lesson Item',                    ITSTUDY_DOMAIN ),
				'add_new'            => __( 'Add New',                           ITSTUDY_DOMAIN ),
				'add_new_item'       => __( 'Add New Lesson Item',            ITSTUDY_DOMAIN ),
				'edit_item'          => __( 'Edit Lesson Item',               ITSTUDY_DOMAIN ),
				'new_item'           => __( 'New Lesson Item',                ITSTUDY_DOMAIN ),
				'view_item'          => __( 'View Lesson Item',               ITSTUDY_DOMAIN ),
				'search_items'       => __( 'Search Lesson',                  ITSTUDY_DOMAIN ),
				'not_found'          => __( 'No lesson items found',          ITSTUDY_DOMAIN ),
				'not_found_in_trash' => __( 'No lesson items found in trash', ITSTUDY_DOMAIN ),
				'all_items'          => __( 'Lesson Items',                   ITSTUDY_DOMAIN ),
			)
		);

		/**
		 * Itstudy update messages.
		 *
		 * See /wp-admin/edit-form-advanced.php
		 *
		 * @param array $messages Existing itstudy update messages.
		 *
		 * @return array Amended itstudy update messages with new CPT update messages.
		 */
		function lesson_updated_messages( $messages ) {
			$post             = get_post();
			$post_type        = get_post_type( $post );
			$post_type_object = get_post_type_object( $post_type );

			$messages['lesson'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Lesson Item updated.', ITSTUDY_DOMAIN ),
				2  => __( 'Lesson field updated.', ITSTUDY_DOMAIN ),
				3  => __( 'Lesson field deleted.', ITSTUDY_DOMAIN ),
				4  => __( 'Lesson Item updated.', ITSTUDY_DOMAIN ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Lesson Item restored to revision from %s', ITSTUDY_DOMAIN ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => __( 'Lesson Item published.', ITSTUDY_DOMAIN ),
				7  => __( 'Lesson Item saved.', ITSTUDY_DOMAIN ),
				8  => __( 'Lesson Item submitted.', ITSTUDY_DOMAIN ),
				9  => sprintf(
					__( 'Lesson Item scheduled for: <strong>%1$s</strong>.', ITSTUDY_DOMAIN ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', ITSTUDY_DOMAIN ), strtotime( $post->post_date ) )
				),
				10 => __( 'Lesson Item draft updated.', ITSTUDY_DOMAIN )
			);

			if ( $post_type_object->publicly_queryable ) {
				$permalink = get_permalink( $post->ID );

				$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Lesson Item', ITSTUDY_DOMAIN ) );
				$messages['lesson'][1] .= $view_link;
				$messages['lesson'][6] .= $view_link;
				$messages['lesson'][9] .= $view_link;

				$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
				$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Lesson Item', ITSTUDY_DOMAIN ) );
				$messages['lesson'][8]  .= $preview_link;
				$messages['lesson'][10] .= $preview_link;
			}

			return $messages;
		}

		/* Register the itstudy item post type. */
		register_post_type( 'lesson', $args );
		add_filter( 'post_updated_messages', 'lesson_updated_messages' );
	}
}

new Itstudy_post_type_lesson;

?>