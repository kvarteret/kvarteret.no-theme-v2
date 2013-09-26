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
	'paged' => get_query_var('paged')
);

// Begin building of page

get_header(); ?>
	<section id="primary" class="standard_wrapper content_container clearfix standard-padding event-list">
		<a class="big button right" href="#">Arrangere</a>
		<h1>På Kvarteret</h1>
	
		<nav id="event_nav" class="event_nav clearfix">
			<ul>
				<li class="active"><a href="<?php echo get_page_link() ?>">neste 14 dager</a></li>
				<?php 

				$dt = new DateTime();
				for ($i = 0; $i < 4; $i++) {
					echo '<li><a href="' . get_page_link() . $dt->format('Y/m') .'">' . date_i18n('F', $dt->getTimestamp()). '</a></li>';
					$dt = $dt->add(new DateInterval('P1M'));
				}

				?>
				<li><a href="">Arkiv</a></li>
			</ul>
			<form class="white right js-search" action="<?php echo site_url(); ?>/?post_type=dak_event&s=" method="get">
				<input type="text" name="s" placeholder="søk..." />
				<input type="hidden" name="post_type" value="dak_event" />
				<button>Søk</button>
			</form>
		</nav>
		<?php
			$event_query = new WP_Query($query_array);

			$current_date = date('Y-m-d');
			$loop_active_start_date = "";
			$another_temp_date = "";
			$loop_active_start_time = "";

			// The Loop
			while ( $event_query->have_posts() ) : $event_query->the_post();
				$event_meta = get_post_meta(get_the_ID());
				$css_offset_by = "";

				// echo date headline
				if($loop_active_start_date != $event_meta['dak_event_start_date'][0]) {
					$loop_active_start_date = $event_meta['dak_event_start_date'][0];
					echo '<div class="date clear_both offset-top-by-one">'.strftime('%A, %d. %B %Y', strtotime($event_meta['dak_event_start_date'][0])).'</div>';
				}

				if($loop_active_start_time != $event_meta['dak_event_start_time'][0] || $another_temp_date != $loop_active_start_date) {
					$another_temp_date = $loop_active_start_date;
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

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $event_query->max_num_pages
				) );
			?>
		</div>
	</section>
<?php get_footer(); ?>
