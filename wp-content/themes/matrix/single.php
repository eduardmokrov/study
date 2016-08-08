<?php get_header();
get_template_part('header', 'banner'); ?>
    <!-- Start Content -->
    <div id="content">
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

                                    <div class="post-bottom clearfix">
                                        <?php
                                        wp_link_pages();
                                        if (get_the_tag_list() != '') {
                                            ?>
                                            <div class="post-tags-list">
                                                <?php the_tags(); ?>
                                            </div>
                                        <?php } ?>
                                        <div class="post-share">
                                            <span><?php _e('Post Media Link', 'matrix'); ?></span><?php
                                            global $wp;
                                            $current_url = home_url(add_query_arg(array(), $wp->request)); ?>
                                            <a class="facebook"
                                               href="https://www.facebook.com/dialog/feed?app_id=694165360698061&link=<?php echo esc_url($current_url); ?>&picture=<?php if (!empty($post_thumb_url)) {
                                                   echo esc_url($post_thumb_url[0]);
                                               } ?>&name=<?php the_title(); ?>&caption=%20&description=<?php echo esc_attr(get_post_meta(get_the_ID(), 'portfolio_detail_description', 'true')); ?>&redirect_uri=http%3A%2F%2Fwww.facebook.com%2F"><i
                                                    class="fa fa-facebook"></i></a>
                                            <a class="twitter"
                                               href="https://twitter.com/home?status=<?php the_title(); ?>"><i
                                                    class="fa fa-twitter"></i></a>
                                            <a class="gplus"
                                               href="https://plus.google.com/share?url=<?php echo esc_url($current_url); ?>"><i
                                                    class="fa fa-google-plus"></i></a>
                                            <a class="linkedin"
                                               href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url($current_url); ?>/&title=<?php the_title(); ?>&summary=<?php echo esc_attr(get_post_meta(get_the_ID(), 'portfolio_detail_description', 'true')); ?>&source="><i
                                                    class="fa fa-linkedin"></i></a>
                                            
                                        </div>
                                    </div>
                                    <div class="author-info clearfix">
                                        <div class="author-image">
                                            <a href="<?php the_permalink(); ?>"><?php echo get_avatar(get_the_author_meta('ID'), 94); ?></a>
                                        </div>
                                        <div class="author-bio">
                                            <h4><?php the_author(); ?></h4>

                                            <p><?php the_author_meta('description'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                        <!-- End Single Post Content -->
                        <?php
                        matrix_pagination_link(); ?>
                    </div>
                    <!-- End Single Post Area -->
                    <?php comments_template('', true); ?>
                </div>
                <?php if ($post_layout == "rightsidebar") {
                    get_sidebar();
                } ?>
            </div>
        </div>
    </div>
    <!-- End content -->
<?php get_footer(); ?>