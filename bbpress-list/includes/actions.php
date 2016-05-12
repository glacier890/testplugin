<?php

include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/class-bblist-user.php' );

function bbpresslist_process_follow() {
  if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
    $user_id = $_POST['user_id'];
    $follower_id = $_POST['follow_id'];
    $new_follow = new BBPressList_User;

    $follow_action = $new_follow->add_user_to_list($user_id, $follower_id );


  }
  echo $follow_action;
die();
}


add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');
add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');

function bbpresslist_process_unfollow() {
  if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
    $user_id = $_POST['user_id'];
    $follower_id = $_POST['follow_id'];
    $unfollow = new BBPressList_User;

    $unfollow_action = $unfollow->remove_user_to_list($user_id, $follower_id );


  }
  echo $unfollow_action;
die();
}


add_action('wp_ajax_bbpresslist_process_unfollow', 'bbpresslist_process_unfollow');
add_action('wp_ajax_bbpresslist_process_unfollow', 'bbpresslist_process_unfollow');

?>
