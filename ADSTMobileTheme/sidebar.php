<?php
/**
 * @package WordPress
 * @subpackage Website_Theme
 * @since Website 1.0
 */
?>


<?php if ($sidebar = Website::getSidebarName()): ?>

	<aside id="aside" class="<?php echo Website::getThemeOption('appearance/sidebar') == 'right' ? 'beta' : 'alpha'; ?>">		
					
		<?php 
			
		// Load the contents of the Sidebar Events field into a variable	
		$sideMenu = get_field('sidebar_events', 91);	
		
		// if the Sidebar Events field contains a value, display the .sidebarCalendar div
		if($sideMenu): ?>
		
		<div class="sideCalendar wysiwyg widget"> <!-- style="display: none;" -->
			
				<h1>Partners</h1>

				<?php
 
				// check if the repeater field has rows of data
				if( have_rows('partner_logos', 2389) ): ?> 
					<div id="partnerLogos">
					<ul class="slides" style="margin: 0; padding: 0;"> 
				 <?php
				 	// loop through the rows of data
				    while ( have_rows('partner_logos', 2389) ) : the_row(); ?>
						
						<li style="list-style: none; display: none;">
						
						<?php $partnerLink = get_sub_field('partner_logo_link'); ?>

							<?php if( $partnerLink ): ?>
								<a href="<?php echo $partnerLink; ?>" target="_blank">
							<?php endif; ?>
						
						<?php 
							// pull in the product image
							$partnerLogo = get_sub_field('partner_logo');
							if( !empty($partnerLogo) ):
						 ?>
							 
							<img style="max-width: 100%;" src="<?php echo $partnerLogo['url']; ?>" alt="<?php echo $partnerLogo['alt']; ?>" />
							
							<?php endif; ?>
					
							<?php if( $partnerLink ): ?>
								</a>
							<?php endif; ?>
				
						</li>
				 
				 <?php
				 
				endwhile; ?>
				 
				  </ul></div>
				
				<?php else :
				 
				    // no rows found
				 
				endif;

				?>
		
		</div>		


		<div class="sideCalendar wysiwyg widget">
			
				<h1>Upcoming Events</h1>

				<?php echo $sideMenu; ?>
		
		</div>
		
		<?php endif; ?>

		
		<ul>
			<?php dynamic_sidebar('sidebar-'.$sidebar); ?>
		</ul>
		
		<div class="sidebarButtons buttonRow">
			
			<?php
 
				// check if the repeater field has rows of data
				if( have_rows('homepage_banner', 2389) ):
				 
				 	// loop through the rows of data
				    while ( have_rows('homepage_banner', 2389) ) : the_row(); ?>
									
					<a href="<?php the_sub_field('banner_link'); ?>" <?php if( get_sub_field('open_new_window') ): ?>target="_blank"<?php endif; ?> >
						
						<?php 
							// pull in the product image
							$image = get_sub_field('banner_image');
							if( !empty($image) ):
						 ?>
							 
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
							
							<?php endif; ?>
					
					</a>
				 
				 <?php
				 
				endwhile;
				 
				else :
				 
				    // no rows found
				 
				endif;
				 
				?>
			
			
		</div>

	</aside>

<?php endif; ?>