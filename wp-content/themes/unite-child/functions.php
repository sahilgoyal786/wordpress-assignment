<?php


// Our custom post type function
function create_posttype() {

    register_post_type( 'film',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Films' ),
                'singular_name' => __( 'Film' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'films'),
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

add_action( 'init', 'create_taxonomies', 0 );

//create a custom taxonomy name it topics for your posts

function create_taxonomies() {

// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI

    $labels = array(
        'name' => _x( 'Genre', 'taxonomy general name' ),
        'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Genres' ),
        'all_items' => __( 'All Genres' ),
        'parent_item' => __( 'Parent Genre' ),
        'parent_item_colon' => __( 'Parent Genre:' ),
        'edit_item' => __( 'Edit Genre' ),
        'update_item' => __( 'Update Genre' ),
        'add_new_item' => __( 'Add New Genre' ),
        'new_item_name' => __( 'New Genre' ),
        'menu_name' => __( 'Genres' ),
    );

// Now register the taxonomy

    register_taxonomy('genres',array('film'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'genre' ),
    ));
    $labels = array(
        'name' => _x( 'Country', 'taxonomy general name' ),
        'singular_name' => _x( 'Country', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Countries' ),
        'all_items' => __( 'All Countries' ),
        'edit_item' => __( 'Edit Country' ),
        'update_item' => __( 'Update Country' ),
        'add_new_item' => __( 'Add New Country' ),
        'new_item_name' => __( 'New Country' ),
        'menu_name' => __( 'Countries' ),
    );

// Now register the taxonomy

    register_taxonomy('Countries',array('film'), array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'country' ),
    ));
    $labels = array(
        'name' => _x( 'Year', 'taxonomy general name' ),
        'singular_name' => _x( 'Year', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Years' ),
        'all_items' => __( 'All Years' ),
        'edit_item' => __( 'Edit Year' ),
        'update_item' => __( 'Update Year' ),
        'add_new_item' => __( 'Add New Year' ),
        'new_item_name' => __( 'New Year' ),
        'menu_name' => __( 'Years' ),
    );

// Now register the taxonomy

    register_taxonomy('Year',array('film'), array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'year' ),
    ));
    $labels = array(
        'name' => _x( 'Actors', 'taxonomy general name' ),
        'singular_name' => _x( 'Actor', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Actors' ),
        'all_items' => __( 'All Actors' ),
        'edit_item' => __( 'Edit Actor' ),
        'update_item' => __( 'Update Actor' ),
        'add_new_item' => __( 'Add New Actor' ),
        'new_item_name' => __( 'New Actor' ),
        'menu_name' => __( 'Actors' ),
    );

// Now register the taxonomy

    register_taxonomy('Actors',array('film'), array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'actor' ),
    ));

}
add_shortcode( 'list-films', 'list_films_shortcode' );
function list_films_shortcode() {
    $content = '';
    $query = new WP_Query( array(
        'post_type' => 'film',
        'posts_per_page' => 5,
        'order' => 'ASC',
        'orderby' => 'title',
    ) );
    if ( $query->have_posts() ) {
        $content .= '<div>';
            while ( $query->have_posts() ) : $query->the_post();
            $content .= '<div id="post-'. get_the_ID().'">
                    <a href="'. get_the_permalink() .'">'. get_the_title() .'</a>
                </div>';
            endwhile;
        $content .= '</div>';
        return $content;
    }
}
add_filter('widget_text', 'do_shortcode');