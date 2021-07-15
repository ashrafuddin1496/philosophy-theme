<?php

require_once get_theme_file_path( '/inc/tgm.php');
require_once get_theme_file_path( '/inc/attachments.php');

//check the version of css and js
if ( site_url() =='http://127.0.0.1/wordpress'){
	define('VERSION', time() );
}else{
	defined('VERSION',wp_get_theme()->get('Version'));
}
function philosophy_after_setup(){
	load_theme_textdomain( 'philosophy');
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('html5',array('search-form','comment-list'));
	add_theme_support('post-formats',array('image','gallery','quote','audio','video','link'));
	add_editor_style('/assets/css/editor-style.css');
	//Register Menu
	register_nav_menu( 'topmenu',__('Top Menu','philosophy'));

	add_image_size("philosophy-post-preview-square",400,400,true);
}
add_action('after_setup_theme','philosophy_after_setup');

function philosophy_assets(){
	//stylesheets
	wp_enqueue_style( 'fontaweseom-css',get_theme_file_uri('/assets/css/font-awesome/css/font-awesome.css'),null,VERSION);
	wp_enqueue_style( 'fonts-css',get_theme_file_uri('/assets/css/fonts.css'),null,1.0);
	wp_enqueue_style( 'base-css',get_theme_file_uri('/assets/css/base.css'),null,1.0);
	wp_enqueue_style( 'vendor-css',get_theme_file_uri('/assets/css/vendor.css'),null,1.0);
	wp_enqueue_style( 'main-css',get_theme_file_uri('/assets/css/main.css'),null,1.0);
	wp_enqueue_style( 'philosophy-css',get_stylesheet_uri());

	//scripts
	wp_enqueue_script('modernizr-js',get_theme_file_uri('/assets/js/modernizr.js'),null,1.0);
	wp_enqueue_script('pace-js',get_theme_file_uri('/assets/js/pace.min.js'),null,1.0);
	wp_enqueue_script('plugins-js',get_theme_file_uri('/assets/js/plugins.js'),array('jquery'),1.0,true);
	wp_enqueue_script('main-js',get_theme_file_uri('/assets/js/main.js'),array('jquery'),1.0,true);
}
add_action( 'wp_enqueue_scripts','philosophy_assets');

function philosophy_pagination(){
	global $wp_query;
	$links= paginate_links(array(
		'current'   =>max(1,get_query_var( 'paged')),
		'total'   =>$wp_query->max_num_pages,
		'type'=>'list',
		'mid_size' => 3
	));
	$links = str_replace( "page-numbers", "pgn__num", $links );
	$links = str_replace( "<ul class='pgn__num'>", "<ul>", $links );
	$links = str_replace( "next pgn__num", "pgn__next", $links );
	$links = str_replace( "prev pgn__num", "pgn__prev", $links );
	echo $links;
}

remove_action( 'term_description','wpautop');

/**
 * Add about page sidebar.
 */
function philosophy_widgets() {
	register_sidebar( array(
		'name'          => __( 'About Us Page', 'philosophy' ),
		'id'            => 'about-us',
		'description'   => __( 'Widgets in this area will be shown on about us page.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="col-block %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="quarter-top-margin">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Contact Page Map Section', 'philosophy' ),
		'id'            => 'contact-map',
		'description'   => __( 'Widgets in this area will be shown on contact page.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => __( 'Contact Page Information Section', 'philosophy' ),
		'id'            => 'contact-info',
		'description'   => __( 'Widgets in this area will be shown on contact page.', 'philosophy' ),
		'before_widget' => '<div id="%1$s" class="col-six tab-full %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'philosophy_widgets' );