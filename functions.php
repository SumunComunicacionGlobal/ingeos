<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
    // '/smn-dummy-content.php',
    '/smn-seo.php',
    '/smn-widgets.php',
    '/smn-post-types.php',
    '/smn-setup.php',
    '/smn-hooks.php',
    '/smn-customizer.php',
    '/smn-template-tags.php',
    '/smn-shortcodes.php',
    '/smn-blocks.php',
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
    $understrap_includes[] = '/smn-woocommerce.php';
}

if (!class_exists('ACF')) {
    $understrap_includes[] = '/smn-acf.php';
}

if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
    $understrap_includes[] = '/smn-moove-gdpr-cookies.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
    require_once get_theme_file_path( $understrap_inc_dir . $file );
}

// add_action( 'wp_enqueue_scripts', 'understrap_remove_animation_plugin_scripts', 20 );
function understrap_remove_animation_plugin_scripts() {
    wp_dequeue_style( 'edsanimate-animo-css' );
    wp_deregister_style( 'edsanimate-animo-css' );
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

    // echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    // echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    // echo '<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">';

    // wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.css' );
    // wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/js/slick/slick-theme.css' );
    wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css' );

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'smn-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');

    // wp_enqueue_script( 'sticky-sidebar', get_stylesheet_directory_uri() . '/js/jquery.sticky-sidebar.min.js', array(), false, true );
    // wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick/slick.min.js', null, null, true );
    wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', null, null, true );

    wp_enqueue_script( 'smn-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
    load_child_theme_textdomain( 'smn', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

function smn_author_info_box( $content ) {

    if ( !is_singular( array( 'post', 'caso-de-exito' ) ) ) return $content;
    global $post;
    if ( !isset( $post->post_author ) );

    $r = '';
    // Get author's display name
    $display_name = get_the_author_meta( 'display_name', $post->post_author );
     
    // If display name is not available then use nickname as display name
    if ( empty( $display_name ) )
    $display_name = get_the_author_meta( 'nickname', $post->post_author );
     
    // Get author's biographical information or description
    $user_description = get_the_author_meta( 'user_description', $post->post_author );
     
    // Get author's website URL
    $user_website = get_the_author_meta('url', $post->post_author);

    if ( !$user_website ) return $content;
     
    // Get link to the author archive page
    $user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));

    $user_profesion = get_the_author_meta( 'profesion', $post->post_author );

    $user_meta = get_user_meta( get_the_author_meta( 'ID', $post->post_author ) );
    $user_meta_string = '';
    $btn_class = 'btn btn-outline-secondary btn-sm mr-1 mb-1';
    
    $user_meta_keys_array = array(
        'twitter'       => __( 'Twitter', 'smn' ),
        'facebook'      => __( 'Facebook', 'smn' ),
    );

    foreach ( $user_meta_keys_array as $meta_key => $meta_label ) {
        if ( isset( $user_meta[$meta_key][0] ) && $user_meta[$meta_key][0] ) {
            if ( 'twitter' == $meta_key ) {
                $twitter_url = 'https://twitter.com/' . $user_meta[$meta_key][0];
                $user_meta_string .= '<a class="'.$btn_class.'" href="'.$twitter_url.'" target="_blank" rel="nofollow">'. $meta_label .': @' . $user_meta[$meta_key][0] . '</a>';
            } else {
                $user_meta_string .= '<a class="'.$btn_class.'" href="'.$user_meta[$meta_key][0].'" target="_blank" rel="nofollow">'. $meta_label .'</a>';
            }
        }
    }


        $r .= '<div class="row">';
 
            $r .= '<div class="col-3 author-avatar-column">';

                $r .= '<p class="author-avatar">' . get_avatar( get_the_author_meta('user_email') , 128 ) . '</p>';

            $r .= '</div>';

            $r .= '<div class="col">';

                if ( $user_profesion) $r .= '<p class="author-profesion small text-uppercase mb-1 text-muted">' . $user_profesion . '</p>';

                if ( ! empty( $display_name ) )
                
                $r .= '<p class="author-name h4 font-weight-bold mb-1"><a href="'. $user_posts .'" title="' . sprintf( __( 'Ver más contenido de %s', 'smn' ), $display_name ) . '">' . $display_name . '</a></p>';
                
                if ( ! empty( $user_description ) )
                // Author avatar and bio
                
                    $r .= '<div class="author-bio small">' . wpautop( $user_description ) . '</div>';

                $r .= '<p class="author-links small">';
            
                    if ( ! empty( $user_website ) ) {
                        $r .= '<a class="'.$btn_class.'" href="' . $user_website .'" target="_blank" rel="nofollow">'. __( 'Sitio web', 'smn' ) . '</a>';
                    }

                    if ( $user_meta_string ) $r .= $user_meta_string;
    
                $r .= '</p>';

           $r .= '</div>';
    
        $r .= '</div>';
    
     
    // Pass all this info to post content
    $content = $content . '<footer class="author-box my-3 card card-body shadow mw-600" >' . $r . '</footer>';

    return $content;

}
     
// Add our function to the post content filter
add_action( 'the_content', 'smn_author_info_box' );
    
// Allow HTML in author bio section
remove_filter('pre_user_description', 'wp_filter_kses');