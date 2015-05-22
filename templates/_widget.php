<?php
global $ultimatemember;
global $current_user;
global $permalink_structure;
    if (empty($permalink_structure)) {
        $prefix = '&';
    }
    else {
        $prefix = '?';
    }
    // we want the user id of the profile not the logged in user id
    $user_id = $ultimatemember->user->id;
    // $user_id = $current_user->ID;

    $creator_args = array(
        'post_type' => 'ignition_product',
        'author' => $user_id,
        'posts_per_page' => -1,
        'post_status' => array('draft', 'pending', 'publish')
    );
    $user_projects = get_posts($creator_args);

    // ASSUMPTION: User can only create one campaign
    $gradline_project = $user_projects[0]->ID;

    $project_id = get_post_meta( $gradline_project, 'ign_project_id', true );
    $project = new ID_Project( $project_id );
    $percent = get_post_meta( $gradline_project, 'ign_percent_raised', true ) != '' ? get_post_meta( $gradline_project, 'ign_percent_raised', true ) : 0;
    $goal = get_post_meta($gradline_project, 'ign_fund_goal', true);
    $colors = get_option( 'krown_colors' );
    
    $retina = krown_retina();
    
    $user_profile = get_site_url() . '/user/' . get_the_author_meta('user_nicename');

    $widget_shortcode = '[project_page_widget product="'. $project_id .'"]';

?>   

<div style="display: none">
<?php echo do_shortcode($widget_shortcode); ?>
</div>

<!--
<ul class="gradlineshare share-buttons">

	<li><a href=""><i class="fa fa-twitter"></i></a></li>
	<li><a href=""><i class="fa fa-facebook"></i></a></li>
	<li><a href=""><i class="fa fa-linkedin"></i></a></li>
	
</ul>
-->

<?php echo do_shortcode( '[sharify]' );?>

<div class="krown-id-item"><div class="container">
            <aside class="meta">

                <div class="krown-pie medium" data-color="<?php echo ( intval( $percent ) > 99 ? $colors['pie3'] : $colors['pie1'] ); ?>">
                    <div class="holder">
                        <span class="value" data-percent="<?php echo $percent; ?>"><?php echo $percent; ?><sup>%</sup></span>
                    </div>
                </div>

                <ul>
                    <li><span><?php echo apply_filters( 'id_funds_raised', getTotalProductFund( $project_id ), $project_id ) . '</span> ' . __( 'pledged', 'krown' ); ?></li>
                    <li><span>$<?php echo $goal ?></span> goal amount</li>
                    <li><span><?php echo $project->get_project_orders() ?> </span>pledges</li>
                    <li><?php echo do_shortcode($widget_shortcode); ?></li>
                </ul>

            </aside>
</div></div>