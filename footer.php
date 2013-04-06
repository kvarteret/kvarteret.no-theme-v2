<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package Kvarteret.no
 * @subpackage Kvarteret.no v2
 * @since Kvarteret.no v2.0
 */
?>
		<?php dynamic_sidebar('above-footer'); ?>
		<footer>
			<div class="standard_wrapper clearfix">
				<?php dynamic_sidebar('the-footer-nav'); ?>
				<div class="three columns offset-by-one">
					<h2><?php echo kvarteret_get_menu_name('det_akademiske_kvarter'); ?></h2>
					<?php
						wp_nav_menu(array(
							'theme_location'  => 'det_akademiske_kvarter',
							'echo'            => true,
							'fallback_cb'     => false,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 1,
						));
					?>
				</div>
				<div class="three columns">
					<h2><?php echo kvarteret_get_menu_name('kvarteret_no'); ?></h2>
					<?php
						wp_nav_menu(array(
							'theme_location'  => 'kvarteret_no',
							'echo'            => true,
							'fallback_cb'     => false,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 1,
						));
					?>
				</div>
				<div class="three columns">
					<h2>Kulturarrangører</h2>
					<ul>
						<li><a href="">ASF</li></a>
						<li><a href="">RF</li></a>
						<li><a href="">Bergen Filmklubb</li></a>
						<li><a href="">Immaturus</li></a>
						<li><a href="">Samfunnet</li></a>
					</ul>
				</div>
				<div class="three columns">
					<h2>Arrangere på Kvarteret</h2>
					<ul>
						<li><a href="">Betingelser</li></a>
						<li><a href="">Romoversikt</li></a>
						<li><a href="">Romsøknad</li></a>
						<li><a href="">Bestille tjenester</li></a>
						<li><a href="">Teknisk Raider</li></a>
						<li><a href="">Brukerkontrakt</li></a>
					</ul>
				</div>
				<div class="three columns">
					<h2>Arbeidsgrupper</h2>
					<ul>
						<li><a href="">PR-etaten</li></a>
						<li><a href="">Skjenkegruppen</li></a>
						<li><a href="">Vaktetaten</li></a>
						<li><a href="">Kraftetaten</li></a>
						<li><a href="">Personalgruppen</li></a>
						<li><a href="">E-tjenesten</li></a>
						<li><a href="">Romvesenet</li></a>
						<li><a href="">Rettsvesenet</li></a>

						<li><a href="">KVAST</li></a>
					</ul>
				</div>
			</div>
			<?php dynamic_sidebar('the-footer-copyright'); ?>
			
		</footer>
		<?php dynamic_sidebar('below-footer'); ?>
		
	</div><!-- .container -->

<?php wp_footer(); ?>

<script type="text/javascript">
	$('.carousel').carousel();
</script>
</body>
</html>