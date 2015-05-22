<?php

/* This file should contain all the functions of the child theme. Most of the theme's functions can be overwritten (some are critical and shouldn't be tampered with). 

--- Below you have a full list of the ones which you can look up in the parent theme's functions.php file and redeclare here:

- krown_retina (to disable retina images by setting the cookie always to False)
- krown_setup (to add things at theme setup - should be modified with care)
- krown_analytics
- krown_filter_wp_title (to change how the theme's title appears)
- krown_excerptlength_post (to change the lenght of the post's excerpt in carousel shortcode)
- krown_excerptlength_post_big (to change the lenght of the post's excerpt in the blog view)
- krown_excerptmore (to change the chars which appear after the post's excerpt)
- krown_excerpt
- krown_search_form (to modify the structure of the search form)
- krown_pagination
- krown_check_page_title (builds up the title of the page)
- krown_custom_header (outputs custom headers for pages)
- krown_sidebar (to determine the sidebar)
- krown_sidebar_output (to insert the sidebar)
- krown_share_buttons (adds social sharing buttons)

--- Below you have a list of the ones which you can look up in the parent theme's includes/custom-styles.php file and redeclare here:

- krown_custom_css (if you want to get rid of the custom css output in the DOM and move everything here) 

--- Below you have a list of the ones which you can look up in the parent theme's includes/ignitiondeck-functions.php file and redeclare here:

- krown_add_dashboard_links (adds dashboard links when IDE is activated)
- krown_author_profile (builds up the author profile on ID archive pages)
- krown_id_ppp (sets ID projects per page in ID archives)

*/

include( 'includes/plugins.php' ); // Includes the plugins all over again

global $ultimatemember;
$current_user = wp_get_current_user();
$current_role = $current_user->roles;
$current_login = $current_user->data->user_login;

$um_user = $ultimatemember->user->data;
$um_login = $um_user['data']['user_login'];


// load custom javascript file
wp_enqueue_script('gradlift_js', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ));

// declare javascript variable so ajax can call php functions
wp_localize_script( 'gradlift_js', 'gradlift_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

// add ajax call to update user status
add_action('wp_ajax_update_gradlift', 'update_gradlift');

//function to update transcripts
function update_gradlift(){
    global $ultimatemember;
    $user_data = $_POST['user_data'];

    if ($user_data == 'transcripts') {
        $to_update['are_transcripts_submitted'] = 'true';    
    }
    if ($user_data == 'summary') {
        $to_update['is_summary_submitted'] = 'true';    
    }
    if ($user_data == 'loans') {
        $to_update['are_loans_submitted'] = 'true';    
    }
    if ($user_data == 'terms') {
        $to_update['agreed_terms'] = 'true';    
    }
    
    $ultimatemember->user->update_profile( $to_update );

    exit;
}

// add gradline tab and change name of "About" tab
add_filter('um_profile_tabs', 'um_profile_tabz', 101 );
function um_profile_tabz( $tabs ) {
    global $ultimatemember;
    $current_user = wp_get_current_user();
    $current_role = $current_user->roles;
    $current_login = $current_user->data->user_login;
    $current_nicename = $current_user->data->user_nicename; // this is the login username

    $um_user = $ultimatemember->user->data;
    $um_login = $um_user['data']['user_login'];
    $um_nicename['data']['user_nicename']; // this is the login username

    $tabs['main'] = array(
        'name' => __('GradLine','ultimatemember'),
        'icon' => 'um-faicon-graduation-cap'
    );

    if ( $current_login == $um_login || $current_role[0] == "administrator") {
        $tabs['campaign'] = array(
            'name' => __('Your GradLift Scholarship','ultimatemember'),
            'icon' => 'um-faicon-user'
        );
    }

		$tabs['comments'] = array(
			'name' => __('Comments','ultimatemember'),
			'icon' => 'um-faicon-comment',
			'count' => max_um_count_user_comments(),
		);
    
    return $tabs;
}

// load custom profile template
add_action('um_profile_content_main', 'load_profile');
function load_profile(){
    include 'templates/_profile.php';
}

// load "your Gradlift Scholarship Page"
add_action('um_profile_content_campaign', 'load_campaign');
function load_campaign() {
    global $ultimatemember;
    $current_user = wp_get_current_user();
    $current_role = $current_user->roles;
    $current_login = $current_user->data->user_login;
    $current_nicename = $current_user->data->user_nicename; // this is the login username

    $um_user = $ultimatemember->user->data;
    $um_login = $um_user['data']['user_login'];
    $um_nicename['data']['user_nicename']; // this is the login username

    if ( $current_login == $um_login || $current_role[0] == "administrator") {
        include 'templates/_projects.php';
    }
}



//	remove_action('um_profile_header', 'um_profile_header' );
	add_action('max_um_profile_header', 'max_um_profile_header' );

	function max_um_profile_header( $args ) {
		global $ultimatemember;
		
		$classes = null;

		// MAX EDIT		
                $user_stuff = $ultimatemember->user->usermeta; 
                $user_school = $user_stuff['school'][0];
                $user_degree = $user_stuff['major'][0];

		if ( !$args['cover_enabled'] ) {
			$classes .= ' no-cover';
		}
		
		$default_size = str_replace( 'px', '', $args['photosize'] );
		
		$overlay = '<span class="um-profile-photo-overlay">
			<span class="um-profile-photo-overlay-s">
				<ins>
					<i class="um-faicon-camera"></i>
				</ins>
			</span>
		</span>';
		
		?>
		
			<div class="um-header<?php echo $classes; ?>">
			
				<?php do_action('um_pre_header_editprofile', $args); ?>
				
				<div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">

					<a href="<?php echo um_user_profile_url(); ?>" class="um-profile-photo-img" title="<?php echo um_user('display_name'); ?>"><?php echo $overlay . get_avatar( um_user('ID'), $default_size ); ?></a>
					
					<?php
					
					if ( !isset( $ultimatemember->user->cannot_edit ) ) { 
					
						$ultimatemember->fields->add_hidden_field( 'profile_photo' );
						
						if ( !um_profile('profile_photo') ) { // has profile photo
						
							$items = array(
								'<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">'.__('Upload photo','ultimatemember').'</a>',
								'<a href="#" class="um-dropdown-hide">'.__('Cancel','ultimatemember').'</a>',
							);
							
							echo $ultimatemember->menu->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
							
						} else if ( $ultimatemember->fields->editing == true ) {
						
							$items = array(
								'<a href="#" class="um-manual-trigger" data-parent=".um-profile-photo" data-child=".um-btn-auto-width">'.__('Change photo','ultimatemember').'</a>',
								'<a href="#" class="um-reset-profile-photo" data-user_id="'.um_profile_id().'" data-default_src="'.um_get_default_avatar_uri().'">'.__('Remove photo','ultimatemember').'</a>',
								'<a href="#" class="um-dropdown-hide">'.__('Cancel','ultimatemember').'</a>',
							);
							
							echo $ultimatemember->menu->new_ui( 'bc', 'div.um-profile-photo', 'click', $items );
							
						}
					
					}
					
					?>
					
				</div>
				
				<div class="um-profile-meta">
				
					<div class="um-main-meta">

						<?php if ( $args['show_name'] ) { ?>
						<div class="um-name">
							
							<a href="<?php echo um_user_profile_url(); ?>" title="<?php echo um_user('display_name'); ?>"><?php echo um_user('display_name'); ?></a>
							
							<?php do_action('um_after_profile_name_inline', $args ); ?>
						
                        <?php 
                            if ($user_school) {
                                echo '<div class="um-school">';
                                echo $user_school;
                                echo '</div>';
                            }
                            if ($user_degree) {
                                echo '<div class="um-degree">';
                                echo $user_degree;
                                echo '</div>';
                            }
                        ?>                   
						</div>
						<?php } ?>
						
						<div class="um-clear"></div>
						
						<?php do_action('um_after_profile_header_name_args', $args ); ?>
						<?php do_action('um_after_profile_header_name'); ?>
						
					</div>
					
					<?php if ( isset( $args['metafields'] ) && !empty( $args['metafields'] ) ) { ?>
					<div class="um-meta">
						
						<?php echo $ultimatemember->profile->show_meta( $args['metafields'] ); ?>
							
					</div>
					<?php } ?>

					<?php if ( $ultimatemember->fields->viewing == true && um_user('description') && $args['show_bio'] ) { ?>
					
					<div class="um-meta-text"><?php echo um_filtered_value('description'); ?></div>
					
					<?php } else if ( $ultimatemember->fields->editing == true  && $args['show_bio'] ) { ?>
					
					<div class="um-meta-text">
						<textarea placeholder="<?php _e('Tell us a bit about yourself...','ultimatemember'); ?>" name="<?php echo 'description-' . $args['form_id']; ?>" id="<?php echo 'description-' . $args['form_id']; ?>"><?php if ( um_user('description') ) { echo um_user('description'); } ?></textarea>
						
						<?php if ( $ultimatemember->fields->is_error('description') )
							echo $ultimatemember->fields->field_error( $ultimatemember->fields->show_error('description') ); ?>
						
					</div>
					
					<?php } ?>
					
					<div class="um-profile-status <?php echo um_user('account_status'); ?>">
						<span><?php printf(__('This user account status is %s','ultimatemember'), um_user('account_status_name') ); ?></span>
					</div>
					
				</div><div class="um-clear"></div>
				
			</div>
			
		<?php
	}


//	remove_action('init', array( 'UM_Builtin', 'set_predefined_fields' ) );
	add_action('max_um_reset_password_form', 'max_um_reset_password_form');
	function max_um_reset_password_form() {
$form = <<<END
		<div class="um-field um-field-password_reset_text" data-key="password_reset_text">
								<div class="um-field-block"><div style="text-align:center">To reset your password, please enter your email address below</div></div>
							</div><div class="um-field um-field-username_b" data-key="username_b"><div class="um-field-area"><input  class="um-form-field valid " type="text" name="username_b" id="username_b" value="" placeholder="Enter your email" data-validate="" data-key="username_b" autocomplete="on" />
							
						</div></div>		
		<div class="um-col-alt um-col-alt-b">
		
			<div class="um-center"><input type="submit" value="Reset my password" class="um-button" /></div>
			
			<div class="um-clear"></div>
			
		</div>
END;
echo $form ;
	}

	add_action('max_um_change_password_form', 'max_um_change_password_form');
	function max_um_change_password_form() {
	
		global $ultimatemember;

		$fields = $ultimatemember->builtin->get_specific_fields('user_password'); ?>
		
		<?php $output = null;
		foreach( $fields as $key => $data ) {
			$output .= $ultimatemember->fields->edit_field( $key, $data );
		}echo $output; ?>
		
		<div class="um-col-alt um-col-alt-b">
		
			<div class="um-center"><input type="submit" value="<?php _e('Change my password','ultimatemember'); ?>" class="um-button" /></div>
			
			<div class="um-clear"></div>
			
		</div>
		
		<?php
		
	}

//add_filter('comment_form_default_fields', 'max_custom_fields');
add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );
function additional_fields() {
		global $ultimatemember;
                $user_id = $ultimatemember->user->id; 
		echo  '<input type="hidden" name="max_um_user_id" value="' . $user_id . '" />';
}
function max_custom_fields($fields) {
		// MAX EDIT		
		global $ultimatemember;
                $user_id = $ultimatemember->user->id; 
		$fields['max_um_user_id'] = '<input type="hidden" name="max_um_user_id" value="' . $user_id . '" />';
//		return $fields ;
}
	add_filter('preprocess_comment', 'max_change_comment_author') ;
	function max_change_comment_author( $comment ) {
	//print_r( $comment) ;
	$comment['user_ID'] = (int) $_POST['max_um_user_id'];
	return $comment ;
	}

	// copy from plugins/ultimate-member/core/um-user-posts.php
	function max_um_count_user_comments( $user_id = null ) {
		global $wpdb;
		if ( !$user_id )
			$user_id = um_user('ID');
		
		if ( !$user_id ) return 0;

		$count = $wpdb->get_var("SELECT COUNT(comment_ID) FROM " . $wpdb->comments. " WHERE user_id = " . $user_id . " AND comment_approved = '1'");
		
		return apply_filters('um_pretty_number_formatting', $count);
	}
?>
