<?php


function bbpresslist_process_follow() {
  if ( isset( $_POST['user_id'] ) && isset( $_POST['follow_id'] ) ) {
    if ( $classBBPressList->add_user_to_list(  absint( $_POST['user_id'] ), absint( $_POST['follow_id'] ) ) ) {
      echo 'success';
    } else {
      echo 'Failed';
    }
  }
  die();
}


add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');
add_action('wp_ajax_bbpresslist_process_follow', 'bbpresslist_process_follow');

?>
