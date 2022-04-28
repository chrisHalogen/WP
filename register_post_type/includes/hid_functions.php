<?php

function wp_hid_register_post_type() {

    // Vendors
    $labels = array(

        'name' => __( 'Vendors' , 'wp_hid' ),

        'singular_name' => __( 'Vendor' , 'wp_hid' ),

        'add_new' => __( 'New Vendor' , 'wp_hid' ),

        'add_new_item' => __( 'Add New Vendor' , 'wp_hid' ),

        'edit_item' => __( 'Edit Vendor' , 'wp_hid' ),

        'new_item' => __( 'New Vendor' , 'wp_hid' ),

        'view_item' => __( 'View Vendor' , 'wp_hid' ),

        'search_items' => __( 'Search Vendors' , 'wp_hid' ),

        'not_found' =>  __( 'No Vendors Found' , 'wp_hid' ),

        'not_found_in_trash' => __( 'No Vendors found in Trash' , 'wp_hid' ),

    );

    $args = array(

        'labels' => $labels,

        'has_archive' => true,

        'public' => true,

        'hierarchical' => false,

        'supports' => array(

            'title',

            'editor',

            'excerpt',

            'custom-fields',

            'thumbnail',

            'page-attributes'

        ),

        'rewrite'   => array( 'slug' => 'movies' ),

        'show_in_rest' => true

    );

    register_post_type( 'vendor', $args );
}

add_action( 'init', 'wp_hid_register_post_type' );


function wp_hid_register_taxonomy() {

    // Niche
    $labels = array(
        'name' => __( 'Niche' , 'wp_hid' ),
        'singular_name' => __( 'Niche', 'wp_hid' ),
        'search_items' => __( 'Search Niches' , 'wp_hid' ),
        'all_items' => __( 'All Niches' , 'wp_hid' ),
        'edit_item' => __( 'Edit Niche' , 'wp_hid' ),
        'update_item' => __( 'Update Niches' , 'wp_hid' ),
        'add_new_item' => __( 'Add New Niche' , 'wp_hid' ),
        'new_item_name' => __( 'New Niche Name' , 'wp_hid' ),
        'menu_name' => __( 'Niches' , 'wp_hid' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'rewrite' => array( 'slug' => 'niches' ),
        'show_admin_column' => true,
        'show_in_rest' => true

    );

    // register_taxonomy( 'wp_hid_niche', $object_type, $args )

    register_taxonomy( 'niche', array( 'vendor' ), $args);

}

add_action( 'init', 'wp_hid_register_taxonomy' );
