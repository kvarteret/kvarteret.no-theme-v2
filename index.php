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
	<section id="frontpage_articles" class="standard_wrapper content_container clearfix grid_fix">
		<?php if ( have_posts() ) : ?>
			<?php
		        global $post;

		        $featuredArray = array_merge(
	        		get_posts('numberposts=3&category_name=featured'), 
	        		get_posts('numberposts=3&dak_event_category=featured')
	        	);

		        $featured = get_posts('numberposts=3&category_name=featured'); // featured news
		        $current_news = get_posts('numberposts=12&category_name=aktuelt,featured'); // all frontpage news
        	?>
			<h1 class="hidden">Nyheter</h1>
			<section id="featured_articles" class="sixteen no-padding columns featured_articles carousel slide">
				<div class="carousel-inner">
				<?php
				// start featured news loop
				$featuredi = 0;
			  	foreach($featuredArray as $post) :
					setup_postdata($post);
					$featuredi++
				?>

					<article class="item <?php if($featuredi == 1) { echo 'active'; } ?>">
						<a href="<?php the_permalink(); ?>" class="clearfix">
							<!-- <img src="http://placekitten.com/960/496" class="article_thumbnail responsive" alt="" /> -->
							<?php the_post_thumbnail('full-thumbnail', array('class' => 'article_thumbnail responsive')); ?>
							<h2><?php the_title(); ?></h2>
						</a>
					</article>
				<?php endforeach; ?>
				</div>
				<a class="carousel-control left" href="#featured_articles" data-slide="prev">&lsaquo;</a>
  				<a class="carousel-control right" href="#featured_articles" data-slide="next">&rsaquo;</a>
			</section>
			<section class="articles no_padding no_margin">
			<?php
				// start news loop
				foreach($current_news as $post) :
					setup_postdata($post);
			?>

				<article class="one-third column">

					<a href="<?php the_permalink(); ?>">
						<?php
							if(has_post_thumbnail()) {
								the_post_thumbnail('one-third-thumbnail',  array('class' => 'article_thumbnail responsive'));
							} else {
								echo '<img src="' . get_bloginfo('template_directory') . '/images/missing_image_296x153.png" alt="" clasS="article_thumbnail responsive" />';
							}
						?>
						<h2><?php the_title(); ?></h2>
					</a>
					<p><?php the_excerpt(); ?></p>
				</article>

			<?php endforeach; ?>
			<div style="clear:both" class="text-center standard-padding">
				<?php
					global $wp_query;

					$big = 999999999; // need an unlikely integer

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages
					) );
				?>
			</div>
			</section>

		<?php endif; ?>
	</section>

<?php get_footer(); ?>