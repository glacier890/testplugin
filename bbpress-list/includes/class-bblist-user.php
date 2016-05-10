<?php
//Exit if defined directly
if ( ! defined('ABSPATH')) exit;

class BBPressList_User {

  /**
  * Retreives users that have added a specific user to their BBPress List
  *
  * Gets all users following $user_id
  *
  * @access private
  * @since 1.0
  * @param 		int $user_id - the ID of the user to retrieve followers for
  * @return      array
  */

  function get_followers( $user_id = 0 ) {
    if ( empty ( $user_id ) ) {
      $user_id = get_current_user_id();
    }
    $followers = get_user_meta ( $user_id, '_bbpresslist_followers', true );

    return apply_filters( '_bbpresslist_followers', $followers, $user_id );

  }

  /**
  * Retreives users that the current user has added to their BBPress List
  *
  * Gets all users following $user_id
  *
  * @access private
  * @since 1.0
  * @param 		int $user_id - the ID of the user to retrieve followers for
  * @return      array
  */

  function get_following ( $user_id = 0 ) {
    if ( empty ( $user_id ) ) {
      $user_id = get_current_user_id();
    }
    $following = get_user_id( $user_id, 'bbpresslist_following', true);

    return apply_filters( 'bbpresslist_following', $following, $user_id );

  }

  function add_user_to_list( $user_id, $user_added = 0 ) {
    $users_in_list = $this->get_following( $user_id );
    if ( ! empty( $users_in_list ) && in_array ( $users_in_list ) ) {
      $users_in_list[] = $user_added;
    } else {
      $users_in_list = array();
      $users_in_list[] = $user_added;
    }
    $followers = $this->get_followers( $user_added );
    if( ! empty( $followers ) && in_array ( $followers ) ) {
      $followers[] = $user_id;
    } else {
      $followers = array();
      $followers[] = $user_id;
    }

    do_action( 'bbpresslist_pre_follow_user', $user_id, $user_added );

    // update the IDs that this user has in their BBPress List
    $followed = update_user_meta ( $user_meta, 'bbpresslist_following', $users_in_list );

    $followers = update_user_meta ( $user_added, '_bbpresslist_followers', $followers );
  }

}

global $classBBPressList;
$classBBPressList = new BBPressList_User();

?>
