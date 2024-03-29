<?php
/**
 * Custom hooks.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'wpcf7_form_tag', 'smn_wpcf7_form_control_class', 10, 2 );
function smn_wpcf7_form_control_class( $scanned_tag, $replace ) {

   $excluded_types = array(
        'acceptance',
        'checkbox',
        'radio',
   );

   if ( in_array( $scanned_tag['type'], $excluded_types ) ) return $scanned_tag;

   switch ($scanned_tag['type']) {
    case 'submit':
        $scanned_tag['options'][] = 'class:btn';
        $scanned_tag['options'][] = 'class:btn-primary';
        break;
    
    default:
        $scanned_tag['options'][] = 'class:form-control';
        break;
   }
   
   return $scanned_tag;
}

add_action( 'loop_start', 'archive_loop_start', 10 );
function archive_loop_start( $query ) {

    if ( isset( $query->query['ignore_row'] ) && $query->query['ignore_row'] ) return false;

    if (is_archive() || is_home() || is_search() ) {
        echo '<div class="row">';
    }
}

add_action( 'loop_end', 'archive_loop_end', 10 );
function archive_loop_end( $query ) {
    
    if ( isset( $query->query['ignore_row'] ) && $query->query['ignore_row'] ) return false;

    if (is_archive() || is_home() || is_search() ) {
        echo '</div>';
    }
}

add_filter( 'body_class', 'smn_body_classes' );
function smn_body_classes( $classes ) {

    if ( is_singular() ) {
        $navbar_bg = get_post_meta( get_the_ID(), 'navbar_bg', true );
        if ( 'transparent' == $navbar_bg ) {
            $classes[] = 'navbar-transparent';
        }
    } else {
        // $classes[] = 'navbar-transparent';
    }

    return $classes;
}


add_filter( 'post_class', 'bootstrap_post_class', 10, 3 );
function bootstrap_post_class( $classes, $class, $post_id ) {

    if ( 'testimonio' == get_post_type( $post_id) ) return $classes;

    if ( is_archive() || is_home() || is_search() || in_array( 'hfeed-post', $class ) ) {
        
        if ( 'oferta-empleo' == get_post_type( $post_id) ) {
        
            $classes[] = 'col-12 stretch-linked-block';
            return $classes;
        
        } else {

            $classes[] = 'col-sm-6 mb-3 stretch-linked-block'; 

        }
    }

    return $classes;
}


// function understrap_add_site_info() {
	
//     if (is_active_sidebar( 'copyright' )) {
//         echo '<div class="row">';
//             dynamic_sidebar( 'copyright' );
//         echo '</div>';
//     }

// }

add_filter( 'understrap_site_info_content', 'site_info_do_shortcode' );
function site_info_do_shortcode( $site_info ) {
    return do_shortcode( $site_info );
}

add_action( 'wp_body_open', 'top_anchor');
function top_anchor() {

    get_template_part( 'global-templates/modal-menu' );

    echo '<div id="top">';
}

add_action( 'wp_footer', 'back_to_top' );
function back_to_top() {
    echo '<a href="#top" class="back-to-top"></a>';
}

add_action( 'wp_footer', 'smn_side_panel' );
function smn_side_panel() {
    if ( is_active_sidebar( 'side-panel' ) ) {

        echo '<div class="side-panel">';

            dynamic_sidebar( 'side-panel' );

        echo '</div>';

    }
}

function author_page_redirect() {
    if ( is_author() ) {
        wp_redirect( home_url() );
    }
}
// add_action( 'template_redirect', 'author_page_redirect' );

function es_blog() {

    if( is_singular('post') || is_category() || is_tag() || ( is_home() && !is_front_page() ) ) {
        return true;
    }

    return false;
}

add_filter( 'theme_mod_understrap_sidebar_position', 'cargar_sidebar');
function cargar_sidebar( $valor ) {
    // global $wp_query;
    // if ( es_blog() ) {
    //     $valor = 'right';
    // } else {
        $valor = 'none';
    // }
    return $valor;
}


function smn_nav_menu_submenu_css_class( $classes, $args, $depth ) {

    if ( !$args->walker && ( 'primary' === $args->theme_location || 'megamenu' == $args->theme_location ) ) {
        $classes[] = 'dropdown-menu';
        // $classes[] = 'collapse';
    }

    return $classes;

}
add_filter( 'nav_menu_submenu_css_class', 'smn_nav_menu_submenu_css_class', 10, 3 );

function smn_add_menu_item_classes( $classes, $item, $args ) {

    // echo '<pre>'; print_r($args); echo '<pre>';
 
    if ( !$args->walker && ( 'primary' === $args->theme_location || 'megamenu' == $args->theme_location ) ) {
        $classes[] = "nav-item";

        if( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = "active";
        }

        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }
    
    }
 
    return $classes;
}
add_filter( 'nav_menu_css_class' , 'smn_add_menu_item_classes' , 10, 4 );

function smn_add_menu_link_classes( $atts, $item, $args ) {

    if ( !$args->walker && ( 'primary' == $args->theme_location || 'megamenu' == $args->theme_location ) ) {

    // echo '<pre>'; print_r($atts); echo '<pre>';

    if ( 0 == $item->menu_item_parent ) {
            $atts['class'] = 'nav-link';
        } else {
            $atts['class'] = 'dropdown-item';
        }
    }

    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        if ( isset( $atts['class'] ) ) $atts['class'] .= ' dropdown-toggle';
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'smn_add_menu_link_classes', 10, 3 );

add_filter('nav_menu_item_args', function ($args, $item, $depth) {

    if ( !$args->walker && ( 'primary' == $args->theme_location || 'megamenu' == $args->theme_location ) ) {
        
        $icon = get_post_meta( $item->ID, 'icon', true );

        if ( $icon ) {
            $args->link_before = '<span class="menu-item-link-icon">' . wp_get_attachment_image( $icon, 'thumbnail' ) . '</span>';
        } else {
            $args->link_before = false;
        }

        $args->link_after  = '<span class="sub-menu-toggler"></span>';

    }
    return $args;
}, 10, 3);

add_filter( 'parse_tax_query', 'smn_do_not_include_children_in_product_cat_archive' );
function smn_do_not_include_children_in_product_cat_archive( $query ) {
    if ( 
        ! is_admin() 
        && $query->is_main_query()
        && $query->is_tax( 'product_cat' )
    ) {
        $query->tax_query->queries[0]['include_children'] = 0;
    }
}

add_filter('wp_nav_menu_items', 'smn_add_mega_menu_buttons', 10, 2);
function smn_add_mega_menu_buttons($items, $args){

    if( $args->theme_location == 'megamenu' ) {

        $buttons = wp_nav_menu(
            array(
                'theme_location'  => 'megamenu-buttons',
                'container_class' => 'mt-2',
                'container_id'    => '',
                'menu_class'      => 'navbar-nav justify-content-between',
                'fallback_cb'     => '',
                'menu_id'         => 'megamenu-buttons-menu',
                'depth'           => 1,
                'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                'echo'            => false,
            )
        );

        if ( is_active_sidebar( 'megamenu-after' ) ) {
            $buttons .= '<div class="mt-3" id="mega-menu-widgets-after">';
                ob_start();
                dynamic_sidebar( 'megamenu-after' );
                $buttons .= ob_get_clean();
            $buttons .= '</div>';

        }

        $items .= $buttons;
    }

    return $items;
}

add_filter( 'the_title', 'smn_oferta_de_empleo_title', 10, 2 );
function smn_oferta_de_empleo_title( $title, $post_id ) {

    $post_type = get_post_type( $post_id );
	if ( 'oferta-empleo' == $post_type ) {
		$pto = get_post_type_object( $post_type );
		$title = '<span class="post-type-label">' . $pto->labels->singular_name . ': </span>' . $title;
	}

    return $title;
}