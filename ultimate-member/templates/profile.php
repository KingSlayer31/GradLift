<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo $form_id; ?>" data-error_required="This field is required" data-password_not_match="Passwords do not match" data-password_not_long="Password must be 8 characters at least">

	<div class="um-form">
	
		<?php if ( um_is_on_edit_profile() ) { ?><form method="post" action=""><?php } ?>
		
			<?php do_action('um_profile_header_cover_area', $args ); ?>
			
			<?php do_action('max_um_profile_header', $args ); ?>
			
			<?php do_action('um_profile_navbar', $args ); ?>
			
			<?php
				
			$nav = $ultimatemember->profile->active_tab;
			$subnav = ( get_query_var('subnav') ) ? get_query_var('subnav') : 'default';
				
			print "<div class='um-profile-body $nav $nav-$subnav'>";
				
				// Custom hook to display tabbed content
				do_action("um_profile_content_{$nav}", $args);
				do_action("um_profile_content_{$nav}_{$subnav}", $args);
				
			print "</div>";
				
			?>
		
		<?php if ( um_is_on_edit_profile() ) { ?></form><?php } ?>
	
	</div>
	
</div>
<div id="comments" class="comments-area"> </div>
