<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package legit
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<aside id="legit-footer" class="widget-area widget-area--footer">
			<div class="site-branding widget">
				<?php the_custom_logo(); ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			</div><!-- .site-branding -->
			<?php dynamic_sidebar( 'footer-1' ); ?>

			<?php legit_footer_site_info(); ?>
		</aside><!-- #legit-footer -->
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
