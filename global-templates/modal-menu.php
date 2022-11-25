<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<!-- Modal -->
<div class="modal fade" id="modal-menu" tabindex="-1" role="dialog" aria-labelledby="modal-menu-title" aria-hidden="true">

	<div class="modal-dialog modal-fullscreen" role="document">

		<div class="modal-content">

			<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

			</div>
	
			<div class="modal-body">

				<div class="modal-menu-container">

					<div class="row flex-row-reverse align-items-center">

						<div class="col-12 col-lg-8 offset-xl-1">

							<nav class="navbar navbar-dark justify-content-center px-0">

								<!-- The WordPress Menu goes here -->
								<?php wp_nav_menu(
									array(
										'theme_location'  => 'megamenu',
										'container_class' => '',
										'container_id'    => 'navbarNavModal',
										'menu_class'      => 'navbar-nav justify-content-between',
										'fallback_cb'     => '',
										'menu_id'         => 'main-menu',
										// 'depth'           => 1,
										// 'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
									)
								); ?>

							</nav>

						</div>

						<div class="col-lg-4 col-xl-3 d-none d-lg-block">

							<div id="mega-menu-widgets">

								<?php dynamic_sidebar( 'megamenu' ); ?>

							</div>

						</div>

					</div>

				</div>

			</div>
	
			<div class="modal-footer d-block">

				<?php get_template_part( 'sidebar-templates/sidebar-menu' ); ?>

			</div>

		</div>

	</div>

</div>

<script>
	jQuery('#modal-menu').on('show.bs.modal', event => {
		var body = jQuery('body');
		body.addClass( 'menu-open' );
	});

	jQuery('#modal-menu').on('hidden.bs.modal', event => {
		var body = jQuery('body');
		body.removeClass( 'menu-open' );
	});
</script>