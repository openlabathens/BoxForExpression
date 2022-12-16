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

				<a class="lang-url en" href="<?php echo get_the_permalink(2) ; ?>">
					english <span></span>
				</a>


				<a class="lang-url el" href="<?php echo get_the_permalink(2) ; ?>/?lang=el">
					ελληνικά  <span></span>
				</a>

				<a class="lang-url ar" href="<?php echo get_the_permalink(2) ; ?>/?lang=ar">
					عربى   <span><div id="pentagon"></div></span>
				</a>

				<a class="lang-url fr" href="<?php echo get_the_permalink(2) ; ?>/?lang=fr">
					français  <span><div id="rhombus"></div></span>
				</a>

			</main><!-- #main -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();
