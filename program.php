<?php
/**
 * The Template for displaying the program from an XML-file
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */

get_header(); ?>

	<article id="primary" class="standard_wrapper content_container clearfix">
		<header class="single_header article_header clearfix">
			<h1><?php the_title(); ?></h1>
		</header>

		<section class="article_content two-thirds column">
	<?php
$file = simplexml_load_file("http://www.linticket.no/xml/Kvarteret/index.php3");

for ($i = 0; $i < count($file) -1; $i++) {

    $arrangement = $file->arrangement[$i];

    $linkstart = ($arrangement->link) ? '<a href="'.$arrangement->link.'">' : '';
    $linkend = ($arrangement->link) ? '</a>' : '';
    $img = ($arrangement->bilde) ? '<li><img src='.$arrangement->bilde.'></li>' : '';

    $date = new DateTime($arrangement->dato);
    $date = $date->format('l d. F - Y');
    $dayarray = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
    $dayreplacearray = array('mandag','tirsdag','onsdag','torsdag','fredag','lørdag','søndag');
    $montharray = array('January','February','March','April','May','June','July','August','September','October','November','December');
    $monthreplacearray = array('januar','februar','mars','april','mai','juni','juli','august','september','oktober','november','desember');
    $splitdate = explode(' ',$date);

    $date = ucfirst(str_replace($dayarray,$dayreplacearray,$splitdate[0])).' '.$splitdate[1].' '.str_replace($montharray,$monthreplacearray,$splitdate[2]).' '.$splitdate[3].' '.$splitdate[4];

    echo '<ul>';
    echo '<li>'.$date.'</li>';
    echo $img;
    echo '<li>'.$linkstart.'<strong>'.$arrangement->navn.'</strong>'.$linkend.'</li>';
    echo '<li>'.$arrangement->tekst.'</li>';
    echo '<li>'.$arrangement->sted.'</li>';
    echo '<li><strong>Start:</strong>'.substr($arrangement->starttid,0,-4).' - <strong>Slutt:</strong>'.substr($arrangement->slutttid,0,-4).'</li>';
    echo '</ul>';
}

?>
	
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

	</article><!-- #primary -->
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.kvarteret.socialMedia.js"></script>
	<script type="text/javascript">
		socialMedia('<?php echo urlencode(get_permalink()); ?>');
		// socialMedia('http%3A%2F%2Fkvarteret.no')
	</script>
<?php get_footer(); ?>