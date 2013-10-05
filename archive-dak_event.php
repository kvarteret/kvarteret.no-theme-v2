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

// Set query params, specifically start and end of date range
$year = get_query_var('year');
$monthnum = get_query_var('monthnum');

$pageId = get_the_ID();

error_log($year . ' ' . $monthnum);

$dtStart = new DateTime();
$dtEnd = clone $dtStart;
$dtEnd->add(new DateInterval('P14D'));

if ($year != '' && $monthnum != '') {
	$dtStart->setDate($year, $monthnum, 1);
	$dtEnd = clone $dtStart;
	$dtEnd->add(new DateInterval('P1M')); // Add one month
} else if ($year != '') {
	$dtStart->setDate($year, 1, 1);
	$dtEnd = clone $dtStart;
	$dtEnd->add(new DateInterval('P1Y')); // Add one year
}

// Set up query
$query_array = array(
	'post_type' => 'dak_event',
	'meta_query' => array(
		'start' => array(
			'key' => 'dak_event_start_date',
			'value' => $dtStart->format('Y-m-d'),
			'compare' => '>=',
			'type' => 'DATETIME'
		),
		'end' => array(
			'key' => 'dak_event_start_date',
			'value' => $dtEnd->format('Y-m-d'),
			'compare' => '<',
			'type' => 'DATETIME'
		)
	),
	'order' => 'ASC',
	'meta_key' => 'dak_event_start_datetime',
	'orderby' => 'meta_value',
	'paged' => get_query_var('paged')
);

$tags = get_query_var('tags');
if (!empty($tags)) {
	$query_array['tax_query'] = array(
		array(
			'taxonomy' => 'dak_event_category',
			'field' => 'slug',
			'terms' => explode(',', $tags),
			'operator' => 'AND'
		)
	);
}

$event_query = new WP_Query($query_array);

// Begin building of page

get_header(); ?>
	<section id="primary" class="standard_wrapper content_container clearfix standard-padding event-list">
		<a class="big button right" href="#">Arrangere</a>
		<h1>På Kvarteret</h1>
	
		<nav id="event_nav" class="event_nav clearfix">
			<ul>
				<li <?php if (empty($year) && empty($monthnum)) echo 'class="active"' ?>><a href="<?php echo get_page_link() ?>">neste 14 dager</a></li>
				<?php 

				$dt = new DateTime();
				for ($i = 0; $i < 4; $i++) {
					$active = "";
					if ($dt->format('Yn') == $year.$monthnum) {
						$active = "active";
					}
					echo '<li class="'.$active.'"><a href="' . get_page_link() . $dt->format('Y/m') .'">' . date_i18n('F', $dt->getTimestamp()). '</a></li>';
					$dt = $dt->add(new DateInterval('P1M'));
				}

				?>
				<?php // <li><a href="">Arkiv</a></li> ?>
			</ul>
			<form class="white right js-search" action="<?php echo site_url(); ?>/?post_type=dak_event&s=" method="get">
				<input type="text" name="s" placeholder="søk..." />
				<input type="hidden" name="post_type" value="dak_event" />
				<button>Søk</button>
			</form>
		</nav>
		<?php
			$current_date = date('Y-m-d');
			$loop_active_start_date = "";
			$another_temp_date = "";
			$loop_active_start_time = "";

			// The Loop

			while ( $event_query->have_posts() ) : $event_query->the_post();
				$event_meta = get_post_meta(get_the_ID());
				$css_offset_by = "";

				$start_datetime = strtotime($event_meta['dak_event_start_datetime'][0]);
				$end_datetime = strtotime($event_meta['dak_event_end_datetime'][0]);

				// echo date headline
				if($loop_active_start_date != $event_meta['dak_event_start_date'][0]) {
					$loop_active_start_date = $event_meta['dak_event_start_date'][0];
					echo '<div class="date clear_both offset-top-by-one">'. date_i18n('l j. F Y', strtotime($start_datetime)).'</div>';
				}

				if($loop_active_start_time != $event_meta['dak_event_start_time'][0] || $another_temp_date != $loop_active_start_date) {
					$another_temp_date = $loop_active_start_date;
					$loop_active_start_time = $event_meta['dak_event_start_time'][0];
					$css_offset_by = "";
					echo '<div class="event time two columns text-right">'. datE_i18n('H:i', $start_datetime) .'</div>';
				} else {
					$css_offset_by = "offset-by-two";
				}

		?>
				<div class="event content fourteen columns inline-block <?=$css_offset_by; ?>">
					<h2 class="inline-block">
					  <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					  <small class="time">
					    (<?php echo date_i18n('H:i', $start_datetime); ?> - <?php echo date_i18n('H:i', $end_datetime); ?>)
                      </small>
					</h2>
					
					<div class="meta">
						<?php if(!empty($event_meta['dak_event_covercharge'][0])) { 
								echo 'CC: ' . $event_meta['dak_event_covercharge'][0] . ' • '; 
							}
							?>
						Aldersgrense: <?php if(!empty($event_meta['dak_event_age_limit'][0])) { 
								echo $event_meta['dak_event_age_limit'][0]; 
							} else { 
								echo '18 for studenter, 20 for andre'; 
							} ?>
					</div>
				</div>
		<?php 
			endwhile; 
		?>
		<div style="clear:both" class="text-center standard-padding">
			<?php
				global $event_query;

				$big = 999999999; // need an unlikely integer

				$nextLinkComponents = array();
				if (!empty($tags)) {
					$nextLinkComponents['tags'] = explode(',', $tags);
				}
				$prevLinkComponents = $nextLinkComponents;

				$linkTextDateFormat = "";

				$dtNext = clone $dtStart;
				$dtPrev = clone $dtStart;

				if (!empty($year) && empty($monthnum)) {
					$dtNext->add(new DateInterval("P1Y"));
					$dtPrev->sub(new DateInterval("P1Y"));

					$nextLinkComponents['year'] = $dtNext->format("Y");
					$prevLinkComponents['year'] = $dtPrev->format("Y");

					$linkTextDateFormat = "Y";
				} else {
					$dtNext->add(new DateInterval("P1M"));
					$dtPrev->sub(new DateInterval("P1M"));
					
					$nextLinkComponents['year'] = $dtNext->format("Y");
					$nextLinkComponents['monthnum'] = $dtNext->format("m");

					$prevLinkComponents['year'] = $dtPrev->format("Y");
					$prevLinkComponents['monthnum'] = $dtPrev->format("m");
					
					$linkTextDateFormat = "Y/m";
				}

				$prevURL = kvarteret_event_archive_link_maker($pageId, $prevLinkComponents);
				$nextURL = kvarteret_event_archive_link_maker($pageId, $nextLinkComponents);

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $event_query->max_num_pages
				) );

				echo "<div class=\"month-year-nav\">\n";
				echo "<a href=\"" . $prevURL . "\" class=\"page-numbers\">" . $dtPrev->format($linkTextDateFormat) . "</a>\n";
				echo "<a href=\"" . $nextURL . "\" class=\"page-numbers\">" . $dtNext->format($linkTextDateFormat) . "</a>\n";
				echo "</div>\n";
			?>
		</div>
	</section>
<?php get_footer(); ?>
