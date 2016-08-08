<!-- Start Page Banner -->

<div class="page-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><?php if(is_home()){ echo 'Home'; } else { the_title(); } ?></h2>
                <?php if (get_post_meta(get_the_ID(), 'post_page_description', true)) { ?>
                    <p><?php echo esc_attr(get_post_meta(get_the_ID(), 'post_page_description', true)); ?></p>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <!-- BreadCrumb -->
                <?php if (function_exists('matrix_breadcrumbs')) matrix_breadcrumbs(); ?>
                <!-- BreadCrumb -->
            </div>
        </div>
    </div>
</div>
<!-- End Page Banner -->
<?php
global $current_user;
if(is_user_logged_in()) : ?>

<div class="row">
    <div class="container user-banner">
        <div class="col-md-4 course-progress">
            <h4>cource progress</h4>
        </div>
        <div class="col-md-4 user-nots text-center">
            <h4>Open Notice</h4>
        </div>
        <div class="col-md-4 user-info text-right">
            <h4><?php echo 'Hello '.$current_user->first_name; ?></h4>
        </div>
    </div>
</div>

<?php endif;?>