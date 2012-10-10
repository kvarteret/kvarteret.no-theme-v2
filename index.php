<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

get_header(); ?>
	<section id="frontpage_articles" class="standard_wrapper content_container clearfix">
		<?php if ( have_posts() ) : ?>
			<?php
		        global $post;
		        $featured = get_posts('numberposts=3&category_name=featured'); // featured news
		        $current_news = get_posts('numberposts=10&category_name=aktuelt,featured'); // all frontpage news
        	?>
			<h1 class="hidden">Nyheter</h1>
			<ul id="featured_articles" class="sixteen no_margin no_padding columns featured_articles" style="width:100%">
				<?php
				// start featured news loop
			  	foreach($featured as $post) :
					setup_postdata($post);
				?>
				<li>
					<article>
						<a  href="<?php the_permalink(); ?>" class="clearfix">
							<!-- <img src="http://placekitten.com/960/496" class="article_thumbnail responsive" alt="" /> -->
							<?php the_post_thumbnail('full-thumbnail', array('class' => 'article_thumbnail responsive')); ?>
							<h2><?php the_title(); ?></h2>
						</a>
					</article>
				</li>
				<?php endforeach; ?>
			</ul>

			<?php
				// start news loop
				foreach($current_news as $post) :
					setup_postdata($post);
			?>

				<article class="one-third column">

					<a href="<?php the_permalink(); ?>">
						<!-- <img src="http://placekitten.com/300/155" class="article_thumbnail responsive" alt="" /> -->
						<?php the_post_thumbnail('one-third-thumbnail',  array('class' => 'article_thumbnail responsive')); ?>
						<h2><?php the_title(); ?></h2>
					</a>
					<p><?php the_excerpt(); ?></p>
				</article>

			<?php endforeach; ?>
		<?php endif; ?>
	</section>

			

			

			<?php /*while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; */?>


	</section><!-- #frontpage_articles -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>