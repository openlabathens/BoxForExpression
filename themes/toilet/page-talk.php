<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<div id="user-talk">
					<div class="talk-animation">
						<div class="outer"></div>
						<div class="outer-2"></div>
					</div>
					<?php echo do_shortcode( '[easy_voice_mail]' ) ; ?>
					<input id="talk-thumb" type="hidden" name="talk-thumb" value="<?php echo get_the_post_thumbnail_url() ; ?>">
					<input id="play-icon" type="hidden" name="play-icon" value="<?php echo wp_get_attachment_url(112); ?>">
					<input id="stop-icon" type="hidden" name="stop-icon" value="<?php echo wp_get_attachment_url(169); ?>">
					<input id="cancel-icon" type="hidden" name="cancel-icon" value="<?php echo wp_get_attachment_url(157); ?>">
					<input id="save-icon" type="hidden" name="save-icon" value="<?php echo wp_get_attachment_url(165) ; ?>">
			 		<input id="send-text"type="hidden" name="send-tex" value="<?php echo strip_tags(get_the_content()); ?>">
				</div>

				<?php 
				//Get questions 
				$args = array(
					'post_type' => 'question',
					'posts_per_page' => -1,
					'order'=> 'ASC'
				);
				$questions = new WP_Query($args);
				if($questions->have_posts()):
					while ($questions->have_posts()) :
						$questions->the_post(); 
						$question_color = get_post_meta(icl_object_id(get_the_ID(), 'question', false,'en'),'question_color',true);   ?>
						<div id="q-<?php echo get_the_title(); ?>" class="question" >
							<div class="q-number q-<?php echo get_the_title(); ?>" data-id="<?php echo get_the_ID() ; ?>" data-number="<?php echo get_the_title(); ?>" style="background-color:<?php echo $question_color ; ?>;">
								<?php echo get_the_title(); ?>
							</div>
							<div id="q-text-<?php echo get_the_title(); ?>" class="q-text">
								<div class="q-text-back" style="background-color:<?php echo $question_color ; ?>;">
								</div>
								<div class="q-text-content">
									<?php echo get_the_content(); ?>
								</div>
							</div>
						</div>
					<?php endwhile;
				endif;
				?>
			</main><!-- #main -->


		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
