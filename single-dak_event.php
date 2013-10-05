<?php
/**
 * The Template for displaying all event posts.
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

/* TODO
	Content, image, start-end, arranger, arranger logo, category
*/
$language = 'en_EN';
get_header(); ?>

	<article id="primary" class="standard_wrapper content_container clearfix">
		<?php 	while ( have_posts() ) : the_post(); 
					$event_meta = get_post_meta(get_the_ID());
		?>
		<header class="single_header article_header clearfix">
			<?php 
				if( has_post_thumbnail() ) {
					the_post_thumbnail('full-thumbnail', array('class' => 'article_thumbnail responsive'));
				} else {
					echo '<img src="' . get_bloginfo('template_directory') . '/images/missing_image.png" alt="" clasS="article_thumbnail responsive" />';
				}
			?>
			<h1><?php the_title(); ?></h1>
		</header>

		<section class="article_content two-thirds column">
			<?php the_excerpt(); ?>

			<?php the_content(); ?>
		</section>

		<aside class="meta one-third column">
			<?php echo kvarteret_event_meta(get_the_ID(), $event_meta); ?> 
			<div class="share clearfix">
				<a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>&t=<?php echo urlencode(get_the_title()); ?>" class="facebook_share" title="Del på Facebook">Del på facebook</a>
				<a href="http://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>&text=<?php the_title(); ?>&via=Kvarteret" target="_blank" rel="nofollow" class="twitter_share" alt="Del på Twitter">Del på Twitter</a>
			</div>
			<?php dynamic_sidebar('single-event'); ?>
		</aside>
		<?php endwhile; // end of the loop. ?>	


	</article><!-- #primary -->
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.kvarteret.socialMedia.js"></script>
	<script type="text/javascript">
		socialMedia('<?php echo urlencode(get_permalink()); ?>');
		// socialMedia('http%3A%2F%2Fkvarteret.no')
	</script>
<?php get_footer(); ?>
