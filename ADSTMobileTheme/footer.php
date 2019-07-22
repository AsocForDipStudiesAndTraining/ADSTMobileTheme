<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>

			</div>
		</div>
		<!-- // Main section -->


		

</div> <!-- /.outerContainer -->
		

		<!-- Bottom section -->
		<footer id="bottom" class="<?php if (Website::getThemeOption('footer/fixed')) echo 'fixed'; ?>">
			<div class="container footerContainer">
				
				<div class="footerLogo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="/images/OHA-footer-logo.png" alt="Oral History Association Logo" /></a></div>
				
				<p class="copyright">&copy; Copyright <?php echo date("Y")?> Oral History Association</p>

				<?php get_sidebar('bottom');  ?>

				<!-- Footer -->
				<section id="footer" class="clear">
					<p class="alpha"><?php echo nl2br(Website::getThemeOption('footer/text/left')); ?></p>
					<p class="beta"><?php echo nl2br(Website::getThemeOption('footer/text/right')); ?></p>
				</section>
				<!-- // Footer -->

			</div>
		</footer>
		<!-- // Bottom section -->


<script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function() {
    jQuery('#partnerLogos').flexslider({
controlNav: false,               
directionNav: false, 
useCSS: false,
randomize: true
	});
  });
</script>


		<?php wp_footer(); ?>

	</body>
</html>
