<?php
/**
 * Unit Template Name: Full-width course unit
 *
 * Be sure to use the "Unit Template Name:" in the header.
 * To display the course unit content, be sure to inclue the loop.
 */

?>
<!doctype html>
<html id="quizhtml" lang="<?php language_attributes(); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- Full Body Container -->
<?php $matrix_theme_options = matrix_theme_options(); ?>
<div id="container" <?php if ($matrix_theme_options['site_layout'] == "boxed-page") {
    echo "class='boxed-page boxed-page1 top-bar1'";
} ?> >
    <!-- Start Content -->
    <div id="quizcontent">
        <div class="container">
            <div class="row blog-post-page">
                <?php $matrix_theme_options = matrix_theme_options('matrix_theme_options');
                $post_layout = $matrix_theme_options['post_layout']; ?>
                <?php if ($post_layout == "leftsidebar") {
                    get_sidebar();
                    $page_width = 'col-md-9';
                    $imgsize = 'matrix_single_post_image';
                } elseif ($post_layout == "fullwidth") {
                    $page_width = 'col-md-12';
                    $imgsize = 'matrix_single_fullwidth_image';
                } elseif ($post_layout == "rightsidebar") {
                    $page_width = 'col-md-9';
                    $imgsize = 'matrix_single_post_image';
                } ?>
                <div class="<?php echo esc_attr($page_width); ?> blog-box">
                    <!-- Start Single Post Area -->
                    <div class="blog-post gallery-post">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) {
                                the_post();
                                $icon = 'fa fa-pencil'; ?>
                                <div class="post-head">
                                    <!--If post has gallery--><?php
                                    if (get_post_gallery()) {
                                        $icon = 'fa fa-picture-o'; ?>
                                        <div class="touch-slider post-slider"><?php
                                        $gallery_thumb = get_post_gallery(get_the_ID(), false);
                                        if (has_post_thumbnail()) {
                                            $img_class = array('class' => 'img-responsive');
                                            $post_thumb_id = get_post_thumbnail_id();
                                            $post_thumb_url = wp_get_attachment_image_src($post_thumb_id, true);    ?>
                                            <div class="item">
                                            <a class="lightbox" title="<?php the_title_attribute(); ?>"
                                               href="<?php echo esc_url($post_thumb_url[0]); ?>"
                                               data-lightbox-gallery="gallery1">
                                                <div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div><?php
                                                the_post_thumbnail($imgsize, $img_class); ?>
                                            </a>
                                            </div><?php
                                        }
                                        foreach ($gallery_thumb['src'] as $src_img) {
                                            ?>
                                            <div class="item">
                                            <a class="lightbox" title="<?php the_title_attribute(); ?>"
                                               href="<?php echo esc_url($src_img); ?>" data-lightbox-gallery="gallery1">
                                                <div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div>
                                                <img src="<?php echo esc_url($src_img); ?>"
                                                     alt="<?php the_title_attribute(); ?>" height="476px"/>
                                            </a>
                                            </div><?php
                                        } ?>
                                        </div><?php
                                    } elseif (has_post_thumbnail()) {
                                        $icon = 'fa fa-picture-o';
                                        $img_class = array('class' => 'img-responsive');
                                        $post_thumb_id = get_post_thumbnail_id();
                                        $post_thumb_url = wp_get_attachment_image_src($post_thumb_id, true);    ?>
                                    <a class="lightbox" title="This is an image title"
                                       href="<?php echo esc_url($post_thumb_url[0]); ?>">
                                        <div class="thumb-overlay"><i class="fa fa-arrows-alt"></i></div><?php
                                        the_post_thumbnail($imgsize, $img_class); ?>
                                        </a><?php
                                    } ?>

                                </div>
                                <!-- End Single Post (Gallery) -->

                                <!-- Start Single Post Content -->
                                <div class="post-content">
                                    <div class="post-type"><i class="<?php echo esc_attr($icon); ?>"></i></div>
                                    <h2><?php the_title(); ?></h2>
                                    <ul class="post-meta">
                                        <li><?php _e('By', 'matrix'); ?> <a
                                                href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                                        </li>
                                        <li><?php echo esc_attr(get_the_date(get_option('date_format')), true); ?></li>
                                        <?php $cat_list = get_the_category_list();
                                        if (!empty($cat_list)) {
                                            ?>
                                            <li><?php the_category(' , '); ?></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>"><?php comments_number('0 Comments', '1 Comments', '% Comments'); ?></a>
                                        </li>
                                    </ul>
                                    <p><?php the_content(); ?></p>

                                                   
                                </div>
                            <?php }
                        } ?>
                        <!-- End Single Post Content -->
                        <?php
                        matrix_pagination_link(); ?>
                    </div>
                    <!-- End Single Post Area -->