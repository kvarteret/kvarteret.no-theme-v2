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
					<h2><?php echo kvarteret_get_menu_name('culture_arrangers'); ?></h2>
					<?php
						wp_nav_menu(array(
							'theme_location'  => 'culture_arrangers',
							'echo'            => true,
							'fallback_cb'     => false,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 1,
						));
					?>
				</div>
				<div class="three columns">
					<h2><?php echo kvarteret_get_menu_name('arrange'); ?></h2>
					<?php
						wp_nav_menu(array(
							'theme_location'  => 'arrange',
							'echo'            => true,
							'fallback_cb'     => false,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 1,
						));
					?>
				</div>
				<div class="three columns">
					<h2><?php echo kvarteret_get_menu_name('workgroups'); ?></h2>
					<?php
						wp_nav_menu(array(
							'theme_location'  => 'workgroups',
							'echo'            => true,
							'fallback_cb'     => false,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 1,
						));
					?>
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