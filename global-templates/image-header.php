<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$image_id = false;
$title = '';
$description = '';

if ( is_singular() ) {
	if ( 'caso-de-exito' != $post->post_type ) $image_id = get_post_thumbnail_id( get_the_ID() );
	$title = get_the_title();
	if ( $post->post_excerpt ) {
		$description = $post->post_excerpt;
	}
} elseif ( is_archive() ) {
	$image_id = get_term_meta( get_queried_object_id(), 'thumbnail_id', true );
	$title = get_the_archive_title();
	$description = get_the_archive_description();
}
?>

<header class="wp-block-cover alignfull is-style-image-header">

	<span aria-hidden="true" class="wp-block-cover__background has-background-dim has-background-dim-90 has-primary-100-background-color"></span>

	<?php if ( $image_id ) echo wp_get_attachment_image( $image_id, 'large', false, array('class' => 'wp-block-cover__image-background') ); ?>

	<div class="wp-block-cover__inner-container">

		<?php if ( is_singular( 'post' ) ) { ?>

			<div class="entry-meta text-white">

				<?php understrap_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php } ?>

		<?php smn_breadcrumb(); ?>

		<div class="mw-600">

			<h1 class="entry-title display-1 has-cyan-color has-text-color"><?php echo $title; ?></h1>

			<?php if ( $description) { ?>
				
				<div class="lead"><?php echo $description; ?></div>
			
			<?php } ?>

			<?php if ( is_active_sidebar( 'image-header' ) ) { ?>

				<div class="py-2">
			
					<?php dynamic_sidebar( 'image-header' ); ?>

				</div>
			
			<?php } ?>

		</div>

	</div>

</header>
