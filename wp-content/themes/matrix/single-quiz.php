<?php
/**
 * The Template for displaying all Quiz Questions.
 *
 * Override this template by copying it to yourtheme/sensei/single-quiz.php
 *
 * @author 		Automattic
 * @package 	Sensei
 * @category    Templates
 * @version     1.9.0
 */
?>
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
<article <?php post_class(); ?>>

    <?php

        /**
         * Hook inside the single quiz post above the content
         *
         * @since 1.9.0
         *
         * @hooked Sensei_Quiz::the_title               - 20
         * @hooked Sensei_Quiz::the_user_status_message - 40
         * @param integer $quiz_id
         *
         */
        do_action( 'sensei_single_quiz_content_inside_before', get_the_ID() );

    ?>

	<?php if ( sensei_can_user_view_lesson() ) : ?>

		<section class="entry quiz-questions">

	        <?php if ( sensei_quiz_has_questions() ): ?>

	            <form method="POST" action="<?php echo esc_url_raw( get_permalink() ); ?>" enctype="multipart/form-data">

	                <?php

	                    /**
	                     * Action inside before the question content on single-quiz page
	                     *
	                     * @hooked WooThemes_Sensei_Quiz::the_user_status_message  - 10
	                     *
	                     * @param string $the_quiz_id
	                     */
	                    do_action( 'sensei_single_quiz_questions_before', get_the_id() );

	                ?>



	                <ol id="sensei-quiz-list">

	                <?php while ( sensei_quiz_has_questions() ): sensei_setup_the_question(); ?>

	                    <li class="<?php sensei_the_question_class();?>">

	                        <?php

	                            /**
	                             * Action inside before the question content on single-quiz page
	                             *
	                             * @hooked WooThemes_Sensei_Question::the_question_title        - 10
	                             * @hooked WooThemes_Sensei_Question::the_question_description  - 20
	                             * @hooked WooThemes_Sensei_Question::the_question_media        - 30
	                             * @hooked WooThemes_Sensei_Question::the_question_hidden_field - 40
	                             *
	                             * @since 1.9.0
	                             * @param string $the_question_id
	                             */
	                            do_action( 'sensei_quiz_question_inside_before', sensei_get_the_question_id() );

	                        ?>

	                        <?php sensei_the_question_content(); ?>

	                        <?php

	                            /**
	                             * Action inside before the question content on single-quiz page
	                             *
	                             * @hooked WooThemes_Sensei_Question::answer_feedback_notes
	                             *
	                             * @param string $the_question_id
	                             */
	                            do_action( 'sensei_quiz_question_inside_after', sensei_get_the_question_id() );

	                        ?>

	                    </li>

	                <?php endwhile; ?>

	                </ol>

	                <?php

	                    /**
	                     * Action inside before the question content on single-quiz page
	                     *
	                     * @param string $the_quiz_id
	                     */
	                    do_action( 'sensei_single_quiz_questions_after', get_the_id() );

	                ?>

	            </form>
	            </form>
	        <?php else:  ?>

	            <div class="sensei-message alert"> <?php _e( 'There are no questions for this Quiz yet. Check back soon.', 'woothemes-sensei' ); ?></div>

	        <?php endif; // End If have questions ?>


	        <?php
	            $quiz_lesson = Sensei()->quiz->data->quiz_lesson;
	            do_action( 'sensei_quiz_back_link', $quiz_lesson  );
	        ?>

        </section>

	<?php endif; // user can view lesson ?>

    <?php

    /**
     * Hook inside the single quiz post above the content
     *
     * @since 1.9.0
     *
     * @param integer $quiz_id
     *
     */
    do_action( 'sensei_single_quiz_content_inside_after', get_the_ID() );

    ?>

</article><!-- .quiz -->
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
<div id="loader">
    <div class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
    </div>
</div>
<?php wp_footer(); ?>
</body>

</html>