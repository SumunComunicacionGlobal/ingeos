<?php

/**
 * Links panel Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'wp-block-tabs';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}


// Load values and assign defaults.
$post_ids             	= get_field( 'posts_ids' ) ?: false;
$title             		= get_field( 'title' ) ?: false;

$tab_titles = '';
$tab_panels = '';

if ( $post_ids ) {

	$args = array(
		'post_type'				=> 'content_fragment',
		'post__in'				=> $post_ids,
		'orderby'				=> 'post__in',
		'posts_per_page'		=> -1,
	);

	$q = new WP_Query( $args );

	if ( $q->have_posts() ) { ?>

		<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">

			<?php while ( $q->have_posts() ) { $q->the_post(); 

				global $post;

				$active_class = '';
				$show_class = '';
				$aria_selected = 'false';

				if ( $q->current_post == 0 ) {
					$active_class = 'active';
					$show_class = 'show active';
					$aria_selected = 'true';
				}

				$content = apply_filters( 'the_content', $post->post_content );
				?>

				<?php 
					$tab_titles .= '<li class="nav-item"><a class="nav-link h4 mb-0 ' . $active_class . '" id="v-pills-' . $post->post_name . '-tab" data-toggle="pill" data-target="#v-pills-' . $post->post_name . '" type="button" role="tab" aria-controls="v-pills-' . $post->post_name . '" aria-selected="' . $aria_selected . '">' . get_the_title() . '</a></li>'; 
				?>

				<?php 
					$tab_panels .= '<div class="tab-pane p-2 p-lg-3 bg-white shadow fade ' . $show_class . '" id="v-pills-' . $post->post_name . '" role="tabpanel" aria-labelledby="v-pills-' . $post->post_name . '-tab">' . $content . '</div>'; 
				?>

			<?php } ?>

			<div class="row">
				<div class="col-md-3 mb-2">
					
					<p class="my-2 tabs-title"><?php echo $title; ?></p>
				
					<ul class="nav flex-md-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						
						<?php echo $tab_titles; ?>

					</ul>
				</div>

				<div class="col-md-9">
					<div class="tab-content" id="v-pills-tabContent">

						<?php echo $tab_panels; ?>

					</div>
				</div>
				</div>
			</div>
	
	<?php }

	wp_reset_postdata();

}