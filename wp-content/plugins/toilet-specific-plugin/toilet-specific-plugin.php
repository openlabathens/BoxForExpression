<?php
/*
Plugin Name: Toilet Specific Plugin
Description: This is a Site Specific Plugin for Public Toilet. Thus its Code changes go for the website regardless of the Site Active Theme.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Register a custom post type called "question".
 *
 * @see get_post_type_labels() for label keys.
 */
function toilet_question_init() {
    $labels = array(
        'name'                  => _x( 'Questions', 'Post type general name', 'toilet' ),
        'singular_name'         => _x( 'Question', 'Post type singular name', 'toilet' ),
        'menu_name'             => _x( 'Questions', 'Admin Menu text', 'toilet' ),
        'name_admin_bar'        => _x( 'Question', 'Add New on Toolbar', 'toilet' ),
        'add_new'               => __( 'Add New', 'toilet' ),
        'add_new_item'          => __( 'Add New Question', 'toilet' ),
        'new_item'              => __( 'New Question', 'toilet' ),
        'edit_item'             => __( 'Edit Question', 'toilet' ),
        'view_item'             => __( 'View Question', 'toilet' ),
        'all_items'             => __( 'All Questions', 'toilet' ),
        'search_items'          => __( 'Search Questions', 'toilet' ),
        'parent_item_colon'     => __( 'Parent Questions:', 'toilet' ),
        'not_found'             => __( 'No questions found.', 'toilet' ),
        'not_found_in_trash'    => __( 'No questions found in Trash.', 'toilet' ),
        'featured_image'        => _x( 'Question Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'toilet' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'toilet' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'toilet' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'toilet' ),
        'archives'              => _x( 'Question archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'toilet' ),
        'insert_into_item'      => _x( 'Insert into question', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'toilet' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this question', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'toilet' ),
        'filter_items_list'     => _x( 'Filter questions list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'toilet' ),
        'items_list_navigation' => _x( 'Questions list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'toilet' ),
        'items_list'            => _x( 'Questions list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'toilet' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'question' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor' ),
    );
 
    register_post_type( 'question', $args );
}
 
add_action( 'init', 'toilet_question_init' );

/**
 * Register a custom post type called "answer".
 *
 * @see get_post_type_labels() for label keys.
 */
function toilet_answer_init() {
    $labels = array(
        'name'                  => _x( 'Answers', 'Post type general name', 'toilet' ),
        'singular_name'         => _x( 'Answer', 'Post type singular name', 'toilet' ),
        'menu_name'             => _x( 'Answers', 'Admin Menu text', 'toilet' ),
        'name_admin_bar'        => _x( 'Answer', 'Add New on Toolbar', 'toilet' ),
        'add_new'               => __( 'Add New', 'toilet' ),
        'add_new_item'          => __( 'Add New Answer', 'toilet' ),
        'new_item'              => __( 'New Answer', 'toilet' ),
        'edit_item'             => __( 'Edit Answer', 'toilet' ),
        'view_item'             => __( 'View Answer', 'toilet' ),
        'all_items'             => __( 'All Answers', 'toilet' ),
        'search_items'          => __( 'Search Answers', 'toilet' ),
        'parent_item_colon'     => __( 'Parent Answers:', 'toilet' ),
        'not_found'             => __( 'No answers found.', 'toilet' ),
        'not_found_in_trash'    => __( 'No answers found in Trash.', 'toilet' ),
        'featured_image'        => _x( 'Answer Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'toilet' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'toilet' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'toilet' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'toilet' ),
        'archives'              => _x( 'Answer archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'toilet' ),
        'insert_into_item'      => _x( 'Insert into answer', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'toilet' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this answer', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'toilet' ),
        'filter_items_list'     => _x( 'Filter answers list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'toilet' ),
        'items_list_navigation' => _x( 'Answers list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'toilet' ),
        'items_list'            => _x( 'Answers list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'toilet' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'answer' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array( 'title','thumbnail' ),
    );
 
    register_post_type( 'answer', $args );
}
 
add_action( 'init', 'toilet_answer_init' );


/**
 * Register a private 'Typp' taxonomy for post type 'answer'.
 *
 * @see register_post_type() for registering post types.
 */
function toilet_register_taxonomies() {
    $args = array(
        'label'        => __( 'Type',  'toilet'),
        'public'       => true,
        'rewrite'      => true,
        'hierarchical' => true
    );
     
    register_taxonomy( 'type', 'answer', $args );
}
add_action( 'init', 'toilet_register_taxonomies', 0 );