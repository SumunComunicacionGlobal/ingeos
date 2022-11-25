<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

$posts_ids = false;
$args = false;

$titulo = __( 'Noticias relacionadas', 'ingeos' );

if ( is_singular() ) {
	$posts_ids = get_post_meta( get_the_ID(), 'related_posts', true );
} elseif( is_tax() ) {
	$posts_ids = get_term_meta( get_queried_object_id(), 'related_posts', true );
}

if ( $posts_ids ) {

	$args = array(
		'post_type'			=> 'any',
		'post__in'			=> $posts_ids,
		'orderby'			=> 'post__in',
		'order'				=> 'ASC',
	);

} elseif( is_front_page() ) {
	
	$args = array(
		'posts_per_page'		=> 4,
	);

	$titulo = __( 'Noticias', 'ingeos' );

}

if ( $args) {

	$q = new WP_Query($args);

	if ( $q->have_posts() ) { ?>

		<div class="wrapper hfeed related-posts bg-light py-3">

			<div class="<?php echo esc_attr( $container ); ?>">

				<h2 class="is-style-lined-header"><?php echo $titulo; ?></h2>

				<div class="row">

					<?php while ( $q->have_posts() ) { $q->the_post();

						get_template_part( 'loop-templates/content' );

					} ?>

				</div>

			</div>

		</div>

	<?php }

	wp_reset_postdata();
}