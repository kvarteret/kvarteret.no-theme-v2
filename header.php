<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  	================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
  	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  	================================================== -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
	<link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-114x114.png">

	<!-- Pingback, etc
	================================================== -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/bootstrap.js"></script>
	
	<?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>

	<div class="container">
		<?php dynamic_sidebar('above-header'); ?>
		<header id="main_header">
		
			<a href="http://kvarteret.no" id="logo" class="clearfix">
				<img src="<?php bloginfo('template_directory'); ?>/images/kvarteret.png" id="logo_light" alt="Det Akademiske Kvarter" />
				<img id="logo_dark" src="<?php bloginfo('template_directory'); ?>/images/kvarteret_dark.png" alt="Det Akademiske Kvarter" />
			</a>
			
			<ul id="kvarteret_feeds" class="">
				<li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/facebook.png" alt="Facebook" /></a></li>
				<li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" alt="Twitter" /></a></li>				
				<li><a href=""><img src="<?php bloginfo('template_directory'); ?>/images/rss.png" alt="RSS 2.0" /></a></li>
			</ul>
			
			<form id="search" action="<?php echo site_url(); ?>/?" method="get">
				<input type="text" name="s" placeholder="søk..." />
				<button>Søk</button>
			</form>
			
			<nav id="main_nav">
				<a class="btn_navbar_toggle" data-toggle="collapse" data-target=".nav-collapse">
					Nav
				</a>
				<div class="nav-collapse">
					<?php wp_nav_menu( array( 'container_class' => 'left', 'theme_location' => 'main_navigation_left' ) ); ?>
				</div>
				<div class="nav-collapse">
					<?php wp_nav_menu( array( 'container_class' => 'right', 'theme_location' => 'main_navigation_right' ) ); ?>
				</div>
			</nav>
			
			<section id="opening_times" class="standard_wrapper">
				<?php dynamic_sidebar('opening-times'); ?>
			</section>
			
		</header>

		<?php dynamic_sidebar('below-header'); ?>