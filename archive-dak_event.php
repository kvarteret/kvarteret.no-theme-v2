<?php
/**
 * Template Name: Eventlist
 *
 * Description: The template for displaying a list of events
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

get_header(); ?>
	<section id="primary" class="standard_wrapper content_container clearfix standard-padding event-list">
		<a class="big button right" href="#">Arrangere</a>
		<h1>På Kvarteret</h1>
	
		<nav id="event_nav" class="event_nav clearfix">
			<ul>
				<li class="active"><a href="">neste 14 dager</a></li>
				<li><a href="">September</a></li>
				<li><a href="">Oktober</a></li>
				<li><a href="">November</a></li>
				<li><a href="">Desember</a></li>
				<li><a href="">Arkiv</a></li>
			</ul>
			<form class="white right js-search" action="<?php echo site_url(); ?>/?post_type=dak_event&s=" method="get">
				<input type="text" name="s" placeholder="søk..." />
				<input type="hidden" name="post_type" value="dak_event" />
				<button>Søk</button>
			</form>
		</nav>
		<?php 
			$event_query = new WP_Query(
				array(
					'post_type' => 'dak_event',
					'post_status' => 'published',
					'meta_key' => 'dak_event_start_date',
					'meta_value' => date('Y-m-d'),
					'meta_compare' => '>=',
					'orderby' => 'meta_value',
					'order' => 'ASC',
				)
			);

			error_log($event_query->request);
			$current_date = date('Y-m-d');
			$loop_active_start_date = "";
			$loop_active_start_time = "";

			// The Loop
			while ( $event_query->have_posts() ) : $event_query->the_post();
				$event_meta = get_post_meta(get_the_ID());
				$css_offset_by = "";

				// echo date headline
				if($loop_active_start_date != $event_meta['dak_event_start_date'][0]) {
					$loop_active_start_date = $event_meta['dak_event_start_date'][0];
					echo '<div class="date clear_both offset-top-by-one">'.date('l, j. F Y', strtotime($event_meta['dak_event_start_date'][0])).'</div>';
				}

				if($loop_active_start_time != $event_meta['dak_event_start_time'][0]) {
					$loop_active_start_time = $event_meta['dak_event_start_time'][0];
					$css_offset_by = "";
					echo '<div class="event time two columns text-right">'.$event_meta['dak_event_start_time'][0].'</div>';
				} else {
					$css_offset_by = "offset-by-two";
				}

		?>
				<div class="event content fourteen columns inline-block <?=$css_offset_by; ?>">
					<h2 class="inline-block"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> <small class="time">(<?=$event_meta['dak_event_start_time'][0];?> - <?=$event_meta['dak_event_end_time'][0];?>)</small></h2>
					
					<div class="meta">
							<?php if($event_meta['dak_event_covercharge'][0]) { 
								echo 'CC: ' . $event_meta['dak_event_covercharge'][0]; 
							} else { 
							} 
							?>
						• Aldersgrense: <?php if($event_meta['dak_event_age_limit'][0]) { 
								echo $event_meta['dak_event_age_limit'][0]; 
							} else { 
								echo '18 for studenter 20 for andre'; 
							} ?>
					</div>
				</div>
		<?php 
			endwhile; 
		?>

	</section>
<?php get_footer(); ?>
