<?php
get_header();
get_template_part('header', 'banner');
?>
    <!-- Start Content -->
    <div id="content">
        <div class="container">
            <?php the_post(); ?>
            <div class="row">
            <?php  if ( sensei_can_user_view_lesson() ) :?>
                <div class="col-md-6">
                    <div id="cometchat_embed_chatrooms_container" style="display:inline-block; border:1px solid #CCCCCC;"></div>
                    <script src="<?php echo home_url().'/cometchat/js.php?type=core&name=embedcode';?>" type="text/javascript"></script>
                    <script>
                        var iframeObj = {};iframeObj.module="chatrooms";iframeObj.src="<?php echo home_url().'/cometchat/modules/chatrooms/index.php';?>";
                        iframeObj.width="600";
                        iframeObj.height="300";
                        if(typeof(addEmbedIframe)=="function"){addEmbedIframe(iframeObj);}
                        </script>
                </div>
                <div class="col-md-6 page-content">
                    <article <?php post_class( array( 'lesson', 'post' ) ); ?>>
                        <section class="entry fix">
                            <?php
                            
                                if( apply_filters( 'sensei_video_position', 'top', $post->ID ) == 'top' ) {
                                    do_action( 'sensei_lesson_video', $post->ID );
                                }
                                the_content();
                            ?>
                        </section>
                        <?php
                            /**
                             * Hook inside the single lesson template after the content
                             *
                             * @since 1.9.0
                             *
                             * @param integer $lesson_id
                             *
                             * @hooked Sensei()->frontend->sensei_breadcrumb   - 30
                             */
                            do_action( 'sensei_single_lesson_content_inside_after', get_the_ID() );
                        ?>
                        <div class="quizzes">
                            <?php
                                $args = array(
                                        'post_type'=>'question',
                                        'meta_query' => array(
                                            'meta_key' => 'quiz_lesson',
                                            'meta_value'  => get_the_ID()
                                            ),
                                    );
                                $query = new WP_Query( $args );

                                   if ( $query->have_posts() ) {
                                    echo '<ul>';
                                    while ( $query->have_posts() ) {
                                        $query->the_post();
                                        echo '<li>' . get_the_title() . '</li>';
                                    }
                                    echo '</ul>';
                                    /* Restore original Post Data */
                                   // wp_reset_postdata();
                                } else {
                                    echo 'no posts found';
                                }
                            ?>
                        </div>
                    </article>
                    <?php comments_template( '/comments.php' ); ?> 
                </div>
            <?php else :  ?>
                <?php  _e('To view Lesson content you must log in', 'matrix');?>
                <a href="<?php echo wp_login_url();?>">Login</a>
            <?php endif;?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>