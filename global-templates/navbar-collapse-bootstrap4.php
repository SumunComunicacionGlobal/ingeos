<?php
/**
 * Header Navbar (bootstrap4)
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
$navbar_class = 'has-primary-100-background-color navbar-dark';

if ( is_page() ) {
	$navbar_bg = get_post_meta( get_the_ID(), 'navbar_bg', true );

	switch ($navbar_bg) {
		case 'navbar-light':
			$navbar_class = 'bg-light navbar-light';
			break;
	}
}
?>

<nav id="main-nav" class="navbar navbar-expand-lg <?php echo $navbar_class; ?>" aria-labelledby="main-nav-label">

	<p id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</p>


<?php if ( 'container' === $container ) : ?>
	<div class="container">
<?php endif; ?>

		<!-- Your site title as branding in the menu -->
		<?php if ( file_exists( get_stylesheet_directory() . '/img/logo-dark.svg' ) && file_exists( get_stylesheet_directory() . '/img/logo-light.svg' ) ) { ?>
			
			<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
				<img class="logo-dark" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-smn-dark.svg" alt="<?php bloginfo( 'name' ); ?>" />
				<img class="logo-light" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-smn-light.svg" alt="<?php bloginfo( 'name' ); ?>" />
			</a>

		<?php } elseif( file_exists( get_stylesheet_directory() . '/img/logotipo-ingeos.svg' ) ) { ?>
			
			<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
				<div class="logo-cornered">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logotipo-ingeos.svg" alt="<?php bloginfo( 'name' ); ?>" width="176" height="49" />
				</div>
			</a>

		<?php } elseif ( ! has_custom_logo() ) { ?>
			
			<?php if ( is_front_page() && is_home() ) : ?>

				<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

			<?php else : ?>

				<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

			<?php endif; ?>

		<?php
		} else {
			the_custom_logo();
		}
		?>
		<!-- end custom logo -->

		<button class="navbar-toggler" type="button" data-toggle="modal" data-target="#modal-menu" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
			<span class="navbar-toggler-icon navbar-animated-toggler">
				<span class="slot slot-1"></span>
				<span class="slot slot-2"></span>
				<span class="slot slot-3"></span>
			</span>
		</button>

		<div class="collapse navbar-collapse">

			<!-- The WordPress Menu goes here -->
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'		  => false,
					'container_class' => 'collapse navbar-collapse',
					// 'container_id'    => 'navbarNavDropdown',
					'menu_class'      => 'navbar-nav ml-auto mt-1 mt-lg-0 flex-wrap',
					'fallback_cb'     => '',
					'menu_id'         => 'desktop-menu',
					// 'depth'           => 2,
					// 'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
				)
			);
			?>


			<ul class="navbar-nav" id="icon-desktop-menu">

				<li class="menu-item nav-item">
					<a href="<?php echo get_the_permalink( 83 ); ?>" class="nav-link icon-nav-link login-nav-link"><?php echo __( 'Login', 'ingeos' ); ?></a>
				</li>

				<li class="menu-item nav-item">
					<a data-toggle="collapse" href="#buscador-collapse" aria-expanded="false" aria-controls="buscador-collapse" class="nav-link icon-nav-link search-nav-link"><?php echo __( 'Search' ); ?></a>
				</li>
				
			</ul>

		</div>

<?php if ( 'container' === $container ) : ?>
	</div><!-- .container -->
<?php endif; ?>

</nav><!-- .site-navigation -->

<div class="collapse" id="buscador-collapse">

	<?php get_search_form(); ?>

</div>