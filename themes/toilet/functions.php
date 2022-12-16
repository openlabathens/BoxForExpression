<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );


function theme_enqueue_styles() {
	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'toilet-styles', get_stylesheet_directory_uri() . '/css/child-theme.css', array(), '2.0' );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'toilet-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), '2.0' , true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

//Custom Scripts
function toilet_enqueue_scripts() {
    //Cookie
    wp_enqueue_script( 'cookie-js', 'https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js');
    if(is_singular('page')){
        //Home
        if(is_front_page()){
            wp_enqueue_script( 'home-js', get_stylesheet_directory_uri() . '/js/custom/home.js', array('jquery'));
        }
        //Main
        $main = array(2, 52, 54, 56);
        if(in_array(get_the_ID(),$main)){
            wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/js/custom/main.js', array('jquery'));
        }
        //Talk
        $talk = array(14, 62, 245, 242);
        if(in_array(get_the_ID(),$talk)){
            wp_enqueue_script( 'talk-js', get_stylesheet_directory_uri() . '/js/custom/talk.js', array('jquery'));
        }
        //Explore
        $explore = array(17, 65, 247, 250);
        if(in_array(get_the_ID(),$explore)){
            wp_enqueue_script( 'explore-js', get_stylesheet_directory_uri() . '/js/custom/explore.js', array('jquery'));
        }
        //Why
        $why = array(10, 60, 238, 240);
        if(in_array(get_the_ID(),$why)){
            wp_enqueue_script( 'why-js', get_stylesheet_directory_uri() . '/js/custom/why.js', array('jquery'));
        }
    }
}
add_action( 'wp_enqueue_scripts' ,'toilet_enqueue_scripts');

//Action to store answers
function toilet_store_answer($answer){
    $post = array(
        'post_title' => 'Kypselis '.$answer['question_id'],
        'post_type' => 'answer',
        'post_status' => 'publish'
    );
    $post_id = wp_insert_post($post);
    echo "skata";
    print_r($post_id);
    if($post_id!=0){
        add_post_meta( $post_id, 'question', $answer['question_id'], true );
        add_post_meta( $post_id,  'audio_webm', $answer['easy_voice_mail_message'], true );
        wp_set_object_terms(  $post_id , array('audio'), 'type');
    }
}
add_action( 'public_toilet_voice_mail' ,'toilet_store_answer');