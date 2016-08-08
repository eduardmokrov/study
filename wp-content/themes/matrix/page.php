<?php
get_header();
get_template_part('header', 'banner');
?>
    <!-- Start Content -->
    <div id="content">
        <div class="container">
            <?php the_post(); ?>
            <div class="row sidebar-page">
                <!-- Page Content -->
                <div class="col-md-12 page-content">
                    <!-- Classic Heading -->
                    <h4 class="classic-title"><span><?php the_title(); ?></span></h4>
                    <?php the_content(); ?>
                    <!-- Divider -->
                    <div class="hr5" style="margin-top:30px; margin-bottom:45px;"></div>
                    <?php comments_template('', true); ?>
                </div>
                <!-- End Page Content-->
                <?php //get_sidebar(); ?>
            </div>
        </div>
    </div>
    <!-- End Content -->
<?php get_footer(); ?>