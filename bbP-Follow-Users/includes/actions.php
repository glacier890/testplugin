<?php

/**
* actions
*
* @package bbP Follow Users
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/class-bbpress-list-user.php' );

/**
* AJAX callback when clicking on Follow this user to follow a user on bbPress.
* @since 1.0
*/

function bbpresslist_process_follow() {
  check_ajax_referer( 'bbpresslist_nonce', 'security' );
  if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
    $user_id = sanitize_text_field( $_POST['user_id'] );
    $follower_id = sanitize_text_field( $_POST['follow_id'] );
    $new_follow = new BBPressList_User;

    $follow_action = $new_follow->add_user_to_list($user_id, $follower_id );


  }
  echo $follow_action;
die();
}


add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');
add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');

/**
* AJAX callback when clicking on Unfollow this user to unfollow a user on bbPress.
* @since 1.0
*/

function bbpresslist_process_unfollow() {
  check_ajax_referer( 'bbpresslist_nonce', 'security' );
  if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
    $user_id = sanitize_text_field( $_POST['user_id'] );
    $follower_id = sanitize_text_field( $_POST['follow_id'] );
    $unfollow = new BBPressList_User;

    $unfollow_action = $unfollow->remove_user_to_list($user_id, $follower_id );

  }
  echo $unfollow_action;
die();
}


add_action('wp_ajax_bbpresslist_process_unfollow', 'bbpresslist_process_unfollow');
add_action('wp_ajax_bbpresslist_process_unfollow', 'bbpresslist_process_unfollow');

?>
