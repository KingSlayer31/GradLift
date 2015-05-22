<?php 

// this got moved to page.php in the backer-child theme folder
// if ( isset($_GET['paykey']) && $_GET['mdid_checkout'] == 1 ){
//     include '_receipt.php';
// }


add_action('um_before_form', 'add_container', 500 );
function add_container(){
    echo '<div class="gradline-container">';
        echo '<div class="gradline-main">';
}

add_action('um_after_form', 'close_container', 500 );
function close_container(){
        global $ultimatemember;
        $current_user = wp_get_current_user();
        $current_role = $current_user->roles;
        $current_login = $current_user->data->user_login;
        $current_nicename = $current_user->data->user_nicename; // this is the login username

        $um_user = $ultimatemember->user->data;
        $um_login = $um_user['data']['user_login'];
        $um_nicename['data']['user_nicename']; // this is the login username
        
        echo '</div>';
        echo '<div class="gradline-sidebar">';
            if ( $current_login == $um_login || $current_role[0] == "administrator") {
                include '_sidebar_message.php';
            }
            include '_widget.php';
        echo '</div>';
    echo '</div>';
}

?>


