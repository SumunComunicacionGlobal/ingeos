<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<!-- <div class="ek-linked-block"> -->

		<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

		<header class="entry-header">

			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>

			<?php
			the_title(
				sprintf( '<h2 class="h5 entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
			// the_title( '<h2 class="h5 entry-title">', '</h2>' );
			?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php
			the_excerpt();
			understrap_link_pages();
			?>

		</div><!-- .entry-content -->

		<!-- <a href="<?php echo esc_url( get_permalink() ); ?>" class="editorskit-block-link" title="<?php the_title(); ?>"></a> -->

	<!-- </div> -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
