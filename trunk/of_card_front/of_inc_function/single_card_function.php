<?php 
/*
* Single Card Functions 
*/

/*************************************************
      Custom Single template 
***********************************************/

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
 
if ( ! defined( 'OF_BASE_FILE' ) )
    define( 'OF_BASE_FILE', __FILE__ );
if ( ! defined( 'OF_BASE_DIR' ) )
    define( 'OF_BASE_DIR', dirname( OF_BASE_FILE ) );
if ( ! defined( 'OF_PLUGIN_URL' ) )
    define( 'OF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/
 
add_filter( 'template_include', 'of_template_chooser');
 
/*
|--------------------------------------------------------------------------
| PLUGIN FUNCTIONS
|--------------------------------------------------------------------------
*/
 
/**
 * Returns template file
 *
 * @since 1.0
 */
 
function of_template_chooser( $template ) {

 
    // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if(isset($_GET['ppf'])){
        return of_get_template_hierarchy( '/multiple-card' );
    }
    elseif ( get_post_type( $post_id ) != 'card' ) {
        return $template;
    }
 
    // Else use custom template

    if ( is_single() ) {
        return of_get_template_hierarchy( '/single-card' );
    }

 
}



/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function of_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = OF_BASE_DIR  . $template;
    }
 
    return apply_filters( 'of_repl_template_' . $template, $file );
}
 
/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/
 
add_filter( 'template_include', 'of_template_chooser' );
?>