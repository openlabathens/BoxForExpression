<?php
/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

//Check display
if(isset($_GET['browse'])){
	switch ($_GET['browse']) {
		case 'about':
		$display = 'about';
		break;
		case 'items':
		$display = 'items';
		break;	
		default:
		$display = 'initial';
		break;
	}
}else{
	$display = 'initial';
}
?>


<?php if($display!= 'initial'): ?>
	<div class="special-head">
		<div class="left-back">
		</div>
		<div class="container">
			<div class="row">
				<?php if($display=='about') : ?>
					<?php $about_cover = get_post_meta(get_the_ID(),'about_cover',true); ?>
					<img src="<?php echo wp_get_attachment_url($about_cover) ; ?>">
				<?php elseif($display =='items') : ?>
					<?php $data_cover = get_post_meta(get_the_ID(),'data_cover',true); ?>
					<img src="<?php echo wp_get_attachment_url($data_cover) ; ?>">
				<?php endif ; ?>
			</div>
		</div>
		<div class="right-back">
		</div>
	</div>
<?php endif ; ?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?> <?php echo $display ; ?>" id="content" tabindex="-1">

		<div class="row">



			<main class="site-main" id="main">


				<?php if($display=='about') : ?>
					<?php the_content(); ?>

				<?php elseif($display =='items') : ?>

					<h4><?php _e('thougts','toilet'); ?></h4>

					<div class="explore-controls" id="audio-controls">
						<h3 id="view-question-audio"></h3>
						<div id="play">
							<img src="<?php echo wp_get_attachment_url(112); ?>">
						</div>
						<div id="pause">
							<img src="<?php echo wp_get_attachment_url(172); ?>">
						</div>
					</div>
					<div class="listen-list explore-list">
						<?php
						//Get Audio Answers
						$args = array(
							'post_type' => 'answer',
							'posts_per_page' => ,
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



				<?php else : ?>


					<div class="case-menu">
						<div class="logo archive-box">
							<?php $case_logo = get_post_meta(get_the_ID(),'case_logo',true); ?>
							<img src="<?php echo wp_get_attachment_url($case_logo) ; ?>">
						</div>
						<div class="about archive-box">
							<?php $about_image = get_post_meta(get_the_ID(),'about_image',true); ?>
							<a href="<?php echo get_the_permalink().'?browse=about'; ?>" >
								<img src="<?php echo wp_get_attachment_url($about_image) ; ?>">
							</a>
						</div>
						<div class="items archive-box">
							<?php $data_image = get_post_meta(get_the_ID(),'data_image',true); ?>
							<a href="<?php echo get_the_permalink().'?browse=items'; ?>" >
								<img src="<?php echo wp_get_attachment_url($data_image) ; ?>">
							</a>
						</div>
						<div class="colector archive-box">
							<?php $collector_image = get_post_meta(get_the_ID(),'collector_image',true); ?>
							<a href="">
								<img src="<?php echo wp_get_attachment_url($collector_image) ; ?>">
							</a>
						</div>

					<?php endif; ?>

				</main><!-- #main -->


			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #single-wrapper -->

	<?php
	get_footer();
