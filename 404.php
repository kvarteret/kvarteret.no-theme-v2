<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

get_header(); ?>
	<section class="standard_wrapper content_container standard_padding">
		<article id="post-0" class="post error404 no-results not-found">
			<iframe class="full_width to_the_top" width="960" height="540" src="http://www.youtube.com/embed/GxnC4pZnG9o" frameborder="0" allowfullscreen></iframe>
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'twentytwelve' ); ?></h1>
			</header>

			<div class="entry-content">
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentytwelve' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->
	</section><!-- #primary -->

<?php get_footer(); ?>