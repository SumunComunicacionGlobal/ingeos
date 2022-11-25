<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$title = '<span class="font-weight-bold">' . get_the_title() . '</span>';

if ( $post->post_excerpt ) {
	$title .= '. ' . $post->post_excerpt . '.';
}
?>

<div <?php post_class( 'wp-block-cover alignfull' ); ?> id="post-<?php the_ID(); ?>">

	<span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-0 has-background-dim"></span>

	<?php the_post_thumbnail( 'full', array( 'class' => 'wp-block-cover__image-background' ) ); ?>

	<div class="wp-block-cover__inner-container">

		<div class="content-testimonio mw-500 text-center">

			<div class="text-primary">

				<div class="h4 mb-3">
				
					"<?php echo $post->post_content; ?>"

				</div>

				<?php echo wpautop( $title ); ?>

				<a class="btn btn-outline-primary" href="<?php echo get_post_type_archive_link( 'caso-de-exito' ); ?>">
					<?php echo get_post_type_object( 'caso-de-exito' )->labels->name; ?>
				</a>

			</div>

			<footer class="entry-footer">

				<?php understrap_edit_post_link(); ?>

			</footer><!-- .entry-footer -->

		</div>

	</div>

</div><!-- #post-## -->