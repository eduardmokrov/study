<?php /* Template Name: UI Learning Theme */ ?>
<?php
get_header();
?>
    <!-- Start Content -->
    <div id="content">
        <div class="container">
            <?php the_post(); ?>
            <div class="row sidebar-page">
                <!-- Page Content -->
                <div class="col-md-9 page-content">
                    <!-- Classic Heading -->
                    <?php the_content(); ?>
     
                </div>

            </div>
        </div>
    </div>
    <!-- End Content -->
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
<div id="loader">
    <div class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
    </div>
</div>