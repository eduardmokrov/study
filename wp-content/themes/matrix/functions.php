<?php
/** Theme Name    : Matrix
 * Theme Core Functions and Codes
 */
define('HEADER_IMAGE_WIDTH', apply_filters('matrix_header_image_width', 1280));
define('HEADER_IMAGE_HEIGHT', apply_filters('matrix_header_image_height', 71));
require(get_template_directory() . '/functions/menu/default_menu_walker.php');
require(get_template_directory() . '/functions/menu/matrix_nav_walker.php');
require(get_template_directory() . '/default_options.php');
require_once(get_template_directory(). '/inc/welcome-screen/welcome-screen.php');
require_once(get_template_directory(). '/inc/class-tgm-plugin-activation.php');
if (!class_exists('Kirki')) {
    include_once(dirname(__FILE__) . '/inc/kirki/kirki.php');
}
function matrix_minimal_customizer_config()
{
    $args = array(
        'url_path' => get_template_directory_uri() . '/inc/kirki/',
        'capability' => 'edit_theme_options',
        'option_type' => 'option',
        'option_name' => 'matrix_theme_options',
        'compiler' => array(),
        'color_accent' => '#27bebe',
        'width' => '23%',
        'description' => 'Visit our site for more great Products.If you like this theme please rate us 5 star',
    );
    return $args;
}

add_filter('kirki/config', 'matrix_minimal_customizer_config');
require(get_template_directory() . '/customizer.php');
function matrix_theme_setup()
{
    global $content_width;
    //content width
    if (!isset($content_width)) $content_width = 848; //px
    //supports featured image
    add_theme_support('post-thumbnails');
    load_theme_textdomain('matrix', get_template_directory() . '/functions/lang');
    /*** Home Blog ***/
    add_image_size('matrix_blog_image', 848, 477, true);
    add_image_size('matrix_single_post_image', 848, 530, true);
    add_image_size('matrix_single_fullwidth_image', 1140, 540, true);
    add_image_size('matrix_home_post_image', 264, 176, true);
	add_image_size('matrix_slider_post', 1440, 500, true);
    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('primary', __('Primary Menu', 'matrix'));
    register_nav_menu('secondary', __('Secondary Menu', 'matrix'));
    add_editor_style();
    $args = array('default-color' => '#ffffff',);
    add_theme_support('custom-background', $args);
    add_theme_support('custom-header', $args);
    add_theme_support('automatic-feed-links');
    add_theme_support('woocommerce');
    add_theme_support('title-tag');

    add_theme_support( 'sensei' );
}

add_action('after_setup_theme', 'matrix_theme_setup');
add_action('wp_enqueue_scripts', 'matrix_enqueue_style');
function matrix_enqueue_style()
{
    $matrix_theme_options = matrix_theme_options();
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css');
    wp_enqueue_style('matrix_main_style', get_stylesheet_uri());
    wp_enqueue_style('matrix_responsive', get_template_directory_uri() . '/css/responsive.css');
    wp_enqueue_style('matrix_color_scheme', get_template_directory_uri() . '/css/colors/' . esc_attr($matrix_theme_options['color_scheme']) . '.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.css');
	wp_enqueue_style('slicknav', get_template_directory_uri() . '/css/slicknav.css');
    wp_enqueue_style('matrix_font_open_sans','//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
    wp_enqueue_style('matrix_font_lora','//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic');
    wp_enqueue_style('matrix_font_raleway','//fonts.googleapis.com/css?family=Raleway:400,300,700');

    
    wp_enqueue_style('chat-styles', get_template_directory_uri() . '/css/chat-styles.css');



    wp_enqueue_script('migrate', get_template_directory_uri() . '/js/jquery.migrate.js', array('jquery'));
    wp_enqueue_script('modernizrr', get_template_directory_uri() . '/js/modernizrr.js');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js');
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'));
    wp_enqueue_script('nivo-lightbox', get_template_directory_uri() . '/js/nivo-lightbox.js');
    wp_enqueue_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array('jquery'));
    wp_enqueue_script('textillate', get_template_directory_uri() . '/js/jquery.textillate.js', array('jquery'));
    wp_enqueue_script('lettering', get_template_directory_uri() . '/js/jquery.lettering.js', array('jquery'));
    wp_enqueue_script('nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.js', array('jquery'));
    wp_enqueue_script('parallax', get_template_directory_uri() . '/js/jquery.parallax.js', array('jquery'));
    wp_enqueue_script('matrix_custom_script', get_template_directory_uri() . '/js/script.js', array('jquery'));
    wp_enqueue_script('jquery-slicknav', get_template_directory_uri() . '/js/jquery.slicknav.js', array('jquery'));
    

    if (is_page_template('home-page.php')) {
        /** Home Blog **/
        wp_enqueue_script('carouFredSel', get_template_directory_uri() . '/js/carouFredSel-6.2.1/jquery.carouFredSel-6.2.1.js');
        wp_enqueue_script('matrix-carouFredSel', get_template_directory_uri() . '/js/carouFredSel-6.2.1/carousalFredSel.js');
    }
}

if (is_singular()) wp_enqueue_script("comment-reply");
// Read more tag to formatting in blog page
function matrix_content_more($read_more)
{
    return '<div class=""><a class="main-button" href="' . esc_url(get_permalink()) . '">' . __('Read More', 'matrix') . '<i class="fa fa-angle-right"></i></a></div>';
}

add_filter('the_content_more_link', 'matrix_content_more');
// Replaces the excerpt "more" text by a link
function matrix_excerpt_more($more)
{
    return '<div class=""><a class="main-button" href="' . esc_url(get_permalink()) . '">' . __('Read More...', 'matrix') . '</a></div>';
}

add_filter('excerpt_more', 'matrix_excerpt_more');
add_action( 'tgmpa_register', 'matrix_register_required_plugins' );
function matrix_register_required_plugins() {
    $plugins = array(
        // This is an example of how to include a plugin bundled with a theme.
        array(
            'name'               => 'Photo Video Gallery Master', // The plugin name.
            'slug'               => 'photo-video-gallery-master', // The plugin slug (typically the folder name).
            'required'           => false,
        ),
		array(
            'name'     => 'Ultimate Gallery Master', // The plugin name.
            'slug'     => 'ultimate-gallery-master', // The plugin slug (typically the folder name).
            'required' => false,
        ),
    );

    $config = array(
        'id'           => 'matrix',                 // Unique ID for hashing notices for multiple instances of matrix.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'matrix-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );
    matrix( $plugins, $config );
}
?>
<?php
/*
* Matrix widget area
*/
add_action('widgets_init', 'matrix_widget');
function matrix_widget()
{
    /*sidebar*/
    register_sidebar(array(
        'name' => __('Sidebar Widget Area', 'matrix'),
        'id' => 'sidebar-widget',
        'description' => __('Sidebar widget area', 'matrix'),
        'before_widget' => '<div class="widget widget-categories">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '<span class="head-line"></span></h4>'
    ));
    $matrix_theme_options = matrix_theme_options();
    $col = $matrix_theme_options['footer_layout'];
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'matrix'),
        'id' => 'footer-widget',
        'description' => __('Footer widget area', 'matrix'),
        'before_widget' => '<div class="col-md-' . $col . ' col-sm-6">
									<div class="footer-widget mail-subscribe-widget">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4>',
        'after_title' => '<span class="head-line"></span></h4>',
    ));
}

function matrix_comments($comments, $args, $depth)
{
    $GLOBALS['comment'] = $comments;
    extract($args, EXTR_SKIP);
    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <li>
    <div class="comment-box clearfix">
        <div
            class="avatar"> <?php if ($args['avatar_size'] != 0) echo get_avatar($comments, $args['avatar_size']); ?></div>
        <div class="comment-content">
            <div class="comment-meta">
                <span class="comment-by"><?php printf('%s', get_comment_author()); ?></span>
                <?php if ($comments->comment_approved == '0') { ?>
                <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'matrix'); ?></em><br/>
            </div><?php
            }else{
            ?>
            <span
                class="comment-date"><?php printf(__('%1$s at %2$s', 'matrix'), get_comment_date(), get_comment_time()); ?></span>
            <span
                class="reply-link"><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?> </span>
            <?php comment_text(); ?>
        </div><?php } ?>
    </div>

    </div>
<?php } 
/*** Page pagination ***/
function matrix_pagination_link()
{
    ?>
    <div id="pagination">
    <div class="left"><?php previous_post_link('%link'); ?></div>
    <div class="right"><?php next_post_link('%link'); ?></div>
    </div><?php
}

/****--- Navigation for Author, Category , Tag , Archive ---***/
function matrix_pagination()
{
    ?>
    <div id="pagination">
        <?php posts_nav_link(); ?>
    </div>
<?php } ?>
<?php
/* Breadcrumbs  */
function matrix_breadcrumbs()
{
    $delimiter = '';
    $home = __('Home', 'matrix'); // text for the 'Home' link
    $before = '<li>'; // tag before the current crumb
    $after = '</li>'; // tag after the current crumb
    echo '<ul class="breadcrumbs">';
    global $post;
    $homeLink = home_url();
    echo '<li><a href="' . esc_url($homeLink) . '">' . $home . '</a></li>' . $delimiter . ' ';
    if (is_category()) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0)
            echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
        echo $before . __("Posts by category: ", "matrix") . single_cat_title('', false) . $after;
    } elseif (is_day()) {
        echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo '<li><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;
    } elseif (is_month()) {
        echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;
    } elseif (is_year()) {
        echo $before . get_the_time('Y') . $after;
    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
            echo $before . esc_attr(get_the_title()) . $after;
        } else {
            $cat = get_the_category();
            $cat = $cat[0];
            //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo $before . esc_attr(get_the_title()) . $after;
        }

    } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
        $post_type = get_post_type_object(get_post_type());
        echo $before . $post_type->labels->singular_name . $after;
    } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        $cat = get_the_category($parent->ID);
        $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
    } elseif (is_page() && !$post->post_parent) {
        echo $before . get_the_title() . $after;
    } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_attr(get_the_title($page->ID)) . '</a></li>';
            $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb)
            echo $crumb . ' ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
    } elseif (is_search()) {
        echo $before . __('Search results for: ', 'matrix') . '"' . esc_attr(get_search_query()) . '"' . $after;

    } elseif (is_tag()) {
        echo $before . __('Tag', 'matrix') . single_tag_title('', false) . $after;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo $before . __('Articles posted by', 'matrix') . esc_attr($userdata->display_name) . $after;
    } elseif (is_404()) {
        echo $before . __('Error 404', 'matrix') . $after;
    }
    echo '</ul>';
}
$matrix_theme_options = matrix_theme_options();
if($matrix_theme_options['portfolio_four_column']){
	add_action('wp_footer','matrix_enqueue_in_footer');
	function matrix_enqueue_in_footer(){
		echo '<style>@media (min-width: 992px) { .wl-gallery{ width:24.9%;} }</style>';
	}
}


/* woocomerce */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'kyma_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'kyma_theme_wrapper_end', 10);
function kyma_theme_wrapper_start()
{
    get_template_part('header_call_out');
    echo ' <div id="content">
			<div class="container">
				<div class="col-md-12 blog-box">';
}
function kyma_theme_wrapper_end()
{
    ?>
    </div>
    </div>
    </div>
<?php
}?>

<?php 
global $woothemes_sensei;
remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

add_action('sensei_before_main_content', 'my_theme_wrapper_start', 10);
add_action('sensei_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<div id="container"><div id="content" role="main">';
}

function my_theme_wrapper_end() {
  echo '</div><!-- #content -->
    </div><!-- #container -->';
    get_sidebar();
}