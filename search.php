<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

get_header(); ?>

	<section id="primary" class="standard_wrapper content_container clearfix">

		<?php 
			$wp_query->query_vars["posts_per_page"] = 12;
			$wp_query->get_posts();

			if ( have_posts() ) : 
		?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<section class="articles no_padding no_margin grid_fix">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="one-third column">
						<a href="<?php the_permalink(); ?>">
							<?php
								if(has_post_thumbnail()) {
									the_post_thumbnail('one-third-thumbnail',  array('class' => 'article_thumbnail responsive'));
								} else {
									echo '<img src="' . get_bloginfo('template_directory') . '/images/missing_image_296x153.png" alt="" clasS="article_thumbnail responsive" />';
								}
							?>
							<h2>
								<?php 
									$post_type = get_post_type( $post->ID );
									if($post_type == "dak_event")
										echo 'Arrangement: ';
									elseif($post_type == "post")
										echo 'Artikkel: ';
									elseif($post_type == "dak_smugmug")
										echo 'Bildeserie: ';

									the_title(); 
									?>
							</h2>
						</a>
						<?php $event_meta = get_post_meta(get_the_ID()); ?>
						<p><?php the_excerpt(); ?></p>
					</article>
				<?php endwhile; ?>
			</section>
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
		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>