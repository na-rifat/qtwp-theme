<?php
/**
 * qtwp functions and definitions
 *
 * @package qtwp
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */

// add_action( 'wp_enqueue_scripts', 'qtwp_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which eqtwpance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */

if ( defined( 'JETPACK__VERSION' ) )
{
    require get_template_directory() . '/inc/jetpack.php';
}

// Custom functions
if (  !  function_exists( 'setData' ) )
{
    function setData( $data )
    {
        return set_query_var( 'component_data', $data );
    }

}

if (  !  function_exists( 'getData' ) )
{
    function getData()
    {
        return get_query_var( 'component_data', [] );
    }

}

if (  !  function_exists( 'bg_img' ) )
{
    function bg_img( $data )
    {
         !  empty( $data['background'] ) ? printf( 'style="background-image: url(\'%s\')"', wp_get_attachment_image_src( $data['background'], 'original' )[0] ) : '';
    }

}

if (  !  function_exists( '_get_img_url' ) )
{
    function _get_img_url( $path )
    {
        return get_template_directory_uri() . '/dist/img/' . $path;
    }

}

if (  !  function_exists( 'print_img_url' ) )
{
    function print_img_url( $path )
    {
        echo _get_img_url( $path );
    }

}

if (  !  function_exists( 'print_img' ) )
{
    function print_img( $path, $alt = 'Icon' )
    {
        $dims = getImageDimensions( get_template_directory() . '/dist/img/' . $path );
        printf( '<img src="%s" alt="%s"  width="%s" height="%s" />', _get_img_url( $path ), $alt, $dims['width'], $dims['height'] );
    }

}

if (  !  function_exists( 'get_img' ) )
{
    function get_img( $path, $alt = 'Icon' )
    {
        $dims = getImageDimensions( get_template_directory() . '/dist/img/' . $path );

        return sprintf( '<img src="%s" alt="%s" width="%s" height="%s" />', _get_img_url( $path ), $alt, $dims['width'], $dims['height'] );
    }

}

if (  !  function_exists( 'get_cpt' ) )
{
    function get_cpt( $post_type, $show_from = 0, $pp = 10, $order = 'ASC' )
    {
        $args = [
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $pp,
            'offset'         => $show_from,
            'order'          => $order
        ];

        return new WP_Query( $args );
    }

}

// Hooks the classes
require_once 'vendor/autoload.php';
qtwp\Init::initialize();

define( 'QTWP', 'qtwp' );
define( 'QTWP_VIEW', get_template_directory() . '/inc/views/' );

add_action( 'wp_ajax_qtwp_search', 'qtwp_search' );
add_action( 'wp_ajax_nopriv_qtwp_search', 'qtwp_search' );

function qtwp_search()
{
    $products = new WP_Query( [
        'post_type'      => ['product'],
        'post_status'    => 'publish',
        'nopaging'       => true,
        'posts_per_page' => 100
    ] );

    $items = [];

    if (  !  empty( $products->posts ) )
    {

        foreach ( $products->posts as $product )
        {
            $items[] = [
                'title' => $product->post_title,
                'link'  => get_the_permalink( $product->ID )
            ];
        }

    }

    wp_send_json_success(
        [
            'products' => $items
        ]
    );exit;
}

function generate_breadcrumb()
{
    $breadcrumb = '<ul class="breadcrumb">';

    // Home link
    $breadcrumb .= '<li><a href="' . get_home_url() . '">Home</a></li>';

// Page hierarchy
    if ( is_page() )
    {
        $ancestors = get_post_ancestors( get_the_ID() );

        if ( $ancestors )
        {
            $ancestors = array_reverse( $ancestors );

            foreach ( $ancestors as $ancestor )
            {
                $breadcrumb .= '<li><a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
            }

        }

        $breadcrumb .= '<li>' . get_the_title() . '</li>';
    }

// Category archive
    if ( is_category() )
    {
        $category = get_queried_object();
        $breadcrumb .= '<li>' . $category->name . '</li>';
    }

// Tag archive
    if ( is_tag() )
    {
        $tag = get_queried_object();
        $breadcrumb .= '<li>' . $tag->name . '</li>';
    }

// Custom post type 'service' archive or single
    if ( is_post_type_archive( 'service' ) || is_singular( 'service' ) )
    {
        $breadcrumb .= '<li>Service</li>';

        if ( is_singular( 'service' ) )
        {
            $breadcrumb .= '<li>' . get_the_title() . '</li>';
        }

    }

// Custom post type 'post' single
    if ( is_singular( 'post' ) )
    {
        $breadcrumb .= sprintf( '<li><a href="%s">Insights</a></li>', site_url( 'career' ) );
        $breadcrumb .= '<li>' . get_the_title() . '</li>';
    }

// Custom post type 'job' single
    if ( is_singular( 'job' ) )
    {
        $breadcrumb .= sprintf( '<li><a href="%s">Careers</a></li>', site_url( 'career' ) );
        $breadcrumb .= '<li>' . get_the_title() . '</li>';
    }

// Custom post type 'work' single
    if ( is_singular( 'work' ) )
    {
        $breadcrumb .= sprintf( '<li><a href="%s">Case Studies</a></li>', site_url( 'case-studies' ) );
        $breadcrumb .= '<li>' . get_the_title() . '</li>';
    }

// Search results page
    if ( is_search() )
    {
        $breadcrumb .= '<li>Search Results</li>';
    }

    $breadcrumb .= '</ul>';

    return $breadcrumb;
}

function getImageDimensions( $imagePath )
{
    $imageInfo = [];

// Check if the file exists
    if (  !  file_exists( $imagePath ) )
    {
        return false;
    }

    // determine the image type
    $image_type = explode( '.', $imagePath );
    $image_type = $image_type[count( $image_type ) - 1];

    switch ( $image_type )
    {
        case 'svg':
            $svgContent = file_get_contents( $imagePath );

// Use regular expressions to extract width and height attributes
            if ( preg_match( '/width="([^"]+)"/', $svgContent, $widthMatches ) &&
                preg_match( '/height="([^"]+)"/', $svgContent, $heightMatches ) )
            {

                $width  = $widthMatches[1];
                $height = $heightMatches[1];

// Check if the dimensions have units (e.g., "px")
                // You may need to convert them to pixels if necessary

                $imageInfo = [
                    'width'  => $width,
                    'height' => $height
                ];
            }

            break;
        default:
            // Get image dimensions
            $dimensions = getimagesize( $imagePath );

// Check if getimagesize() succeeded
            if ( $dimensions === false )
            {
                return false;
            }

            // Create an associative array with width and height
            $imageInfo = [
                'width' => $dimensions[0], // Original width
                'height' => $dimensions[1] // Original height
            ];
            break;
    }

    return $imageInfo;
}

// function my_admin_bar_init()

// {

//     remove_action('wp_head', '_admin_bar_bump_cb');

// }
// add_action('admin_bar_init', 'my_admin_bar_init');

function add_custom_query_var( $vars )
{
    $vars[] = 'id';

    return $vars;
}

add_filter( 'query_vars', 'add_custom_query_var' );

add_filter( 'redirect_canonical', 'pif_disable_redirect_canonical' );

function pif_disable_redirect_canonical( $redirect_url )
{

    if ( is_singular() )
    {
        $redirect_url = false;
    }

    return $redirect_url;
}

function generateYouTubeEmbed( $url, $width = 560, $height = 315 )
{
    $videoId = preg_match( '/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches );

    if ($videoId) {
        $videoId = $matches[1];
    }

    if ( $videoId )
    {
        $embedCode = "<iframe width=\"$width\" height=\"$height\" src=\"https://www.youtube.com/embed/$videoId\" frameborder=\"0\" allowfullscreen></iframe>";

        return $embedCode;
    }
    else
    {
        return 'Invalid YouTube URL';
    }

}


