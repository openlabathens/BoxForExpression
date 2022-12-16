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

				<div class="why-cta">
					<?php the_title() ; ?>
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="why-text about-text">
					<?php the_content(); ?>
					<span class="close" data-about="why">X</span>
				</div>

				<div class="who-cta">
					<?php echo get_the_title(icl_object_id(20, 'page', false,ICL_LANGUAGE_CODE)) ; ?>
					<?php echo get_the_post_thumbnail(icl_object_id(20, 'page', false,ICL_LANGUAGE_CODE)); ?>
				</div>
				<div class="who-text about-text">
					<?php echo get_the_content(null,false,icl_object_id(20, 'page', false,ICL_LANGUAGE_CODE)); ?>
					<span class="close" data-about="who">X</span>
				</div>

			</main><!-- #main -->


		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
