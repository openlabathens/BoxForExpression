<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
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
				
				<div class="about-boxes">

					<?php 
				//About box
					global $post;
					$post = get_post(196);
					setup_postdata($post); 
					get_template_part( 'inc/archive', 'box');
					wp_reset_postdata();

				//Get Cases
					$cases = new WP_Query( array('post_type'=>'case') );
					if ( $cases->have_posts() ) {
						while ( $cases->have_posts() ) {
							$cases->the_post();
							get_template_part( 'inc/archive', 'box');
						}
						
					} 
					wp_reset_postdata();
					?>

				</div>


			</main><!-- #main -->



		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
