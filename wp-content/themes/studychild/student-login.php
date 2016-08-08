<?php
get_header();
$regurl=CoursePress::instance()->get_signup_slug( true );
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <div class="login-form custom-login">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php echo do_shortcode( '[wppb-login]' );?>
                <div class="login_links">
                    <a href="<?php echo $regurl;?>" class="reg_link"><?php _e( 'Register', 'coursepress' ); ?></a> 
                    <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot_link"><?php _e( 'Forgot Password?', 'coursepress' ); ?></a>
                </div>
               
            </div>
        </div>
    </div>
    </main>
</div>
<?php get_footer();?>

