<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

# in functions.php add hook & hook function
add_filter("wp_nav_menu_objects",'my_wp_nav_menu_objects_start_in',10,2);

# filter_hook function to react on start_in argument
function my_wp_nav_menu_objects_start_in( $sorted_menu_items, $args ) {
    if(isset($args->start_in)) {
        $menu_item_parents = array();
        foreach( $sorted_menu_items as $key => $item ) {
            // init menu_item_parents
            if( $item->object_id == (int)$args->start_in ) $menu_item_parents[] = $item->ID;

            if( in_array($item->menu_item_parent, $menu_item_parents) ) {
                // part of sub-tree: keep!
                $menu_item_parents[] = $item->ID;
            } else {
                // not part of sub-tree: away with it!
                unset($sorted_menu_items[$key]);
            }
        }
        return $sorted_menu_items;
    } else {
        return $sorted_menu_items;
    }
}

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	// add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'status', 'dak_event' ) );

	// required menus
	register_nav_menus( array(
		'main_navigation_left' => 'Left main navigation',
		'main_navigation_right' => 'Right main navigation',
		'det_akadmiske_kvarter' => 'The Academic Quarter (displayed in Kvarteret and in footer)',
		'kvarteret_no' => 'Displayed in footer, links for things regarding Kvarteret.no and internal systems',
		'culture_arrangers' => 'Culture arrangers (dorger/borger), displayed on culture arranger pages and in the footer',
		'arrange' => 'Arrange (displayed on arrange and in the footer), links about how to arrange something at Kvarteret',
		'workgroups' => 'Workgroups (arbeidsgrupper) one level',
		'organisation_chart' => 'Workgroups (arger) + all subgroups (e.g pr.web)'
	) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	// add_theme_support( 'custom-background', array(
	// 	'default-color' => 'e6e6e6',
	// ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	add_image_size( 'full-thumbnail', 960, 496, true );
	add_image_size( 'one-third-thumbnail', 296, 153, true );

	// set default number of posts per page to 12
	$wp_query->query_vars["posts_per_page"] = 12;
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

function kvarteret_rewrite_rules($rules) {

	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'archive-dak_event.php'
	));

	$myRules = array();

	foreach($pages as $page) {
		$slug = $page->post_name;
		$id = $page->ID;

		$myRules[$slug . '/([0-9]{4})/([0-9]{2})/([-0-9a-zA-Z,]+)/page/([0-9]{1,})/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&monthnum=$matches[2]&tags=$matches[3]&paged=$matches[4]';
		$myRules[$slug . '/([0-9]{4})/([0-9]{2})/page/([0-9]{1,})/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]';

		$myRules[$slug . '/([0-9]{4})/([0-9]{2})/([-0-9a-zA-Z,]+)/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&monthnum=$matches[2]&tags=$matches[3]';
		$myRules[$slug . '/([0-9]{4})/([0-9]{2})/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&monthnum=$matches[2]';

		$myRules[$slug . '/([0-9]{4})/([-0-9a-zA-Z,]+)/page/([0-9]{1,})/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&tags=$matches[2]&paged=$matches[3]';
		$myRules[$slug . '/([0-9]{4})/page/([0-9]{1,})/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&paged=$matches[2]';

		$myRules[$slug . '/([0-9]{4})/([-0-9a-zA-Z,]+)/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]&tags=$matches[2]';
		$myRules[$slug . '/([0-9]{4})/?$'] =
			'index.php?page_id=' . $id . '&year=$matches[1]';


		$myRules[$slug . '/([-0-9a-zA-Z,]+)/page/([0-9]{1,})/?$'] =
			'index.php?page_id=' . $id . '&tags=$matches[1]&paged=$matches[2]';
		$myRules[$slug . '/([-0-9a-zA-Z,]+)/?$'] =
			'index.php?page_id=' . $id . '&tags=$matches[1]';
	}

	$rules = array_merge($myRules, $rules);

	return $rules;
}

// Will only run on flush_rewrite_rules()
add_action('page_rewrite_rules', 'kvarteret_rewrite_rules');

function kvarteret_query_vars($vars) {
	array_push($vars, 'tags');

	return $vars;
}
add_filter('query_vars', 'kvarteret_query_vars');

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	// wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'twentytwelve-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'twentytwelve-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Kvarteret.no v2.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Above header', 'twentytwelve' ),
		'id' => 'above-header',
		'description' => __( 'Appears just above the header', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Below header', 'twentytwelve' ),
		'id' => 'below-header',
		'description' => __( 'Appears just below the header (below the opening times)', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Above footer', 'twentytwelve' ),
		'id' => 'above-footer',
		'description' => __( 'Appears above the footer', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Content in the footer', 'twentytwelve' ),
		'id' => 'the-footer-nav',
		'description' => __( 'The navigational links in the  gradiented area of the footer', 'twentytwelve' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Copyrights', 'twentytwelve' ),
		'id' => 'the-footer-copyright',
		'description' => __( 'The copyright, etc at the bottom of pages', 'twentytwelve' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => __( 'Below footer', 'twentytwelve' ),
		'id' => 'below-footer',
		'description' => __( 'Appears below the footer (below the copyrights)', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Single post', 'twentytwelve' ),
		'id' => 'single-post',
		'description' => __( 'Appears below the author in single post', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Opening times', 'twentytwelve' ),
		'id' => 'opening-times',
		'description' => __( 'Opening times in header', 'twentytwelve' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => __( 'Above sidebar', 'twentytwelve' ),
		'id' => 'above-sidebar',
		'description' => __( 'Appears above the sidebar on all articles and pages', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Below sidebar', 'twentytwelve' ),
		'id' => 'below-sidebar',
		'description' => __( 'Appears below the sidebar on all articles and pages', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );


if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Kvarteret.no v2.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Kvarteret.no v2.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Kvarteret.no v2.0
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );

/**
 * Generates an author meta box for a given ID
 * @since Kvarteret.no v2.0
 */
function kvarteret_author_meta($id, $custom_author) {
	// refactor me!
	if(!$custom_author) {
		$return = 	'<div class="clearfix author">' .
						'<div class="left standard_right_margin">' . get_avatar($id, 58) . '</div>' .  
						'<div>' . 
							'<strong>' . get_the_author_meta('first_name', $id) . ' ' . get_the_author_meta('last_name', $id) . '</strong><br />' . 
		 					'<em>tekstgruppen</em><br />' .
							get_the_author_meta('email', $id) . 
						'</div>' . 
						
					'</div>';
	} else {
		$return = 	'<div class="clearfix author">' .
						'<div class="left standard_right_margin">' . get_avatar($custom_author, 58) . '</div>' .  
						'<div>' . 
							'<strong>' . $custom_author . '</strong>' . 
						'</div>' . 
						
					'</div>';
	}
	return $return;
}

// generate date for event meta
function kvarteret_event_meta_date($start_date, $start_time, $end_date, $end_time) {
	return 
		sprintf(
			'%s kl. %s til %s kl. %s',
			date('d. M Y', strtotime($start_date)), 
			date('H:i', strtotime($start_time)), 
			($end_date != $start_date ? date('d. M Y', strtotime($end_date)):""), 
			date('H:i', strtotime($end_time))
		);
} 

/**
 * Generates an event meta box
 * @since Kvarteret.no v2.0
 */
function kvarteret_event_meta($post_id, $event_meta) {
	$return = '<div class="date">'.kvarteret_event_meta_date($event_meta['dak_event_start_date'][0], $event_meta['dak_event_start_time'][0], $event_meta['dak_event_end_date'][0], $event_meta['dak_event_end_time'][0]).'</div>';

	$location = "unspecified";
	if (isset($event_meta['dak_event_common_location_name'][0])) {
		$location = $event_meta['dak_event_common_location_name'][0];
	} else if (isset($event_meta['dak_event_custom_location'][0])) {
		$location = $event_meta['dak_event_custom_location'][0];
	}

	$categoryTaxonomy = wp_get_post_terms($post_id, 'dak_event_category');

	$categories = "something";

	if (!empty($categoryTaxonomy)) {
		$catArr = array();
		foreach ($categoryTaxonomy as $tax) {
			$catArr[] = $tax->name;
		}

		$categories = join(", ", $catArr);
	}

	$return .= $categories . " @ " . $location;
	$return .= sprintf("<li>Arrangør: %s</li>", $event_meta['dak_event_arranger_name'][0]);
	$return .= sprintf("<li>CC: %s</li>", $event_meta['dak_event_covercharge'][0]);
	$return .= sprintf("<li>Aldersgrese: %s</li>", (isset($event_meta['dak_event_age_limit'][0])?$event_meta['dak_event_age_limit'][0]:"20 år, 18 med studentbevis"));


	// 	Konsert i Teglverket
	// Arrangør: RF
	// CC: 200,-
	// Aldersgrense: 20 år (18 med studentbevis/forhåndskjøpt billett)
	return $return;
}

/**
 * Returns the name of menu in given location check out register_nav_menus() (in this file) for valid input
 * @since Kvarteret.no v2.0
 */
function kvarteret_get_menu_name($location){
    if(!has_nav_menu($location)) 
    	return false;

    $menus = get_nav_menu_locations();
    $menu_title = wp_get_nav_menu_object($menus[$location])->name;

    return $menu_title;
}

add_action( 'load-themes.php', 'kvarteret_flush_rewrite_rules');
function kvarteret_flush_rewrite_rules() {
	global $pagenow, $wp_rewrite;
	
	if ( $pagenow == 'themes.php' && isset($_GET['activated']) ) {
		flush_rewrite_rules();
	}
}

add_action('switch_theme', 'kvarteret_deactivate');
function kvarteret_deactivate() {
	remove_action('page_rewrite_rules', 'kvarteret_rewrite_rules');

	flush_rewrite_rules();
}
