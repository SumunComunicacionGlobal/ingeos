<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$args = array(
	'post_type'			=> 'testimonio',
	'posts_per_page'	=> 1,
	'orderby'			=> 'rand',
	'ignore_row'		=> true,
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<?php while ( $q->have_posts() ) { $q->the_post();

		get_template_part( 'loop-templates/content', 'testimonio' );

	} ?>

<?php }

wp_reset_postdata();
