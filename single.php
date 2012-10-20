<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

get_header(); ?>

	<article id="primary" class="standard_wrapper content_container clearfix">
		<?php while ( have_posts() ) : the_post(); ?>
		<header class="single_header article_header clearfix">
			<?php the_post_thumbnail('full-thumbnail', array('class' => 'article_thumbnail responsive')); ?>
			<h1><?php the_title(); ?></h1>
		</header>

		<section class="article_content two-thirds column">
			<?php the_content(); ?>
		</section>

		<aside class="meta one-third column">
			<div class="date">
				Publisert <?php the_time( 'j. F Y' ); ?>
			</div>
			<?php echo kvarteret_author_meta(get_the_author_meta('ID'), get_post_meta($post->ID, "article_author", true)); ?> 
			<div class="share clearfix">
				<a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>&t=<?php echo urlencode(get_the_title()); ?>" class="facebook_share" title="Del på Facebook">Del på facebook</a>
				<a href="http://twitter.com/share?url=<?php echo urlencode(get_permalink()); ?>&text=<?php the_title(); ?>&via=Kvarteret" target="_blank" rel="nofollow" class="twitter_share" alt="Del på Twitter">Del på Twitter</a>
			</div>
			<?php dynamic_sidebar('single-post'); ?>
		</aside>
		<?php endwhile; // end of the loop. ?>	


					<?php // get_template_part( 'content', get_post_format() ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						//if ( comments_open() || '0' != get_comments_number() )
						//	comments_template( '', true );
					?>


	</article><!-- #primary -->
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.kvarteret.socialMedia.js"></script>
	<script type="text/javascript">
		socialMedia('<?php echo urlencode(get_permalink()); ?>');
		// socialMedia('http%3A%2F%2Fkvarteret.no')
	</script>
<?php get_footer(); ?>