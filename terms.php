<?php
/**
 * Template Name: Terms-Service
 */
get_header(); 

global $ultimatemember;
$user_stuff = $ultimatemember->user->usermeta;
$agreed_terms = $user_stuff['agreed_terms'][0];
//echo $agreed_terms;
?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php

			the_content();
			wp_link_pages( array(
				'before' => '<p class="wp-link-pages"><span>' . __( 'Pages:', 'krown' ) . '</span>'
				)
			);

			if( comments_open() && ot_get_option( 'krown_allow_page_comments', 'false' ) == 'true' ) {
				comments_template( '', true );
			}

			if ( $agreed_terms == 'true' ) {
				echo '<div class="terms-service-container">';
				echo '<p>You have already accepted these Terms and Conditions</p>';
				echo '</div>';
			} else {
				if ( is_user_logged_in() ) {
				echo '<div class="terms-service-container">';
				echo '<a class="boxit-button" id="terms-button">I accept</a>';
				echo '</div>';
				}
			}
		?>

	<?php endwhile;     

get_footer(); ?>