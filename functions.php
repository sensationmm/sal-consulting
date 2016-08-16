<?php
    
    add_theme_support('menus');
	add_theme_support( 'post-thumbnails' );

	function textdomain_jquery_enqueue() {
	   wp_deregister_script( 'jquery' );
	   wp_register_script( 'jquery', "https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null );
	   wp_enqueue_script( 'jquery' );
	}

	if ( !is_admin() ) {
	    add_action( 'wp_enqueue_scripts', 'textdomain_jquery_enqueue', 11 );
	}

	add_action( 'init', 'create_post_type');
	function create_post_type() {
		register_post_type( 'variable',
			array('labels' => array( 'name' => __( 'Site Variables' ), 'singular_name' => __( 'Site Variable' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title'))
		);
		register_post_type( 'event',
			array('labels' => array( 'name' => __( 'Events' ), 'singular_name' => __( 'Event' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title','editor','author','thumbnail','excerpt'))
		);
		register_post_type( 'people',
			array('labels' => array( 'name' => __( 'People' ), 'singular_name' => __( 'Person' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title'))
		);
		register_post_type( 'job',
			array('labels' => array( 'name' => __( 'Jobs' ), 'singular_name' => __( 'Job' )),
		  		'public' => true, 
		  		'has_archive' => true, 
		  		'menu_position' => 5, 
		  		'supports' => array('title','editor'))
		);
	}
	// Custom Taxonomy Code
	add_action( 'init', 'build_taxonomies');
	function build_taxonomies() {
		register_taxonomy( 'event_cats',array('event'),array('hierarchical'=>true,'label'=>'Event Types','query_var'=>true,'rewrite'=>true));
	}

	add_filter( 'template_include', 'var_template_include', 1000 );
	function var_template_include( $t ){
	    $GLOBALS['current_theme_template'] = basename($t);
	    return $t;
	}

	/*
	* get current page template
	* $echo: (bool) echo or return value
	*/
	function get_current_template( $echo = false ) {
	    if( !isset( $GLOBALS['current_theme_template'] ) )
	        return 'false';
	    if( $echo )
	        echo $GLOBALS['current_theme_template'];
	    else
	        return $GLOBALS['current_theme_template'];
	}

	/*
	 * get section style for current page
	 * $pageID: (int) ID of current page
	 */
	function get_section_style($pageID) {
		$style = '';

		$page = get_page($pageID);

		$style = get_field('section_style', $pageID);

		if($style == '')
			$style = 'default';

		return $style;
	}

	/*
	 * get style icon for current page
	 * $pageID: (int) ID of current page
	 */
	function get_style_icon($pageID) {
		$style = '';

		$page = get_page($pageID);

		$style = get_field('section_icon', $pageID);

		if($style == '')
			$style = '/wp-content/themes/salconsulting/assets/images/icon-default.png';

		return $style;
	}

?>