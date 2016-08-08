<?php /* Template Name: Courses Theme */ ?>
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
