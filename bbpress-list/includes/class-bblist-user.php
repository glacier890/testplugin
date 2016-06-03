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
/*
    public function __construct( $user_id, $follow_id ){

    if ( ! empty ( $user_id ) && ! empty ( $follow_id ) ) {
      $this->user_id = (int) $user_id;
      $this->follow_id = (int) $follow_id;

    }
    //return $this->add_user_to_list();

  }
*/
  function get_followers( $user_id ) {

    $followers = get_user_meta($user_id, '_bbpresslist_followers', true );

    return $followers;

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

  public function get_following($user_id)  {

  $following = get_user_meta( $user_id, '_bbpresslist_following', true);

    return $following;

  }

  function add_user_to_list( $user_id, $follower_id ) {
   $newuser_id = $user_id;

  $users_in_list = $this->get_following($newuser_id);


    if ( ! empty( $users_in_list )  ) {
      $users_in_list[] = $follower_id;
    } else {
      $users_in_list = array();
      $users_in_list[] = $follower_id;
    }


    $followers = $this->get_followers( $newuser_id );
    if( ! empty( $followers ) && in_array ( $followers ) ) {
      $followers[] = $user_id;
    } else {
      $followers = array();
      $followers[] = $user_id;
    }

    //do_action( 'bbpresslist_pre_follow_user', $user_id, $user_added );

    // update the IDs that this user has in their BBPress List

   update_user_meta ( $user_id, '_bbpresslist_following', $users_in_list );

  update_user_meta ( $follower_id, '_bbpresslist_followers', $followers );


return 'follow';

  }

function remove_user_to_list( $user_id = 0, $unfollow_user = 0 ) {



	// get all IDs that $user_id follows
	$following = $this->get_following( $user_id );

	if ( is_array( $following ) && in_array( $unfollow_user, $following ) ) {

		$modified = false;

		foreach ( $following as $key => $follow ) {
			if ( $follow == $unfollow_user ) {
				unset( $following[$key] );
				$modified = true;
			}
		}

		if ( $modified ) {
		 update_user_meta( $user_id, '_bbpresslist_following', $following );
		}

	}
  // get all IDs that follow the user we have just unfollowed so that we can remove $user_id
	$followers = $this->get_followers( $unfollow_user );

	if ( is_array( $followers ) && in_array( $user_id, $followers ) ) {

		$modified = false;

		foreach ( $followers as $key => $follower ) {
			if ( $follower == $user_id ) {
				unset( $followers[$key] );
				$modified = true;
			}
		}

		if ( $modified ) {
			update_user_meta( $unfollow_user, '_bbpresslist_followers', $followers );
		}

	}

	return 'unfollow';

}

function is_following( $user_id = 0, $followed_user = 0 ) {

	$following = $this->get_following( $user_id );
	$ret = false; // is not following by default
	if ( is_array( $following ) && in_array( $followed_user, $following ) ) {
		$ret = '1'; // is following
	}
	return $ret;

}

}

//global $classBBPressList;
//$classBBPressList = new BBPressList_User();

?>
