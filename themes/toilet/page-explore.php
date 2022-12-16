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
				<!-- Audio -->
				<div id="listen-modal" class="explore-modal">
					<div class="listen-list explore-list">
						<?php
						//Get Audio Answers
						$args = array(
							'post_type' => 'answer',
							'posts_per_page' => 90,
							'orderby'        => 'rand',
							'tax_query' => array(
								array(
									'taxonomy' => 'type',
									'field'    => 'slug',
									'terms'    => 'audio',
								),
							),
						);
						$answers = new WP_Query($args);
						if($answers->have_posts()):
							while ($answers->have_posts()) :
								$answers->the_post(); 
								$question_id = get_post_meta( get_the_ID(), 'question', true);
								$question_id_trans = icl_object_id($question_id, 'page', false,ICL_LANGUAGE_CODE);
								$question_color = get_post_meta(icl_object_id($question_id, 'page', false,'en'),'question_color',true);
								$question_text = get_the_title($question_id_trans).'. '.strip_tags(get_the_content(null,false,$question_id_trans));
								$audio_url = wp_get_attachment_url(get_post_meta(get_the_ID(),'audio',true));
								if(empty($audio_url)){
									$audio_url = get_post_meta( get_the_ID(), 'audio_webm', true);
								}
								?>
								<div id="a-<?php echo get_the_ID(); ?>" class="answer answer-audio" data-question="<?php echo $question_text; ?>" data-audio="<?php echo $audio_url ; ?>" style="background-color: <?php echo $question_color ; ?>" data-color="<?php echo $question_color ; ?>" ><?php if(!empty($question_id)){echo get_the_title($question_id); } ?></div>
							<?php endwhile;
						endif;
						wp_reset_postdata();
						?>
					</div>
					<div class="explore-controls" id="audio-controls">
						<h3 id="view-question-audio"></h3>
						<div id="play">
							<img src="<?php echo wp_get_attachment_url(112); ?>">
						</div>
						<div id="pause">
							<img src="<?php echo wp_get_attachment_url(172); ?>">
						</div>
					</div>
				</div>
				<div class="explore-cta" id="listen-cta">
					<img src="<?php echo wp_get_attachment_url(121); ?>">
				</div>
				<!-- Written -->
				<div id="read-modal" class="explore-modal">
					<div class="read-list explore-list">
						<?php
						//Get Written Answers
						$args = array(
							'post_type' => 'answer',
							'posts_per_page' => -1,
							'order'=> 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => 'type',
									'field'    => 'slug',
									'terms'    => 'written',
								),
							),
						);
						$answers = new WP_Query($args);
						if($answers->have_posts()):
							while ($answers->have_posts()) :
								$answers->the_post(); 
								$question_id = get_post_meta( get_the_ID(), 'question', true);
								$question_color = get_post_meta($question_id,'question_color',true);
								$question_id_trans = icl_object_id($question_id, 'question', false,ICL_LANGUAGE_CODE);
								$question_text = get_the_title($question_id_trans).'. '.strip_tags(get_the_content(null,false,$question_id_trans));
								$audio_url = wp_get_attachment_url(get_post_meta(get_the_ID(),'audio',true));
								?>
								<div id="a-<?php echo get_the_ID(); ?>" class="answer answer-written" data-question="<?php echo $question_text; ?>" data-image="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" style="background-color: <?php echo $question_color ; ?>" data-color="<?php echo $question_color ; ?>" ></div>
							<?php endwhile;
						endif;
						wp_reset_postdata();
						?>
					</div>
					<div class="explore-controls" id="written-controls">
						<div id="show-image">
							<img src="<?php echo wp_get_attachment_url(137); ?>">
						</div>
						<h3 id="view-question-written"></h3>
					</div>
					<div class="image-view-container">
						<img id="image-view">
						<div id="hide-image">X</div>
					</div>
				</div>
				<div class="explore-cta" id="read-cta">
					<img src="<?php echo wp_get_attachment_url(125); ?>">
				</div>
				<div id="close-modal" class="navbar-brand" >
					<?php 	$logo = get_theme_mod( 'custom_logo' );
					$logo_image = wp_get_attachment_image_src( $logo , 'full' ); ?>
					<img src="<?php echo $logo_image[0] ; ?>" class="img-fluid" alt="Toielt" width="500" height="500">
				</div>

			</main><!-- #main -->


		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
