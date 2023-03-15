<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'hfeed-post' ); ?> id="post-<?php the_ID(); ?>">

	<div class="card card-body shadow-sm">

		<header class="entry-header">

			<?php
			if ( 'publish' == $post->post_status ) {
				the_title(
					sprintf( '<h3 class="h4 entry-title font-weight-bold mb-2"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
					'</a></h3>'
				);
			} else {
				the_title( '<h3 class="h4 entry-title">', '</h3>' );
			}
			?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php the_excerpt(); ?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-## -->
