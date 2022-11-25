<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function contenido_pagina($atts) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
				'imagen'	=> 'no',
				'dominio'	=> false,

		), $atts)	
	);
	if ($dominio) {
		$api_url = $dominio . '/wp-json/wp/v2/pages/' . $id;
		$data = wp_remote_get( $api_url );
		$data_decode = json_decode( $data['body'] );

		// echo '<pre>'; print_r($data_decode); echo '</pre>';

		$content = $data_decode->content->rendered;
		return $content;
	} else {
		if ( 0 != $id) {
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = '<div class="post-content-container">'.apply_filters('the_content', $content) .'</div>';
			if ('si' == $imagen) {
				$content = '<div class="entry-thumbnail">'.get_the_post_thumbnail($id, 'full') . '</div>' . $content;
			}
			return $content;
		}
	}
}
add_shortcode('contenido_pagina','contenido_pagina');

function home_url_shortcode() {
	return get_home_url();
}
add_shortcode('home_url','home_url_shortcode');

function theme_url_shortcode() {
	return get_stylesheet_directory_uri();
}
add_shortcode('theme_url','theme_url_shortcode');

function uploads_url_shortcode() {
	$upload_dir = wp_upload_dir();
	$uploads_url = $upload_dir['baseurl'];
	return $uploads_url;
}
add_shortcode('uploads_url','uploads_url_shortcode');

function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

function term_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_term_link( $id );
}
add_shortcode('cat_link', 'term_link_sh');

function post_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_the_permalink( $id );
}
add_shortcode('post_link', 'post_link_sh');

function paginas_hijas() {

	global $post;

	if ( is_post_type_hierarchical( $post->post_type ) /*&& '' == $post->post_content */) {
		
		$args = array(
			'post_type'			=> array($post->post_type),
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish',
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_parent'		=> $post->ID,
			'post_status'		=> 'any',
		);

		$r = '';

		$query = new WP_Query($args);

		if ($query->have_posts() ) {

			$r .= '<div class="row hfeed paginas-hijas">';

				while($query->have_posts() ) { $query->the_post();
					ob_start();
					get_template_part( 'loop-templates/content' );
					$r .= ob_get_clean();
					
				}

			$r .= '</div>';

		} 
	// 	elseif( 0 != $post->post_parent ) {

	// 		wp_reset_postdata();
			
	// 		$current_post_id = get_the_ID();
	// 		$args['post_parent'] = $post->post_parent;
	// 		$query = new WP_Query($args);
			
	// 		if ($query->have_posts() && $query->found_posts > 1 ) {
			
	// 			$r .= '<div class="contenido-adicional">';
			
	// 				while($query->have_posts() ) { $query->the_post();

	// 					if ($current_post_id == get_the_ID()) {
	// 						$r .= '<span class="btn btn-primary btn-sm mr-2 mb-2">'.get_the_title().'</span>';
	// 					} else {
	// 						$r .= '<a class="btn btn-outline-primary btn-sm mr-2 mb-2" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
	// 					}

	// 				}
					
	// 			$r .= '</div>';
	// 		}
	// 	}

		wp_reset_postdata();

		return $r;

	}

}
add_shortcode( 'paginas_hijas', 'paginas_hijas' );

// add_filter('the_content', 'mostrar_paginas_hijas', 100);
function mostrar_paginas_hijas($content) {
	global $post;
	if (is_admin() || !is_singular() || !in_the_loop() || is_front_page() ) return $content;
	global $post;
	if (has_shortcode( $post->post_content, 'paginas_hijas' )) return $content;

	return $content . paginas_hijas();

}

function enlaces_con_iconos( $atts ) {

    extract( shortcode_atts( array(
        'categoria' => false,
		'parent'	=> false,
    ), $atts ) );

	global $post;

	$args = array(
		'post_type'			=> 'page',
		'posts_per_page'	=> -1,
		'orderby'			=> 'menu_order',
		'order'				=> 'ASC',
		'post_parent'		=> $post->ID,
	);

	if ( $parent ) {
		$args['post_parent'] = $parent;
		$args['post__not_in'] = array( $post->ID );
	}

	if ( $categoria ) {

		$categoria = explode( ',', $categoria );

		$args = array(
			'post_type'			=> 'page',
			'posts_per_page'	=> -1,
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'tax_query'			=> array( array(
									'taxonomy'		=> 'page_cat',
									'field'			=> 'term_id',
									'terms'			=> $categoria,
								)),
		);

		$args['post__not_in'] = array( $post->ID );

	}

	$r = '';

	$query = new WP_Query($args);

	if ($query->have_posts() ) {

		$r .= '<div class="wp-block-group alignfull enlaces-con-icono">';

			$r .= '<div class="wp-block-group__inner-container">';

				$r .= '<div class="row justify-content-center mt-2">';

					while($query->have_posts() ) { $query->the_post();

						$icono_img = '<img src="'. get_stylesheet_directory_uri().'/img/icon-placeholder.svg" alt="'. get_the_title() . '" />';
						$icono_id = get_post_meta( get_the_ID(), 'icon', true );

						if ( $icono_id ) {
							$icono_img = wp_get_attachment_image( $icono_id, 'medium' );
						}
								
						$r .= '<div class="col-6 col-sm-4 col-md text-center position-relative mb-2">';

							$r .= '<div class="icon-wrapper">' . $icono_img . '</div>';

							$r .= '<a class="has-gray-color font-weight-bold stretched-link" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.get_the_title().'</a>';

						$r .= '</div>';
					}

				$r .= '</div>';

			$r .= '</div>';

		$r .= '</div>';

	}
	
	wp_reset_postdata();

	return $r;

	}
add_shortcode( 'enlaces_con_iconos', 'enlaces_con_iconos' );

function get_redes_sociales() {

	$r = '';
	
    $redes_sociales = array(
        'email' => 'envelope',
        'whatsapp' => 'whatsapp',
        'linkedin' => 'linkedin',
        'twitter' => 'twitter',
        'facebook' => 'facebook',
        'instagram' => 'instagram',
        'youtube' => 'youtube',
        'skype' => 'skype',
        'pinterest' => 'pinterest',
        'flickr' => 'flickr',
        'blog' => 'rss',
    );
    $r .= '<div class="redes-sociales">';

    foreach ($redes_sociales as $red => $fa_class) {
    	$url = get_theme_mod( $red, '' );
    	if( '' != $url) {
	    	$r .= '<a href="'.$url.'" target="_blank" rel="nofollow" title="'.sprintf( __( 'Abrir %s en otra pestaña', 'smn' ), $red ).'"><span class="red-social '.$red.' fa fa-'.$fa_class.'"></span></a>';
    	}
    }

    // $r .= '<span class="follow-us">' . __( 'Follow us', 'smn' ) . '</span>';

    $r .= '</div>';

    return $r;

}
add_shortcode( 'redes_sociales', 'get_redes_sociales' );

function get_info_basica_privacidad() {

	$r = '';
	
	$text = get_theme_mod( 'info_privacidad_formularios', '' );
	if( '' != $text) {
		$r .= '<div class="info-basica-privacidad">';
	    	$r .= wpautop( $text );
		$r .= '</div>';
	}

    return $r;

}
add_shortcode( 'info_basica_privacidad', 'get_info_basica_privacidad' );

function sitemap() {
	$pt_args = array(
		'has_archive'		=> true,
	);
	$pts = get_post_types( $pt_args );
	// if (isset($pts['rl_gallery'])) unset $pts['rl_gallery'];
	$pts = array_merge( array('page'), $pts, array('post') );
	$r = '';

	foreach ($pts as $pt) {
		$pto = get_post_type_object( $pt );
		$taxonomies = get_object_taxonomies( $pt );

		$posts_args = array(
				'post_type'			=> $pt,
				'posts_per_page'	=> -1,
				'orderby'			=> 'menu_order',
				'order'				=> 'asc',
		);

		$posts_q = new WP_Query($posts_args);
		if ($posts_q->have_posts()) {

			$r .= '<h3 class="mt-3">'.$pto->labels->name.'</h3>';
			if ($taxonomies) {
				foreach ($taxonomies as $tax) {
					$terms = get_terms( array('taxonomy' => $tax) );
					foreach ($terms as $term) {
						$r .= '<a href="'.get_term_link( $term ).'" class="btn btn-dark btn-sm mr-1 mb-1">'.$term->name.'</a>';
					}
				}
			}

			while ($posts_q->have_posts()) { $posts_q->the_post();
				$r .= '<a href="'.get_the_permalink().'" class="btn btn-outline-primary btn-sm mr-1 mb-1">'.get_the_title().'</a>';
			}
		}

		wp_reset_postdata();
	}

	return $r;
}
add_shortcode( 'sitemap', 'sitemap' );

function testimonios() {
	ob_start();
	get_template_part( 'global-templates/carousel-testimonios' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'testimonio_aleatorio', 'testimonios' );

function smn_get_reusable_block( $block_id = '' ) {
    if ( empty( $block_id ) || (int) $block_id !== $block_id ) {
        return;
    }
    $content = get_post_field( 'post_content', $block_id );
    return apply_filters( 'the_content', $content );
}

function smn_reusable_block( $block_id = '' ) {
    echo smn_get_reusable_block( $block_id );
}

function smn_reusable_block_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );
    if ( empty( $id ) || (int) $id !== $id ) {
        return;
    }
    $content = smn_get_reusable_block( $id );
    return $content;
}
add_shortcode( 'reusable', 'smn_reusable_block_shortcode' );

function smn_slider_pantallas( $atts ) {
    // extract( shortcode_atts( array(
    //     'id' => '',
    // ), $atts ) );
    // if ( empty( $id ) || (int) $id !== $id ) {
    //     return;
    // }
	
	ob_start();
	?>

	<div class="swiper slider-vertical">

		<div class="swiper-wrapper">

			<div class="swiper-slide bg-light p-3">Slide 1</div>
			<div class="swiper-slide bg-primary p-3">Slide 2</div>
			<div class="swiper-slide bg-secondary p-3">Slide 3</div>

		</div>

		<div class="swiper-pagination"></div>

	</div>


	<?php
	$content = ob_get_clean();
	
    return $content;
}
add_shortcode( 'slider_pantallas', 'smn_slider_pantallas' );