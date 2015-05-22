<?php
/**
 * The Template for displaying all pages.
 */
get_header(); 

if ( isset($_GET['paykey']) && $_GET['mdid_checkout'] == 1 ){
    include 'templates/_receipt.php';
}

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

		?>

	<?php endwhile;     

get_footer(); ?>