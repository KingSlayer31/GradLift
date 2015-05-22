
<?php 
// $project_id = get_post_meta( $post->ID, 'ign_project_id', true );
// $project = new ID_Project( $project_id );
// $percent = get_post_meta( $post->ID, 'ign_percent_raised', true ) != '' ? get_post_meta( $post->ID, 'ign_percent_raised', true ) : 0;
// $colors = get_option( 'krown_colors' );
// $retina = krown_retina();

global $ultimatemember;
$user_stuff = $ultimatemember->user->usermeta;
$user_id = $ultimatemember->user->id;
$complete_profile = $user_stuff['first_name'][0];

$creator_args = array(
    'post_type' => 'ignition_product',
    'author' => $user_id,
    'posts_per_page' => 1,
    'post_status' => array('draft', 'pending', 'publish')
);
$user_projects = get_posts($creator_args);
// ASSUMPTION: User can only create one campaign
$project_status = $user_projects[0]->post_status;

$message_complete_profile = 'Complete your profile so you can submit your scholarship';
$message_complete_scholarship = 'Complete the last steps on the "Gradlift Scholarship" tab';
$message_draft = 'Your scholarship has been opened but is not approved yet. If we need extra documentation we will let you know via email or in the "Gradlift Scholarship" tab.';
$message_published = 'Your scholarship is live and public!';

if (!$complete_profile) {
    $step = 1;
}
if ($complete_profile) {
    $step = 2;
}
if ($project_status == 'draft') {
    $step = 3;
}
if ($project_status == 'publish') {
    $step = 4;
}

// $step = 4;

?>

<section class="gradline-next-step">
<?php 
    if ($step == 1) {
        echo '<header>Next Step:</header>';
        echo '<p>';
        echo $message_complete_profile;
        echo '</p>';
    }
    if ($step == 2) {
        echo '<header>Next Step:</header>';
        echo '<p>';
        echo $message_complete_scholarship;
        echo '</p>';
    }
    if ($step == 3) {
        echo '<header>Scholarship Status:</header>';
        echo '<p>';
        echo $message_draft;
        echo '</p>';
    }
    if ($step == 4) {
        echo '<header>Scholarship Status:</header>';
        echo '<p>';
        echo $message_published;
        echo '</p>';
    }
?>
</section>



