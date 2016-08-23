<?php
/**
 * template for siplaying lessons
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();
the_title();
while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; 
get_footer();
