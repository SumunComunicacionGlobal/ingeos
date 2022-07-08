<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$terms = get_categories();
$page_for_posts_id = get_option( 'page_for_posts' );
$ver_todo_active_class = ( is_home() ) ? 'active' : '';
$queried_obj_id = get_queried_object_id();

if ( $terms ) { ?>

	<nav class="filter-navbar navbar navbar-expand justify-content-center navbar-light mb-2">

		<div class="nav navbar-nav">

			<?php if ( $page_for_posts_id ) { ?>

				<a class="nav-item nav-link <?php echo $ver_todo_active_class; ?>" href="<?php echo esc_url( get_the_permalink( $page_for_posts_id ) ); ?>"><?php echo __( 'Ver todo', 'smn' ); ?></a>

			<?php } ?>

			<?php foreach ( $terms as $term ) { 
				$active_class = ( $queried_obj_id == $term->term_id ) ? 'active' : '';
				?>

				<a class="nav-item nav-link <?php echo $active_class; ?>" href="<?php echo esc_url( get_term_link($term) ); ?>"><?php echo $term->name; ?></a>

			<?php } ?>

			<a class="nav-item nav-link nav-search-button" data-toggle="collapse" href="#search-form" aria-expanded="false" aria-controls="search-form">
				<?php echo __( 'Buscar', 'smn' ); ?>
			</a>

		</div>

	</nav>

	<div class="collapse" id="search-form">

		<div class="pb-2">

			<?php get_search_form(); ?>

		</div>

	</div>


<?php }