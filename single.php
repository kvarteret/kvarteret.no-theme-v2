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

<?php get_sidebar(); ?>
<?php get_footer(); ?>