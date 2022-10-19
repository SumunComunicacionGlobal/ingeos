<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div>

	<div <?php post_class( 'wp-block-cover alignfull' ); ?> id="post-<?php the_ID(); ?>">

		<span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-70 has-background-dim"></span>

		<?php the_post_thumbnail( 'full', array( 'class' => 'wp-block-cover__image-background' ) ); ?>

		<div class="wp-block-cover__inner-container">

			<?php the_content(); ?>

			<footer class="entry-footer">

				<?php understrap_edit_post_link(); ?>

			</footer><!-- .entry-footer -->

		</div>


	</div><!-- #post-## -->

</div>