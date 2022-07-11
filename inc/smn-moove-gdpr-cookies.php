<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


add_action( 'gdpr_force_reload', '__return_true' );

add_filter( 'wp_nav_menu_items', 'smn_add_menu_item', 10, 2 );
function smn_add_menu_item ( $items, $args ) {

  if( $args->theme_location == 'legal' ) {
    $items .=  '<li class="menu-item" id="menu-itemmoove-gdpr menu-item nav-item">';
      $items .= '<a href="#gdpr_cookie_modal" class="nav-link">'.__('Ajustes de cookies', 'smn').'</a>';
    $items .= '</li>';
  } 
  return $items;
}

add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
function gdpr_prevent_script_cache() {
    return array();
}

add_action('moove_gdpr_third_party_header_assets','moove_gdpr_third_party_header_assets');
function moove_gdpr_third_party_header_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-head-anulados");</script>';     
    }
  return $scripts;
}
add_action('moove_gdpr_third_party_body_assets','moove_gdpr_third_party_body_assets');
function moove_gdpr_third_party_body_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-body-anulados");</script>';     
    }
  return $scripts;
}
add_action('moove_gdpr_third_party_footer_assets','moove_gdpr_third_party_footer_assets');
function moove_gdpr_third_party_footer_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-footer-anulados");</script>';     
    }
  return $scripts;
}

add_filter( 'render_block', 'video_block_wrapper', 10, 2 );
function video_block_wrapper( $block_content, $block ) {
    if ( $block['blockName'] === 'core/embed' ) {

      if ( !gdpr_cookie_is_accepted( 'thirdparty' ) ) {

        $replacement = '<a href="#gdpr_cookie_modal" class="iframe-replacement btn btn-primary d-block">'. __( 'Por favor, acepta el uso de cookies de terceros para ver este contenido externo. Pulsa aquí.', 'smn' ) . '</a>';
        return $replacement;

      }
    }

    return $block_content;
}

add_filter( 'the_content', 'filtrar_contenido_para_evitar_cookies', 1000, 1);
function filtrar_contenido_para_evitar_cookies( $content ) {

    if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {

      $content = str_replace( 'youtube.com/embed', 'youtube-nocookie.com/embed', $content );

      /* supported types: 'strict', 'thirdparty', 'advanced' */
      if ( !gdpr_cookie_is_accepted( 'thirdparty' ) ) {

        $replacement = '<a href="#gdpr_cookie_modal" class="iframe-replacement btn btn-primary d-block">'. __( 'Por favor, acepta el uso de cookies de terceros para ver este contenido externo. Pulsa aquí.', 'smn' ) . '</a>';

        $content = preg_replace( '#<iframe[^>]+>.*?</iframe>#is', $replacement, $content );

      }

    }

    return $content;
}