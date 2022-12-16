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

				<?php
				$args = array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'post_parent'    => $post->ID,
					'order'          => 'ASC',
					'orderby'        => 'menu_order'
				);

				$parent = new WP_Query( $args );

				if ( $parent->have_posts() ) : ?>

					<?php while ( $parent->have_posts() ) : $parent->the_post(); ?>

						<div class="home-item item-<?php echo get_post_field('post_name') ; ?>">
							<a href="<?php echo get_the_permalink() ; ?>">
								<h3><?php echo get_the_title() ; ?></h3>
								<?php echo get_the_post_thumbnail(get_the_ID(),'full'); ?>
							</a>
						</div>

					<?php endwhile; ?>

				<?php endif; wp_reset_postdata(); ?>


				<div class="consent-container">

					<div class="consent">
						<?php 
						$policy_page = get_post(icl_object_id(3, 'page', false,ICL_LANGUAGE_CODE)); 
						$policy = apply_filters('the_content', $policy_page->post_content); 
						echo $policy;
						?>
					</div>
					
					<span class="accept">
						✓
					</span>

				</div>
				
			</main><!-- #main -->



		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
