<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="entry-content">

		<?php get_template_part( 'global-templates/image-header'); ?>

		<div class="row">

			<div class="col-md-7">

				<?php
				the_content();
				understrap_link_pages();
				?>

			</div>

			<div class="col-md-5 widget-area" id="aplicar">

				<div class="sticky-top">

					<?php dynamic_sidebar( 'job-form' ); ?>

				</div>

			</div>

		</div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
