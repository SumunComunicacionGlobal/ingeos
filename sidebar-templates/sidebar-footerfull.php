<?php
/**
 * Sidebar setup for footer full
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

?>

<?php if ( is_active_sidebar( 'footerfull' ) ) : ?>

	<div class="wp-block-cover alignfull has-background-dim" id="wrapper-footer-full" role="footer">

		<span aria-hidden="true" class="wp-block-cover__background"></span>

		<video class="wp-block-cover__video-background intrinsic-ignore" autoplay muted loop playsinline src="<?php echo get_stylesheet_directory_uri(); ?>/img/footer-background.mp4" data-object-fit="cover"></video>

		<div class="wp-block-cover__inner-container">

			<!-- ******************* The Footer Full-width Widget Area ******************* -->


			<div class="<?php echo esc_attr( $container ); ?>" id="footer-full-content" tabindex="-1">

				<div class="row">

					<?php dynamic_sidebar( 'footerfull' ); ?>

				</div>

				<div class="row align-items-center">

					<div class="col-md-6">

						<footer class="site-footer" id="colophon">

							<div class="site-info">

								<?php understrap_site_info(); ?>

							</div><!-- .site-info -->

						</footer><!-- #colophon -->

					</div><!--col end -->

					<div class="col-md-6">

						<nav id="legal-nav" class="navbar navbar-expand navbar-light" aria-labelledby="legal-nav-label">

							<p id="legal-nav-label" class="screen-reader-text">
								<?php esc_html_e( 'Legal Navigation', 'understrap' ); ?>
							</p>

							<?php wp_nav_menu( array(
								'theme_location'		  => 'legal',
								'container_class' => 'collapse navbar-collapse navbar-dark',
								'container_id'    => 'navbarLegal',
								'menu_class'      => 'navbar-nav mx-auto mr-md-0 flex-wrap justify-content-center justify-content-md-end',
								'fallback_cb'     => '',
								'menu_id'         => 'legal-menu',
								'depth'           => 1,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							) ); ?>

						</nav>

					</div><!--col end -->

				</div><!-- row end -->

			</div>

		</div>

	</div><!-- #wrapper-footer-full -->

	<?php
endif;
