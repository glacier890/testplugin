<?php

include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/class-bblist-user.php' );

function bbpresslist_process_follow() {
  if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
    $user_id = $_POST['user_id'];
    $follower_id = $_POST['follow_id'];
    $new_follow = new BBPressList_User;

   //$tesing = $new_follow->add_user_to_list( $user_id, $follower_id );
   $testing = $new_follow->add_user_to_list($user_id, $follower_id );

  }
  echo $testing;
die();
}


add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');
add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');

?>
