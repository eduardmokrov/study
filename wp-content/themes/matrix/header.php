<!doctype html>
<html lang="<?php language_attributes(); ?>">
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
    <!-- Start Header Section -->
    <?php if ($matrix_theme_options['headersticky'] == 1){ ?>
    <div class="hidden-header" style="height: auto !important;"></div>
    <header class="clearfix">
        <?php } else { ?>
        <div class="hidden-header" style="height: 0 auto !important; display: none;"></div>
        <header class="clearfix header1">
            <?php } ?>
            <!-- Start Top Bar --><?php $class = isset($matrix_theme_options['headercolorscheme']) ? $matrix_theme_options['headercolorscheme'] : ' light_header'; ?>
            <?php if ($matrix_theme_options['header_shocial_media_bar']){ ?>
            <div id="container"> <?php if (($matrix_theme_options['site_layout'] == "boxed-page") && ($matrix_theme_options['headersticky'] == 1)){ ?>
                <div class="top-bar top-bar1 top-bar3 <?php echo $class; ?>">
                    <?php } else if (($matrix_theme_options['site_layout'] == "boxed-page") && ($matrix_theme_options['headersticky'] == 0)) { ?>
                    <div class="top-bar top-bar2 <?php echo $class; ?>">
                        <?php } else { ?>
                        <div class="top-bar <?php echo $class; ?>">
                            <?php } ?>
                            <div class="container">
                                <div class="row"><?php
                                    if ($matrix_theme_options['contact_info_header']) {
                                        ?>
                                        <div class="col-md-7">
                                            <!-- Start Contact Info -->
                                            <ul class="contact-details">
                                                <?php if ($matrix_theme_options['contact_address']) { ?>
                                                    <li><a id="con_address" href="#">
                                                    <i class="fa fa-map-marker"></i> <span><?php echo esc_attr($matrix_theme_options['contact_address']); ?></span></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['contact_email']) { ?>
                                                    <li><a id="con_email"
                                                           href="mailto:<?php echo sanitize_email($matrix_theme_options['contact_email']); ?>">
                                                           <i class="fa fa-envelope-o"></i>
                                                           <span><?php echo esc_attr($matrix_theme_options['contact_email']); ?></span></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['contact_phone']) { ?>
                                                    <li><a id="con_phone"
                                                           href="tel:<?php echo esc_attr($matrix_theme_options['contact_phone']); ?>">
                                                           <i class="fa fa-phone"></i> <span><?php echo esc_attr($matrix_theme_options['contact_phone']); ?></span></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <!-- End Contact Info -->
                                        </div><!-- .col-md-7 -->
                                    <?php
                                    } ?>
                                    <?php if ($matrix_theme_options['social_media_header']) { ?>
                                        <div class="col-md-5">
                                            <!-- Start Social Links -->
                                            <ul id="social-list-header" class="social-list">
                                                <?php if ($matrix_theme_options['social_facebook_link'] != '') { ?>
                                                    <li>
                                                        <a class="facebook itl-tooltip" data-placement="bottom"
                                                           title="Facebook"
                                                           href="<?php echo esc_url($matrix_theme_options['social_facebook_link']); ?>">
                                                            <i class="fa fa-facebook"></i></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['social_twitter_link'] != '') { ?>
                                                    <li>
                                                        <a class="twitter itl-tooltip" data-placement="bottom"
                                                           title="Twitter"
                                                           href="<?php echo esc_url($matrix_theme_options['social_twitter_link']); ?>">
                                                            <i class="fa fa-twitter"></i></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['social_google_plus_link'] != '') { ?>
                                                    <li>
                                                        <a class="google itl-tooltip" data-placement="bottom"
                                                           title="Google Plus"
                                                           href="<?php echo esc_url($matrix_theme_options['social_google_plus_link']); ?>">
                                                            <i class="fa fa-google-plus"></i></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['social_dribble_link'] != '') { ?>
                                                    <li>
                                                        <a class="dribbble itl-tooltip" data-placement="bottom"
                                                           title="Dribble"
                                                           href="<?php echo esc_url($matrix_theme_options['social_dribble_link']); ?>">
                                                            <i class="fa fa-dribbble"></i></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['social_linkedin_link'] != '') { ?>
                                                    <li>
                                                        <a class="linkdin itl-tooltip" data-placement="bottom"
                                                           title="Linkedin"
                                                           href="<?php echo esc_url($matrix_theme_options['social_linkedin_link']); ?>">
                                                            <i class="fa fa-linkedin"></i></a>
                                                    </li>
                                                <?php }
                                                if ($matrix_theme_options['social_instagram_link'] != '') { ?>
                                                    <li>
                                                        <a class="instgram itl-tooltip" data-placement="bottom"
                                                           title="Instagram"
                                                           href="<?php echo esc_url($matrix_theme_options['social_instagram_link']); ?>">
                                                            <i class="fa fa-instagram"></i></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <!-- End Social Links -->
                                        </div><!-- .col-md-6 -->
                                    <?php } ?>
                                </div>
                                <!-- .row -->
                            </div>
                            <!-- .container -->
                        </div>
                        <!-- .top-bar -->
                        <?php } ?>
                        <!-- End Top Bar -->
                        <!-- Start  Logo & Naviagtion  -->
                        <div class="navbar navbar-default navbar-top <?php echo $class; ?>"
                             style="<?php if (get_header_image()) : ?> background-image:url('<?php header_image();?>');<?php elseif (get_header_textcolor()): ?>background-color:#<?php header_textcolor(); endif; ?>">
                            <div class="container abc">
                                <div class="navbar-header" <?php if ($matrix_theme_options['logo_layout'] == "right") {
                                    echo 'style="float:right;"';
                                } ?>>
                                    <!-- Stat Toggle Nav Link For Mobiles -->
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <!-- End Toggle Nav Link For Mobiles -->
                                    <a id="alogo" class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                                        <?php $header_text = display_header_text();
										if(isset($matrix_theme_options['upload_custom_logo']) && $matrix_theme_options['upload_custom_logo'] != "") { ?>
                                            <img id="logo" alt="Matrix"
                                                 src="<?php echo esc_url($matrix_theme_options['upload_custom_logo']); ?>"
                                                 alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"
                                                 height="<?php echo $matrix_theme_options['logo_height']; ?>px"
                                                 width="<?php echo $matrix_theme_options['logo_width']; ?>px"/>
                                        <?php }elseif($header_text)
										{ echo get_bloginfo('name');
										  echo '<p>' . get_bloginfo('description') . '</p>'; } ?>
                                    </a>
                                </div>
                                <div class="navbar-collapse collapse" <?php if ($matrix_theme_options['logo_layout'] == "right") {
                                    echo 'style="float:left !important;"';
                                } ?>>
                                    <!-- End Search -->
                                    <!-- Start Navigation List -->
                                    <?php wp_nav_menu(array(
                                            'theme_location' => 'primary',
                                            'menu_class' => 'nav navbar-nav navbar-right',
                                            'fallback_cb' => 'matrix_fallback_page_menu',
                                            'walker' => new matrix_nav_walker(),
                                        )
                                    ); ?>
                                    <!-- End Navigation List -->
                                </div>
                            </div>
							<!-- Start Mobile Menu -->
							<?php wp_nav_menu(array(
									'theme_location' => 'primary',
									'menu_class' => 'wpb-mobile-menu',
									'fallback_cb' => 'matrix_fallback_page_menu',
									'walker' => new matrix_nav_walker(),
								)
							); ?>
							<div class="abcd"></div>
							<!-- End Mobile Menu -->
                        </div>
                        <!-- End Header Logo & Naviagtion -->
        </header>
        <!-- End Header Section -->