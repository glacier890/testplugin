<?php
/**
 * Plugin Name: bbP Follow Users
 * Version: 1.0
 * Description: A plugin to help you create list of users you want to follow on bbPress.
 * Author: kcbluewave890
 * Author URI:  www.github.com/kcbluewave890
 * Text Domain: bbP-Follow-Users
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */



if(!defined('BBPRESSLIST_FOLLOW_DIR')) define('BBPRESSLIST_FOLLOW_DIR', dirname( __FILE__ ) );
if(!defined('BBPRESSLIST_FOLLOW_URL')) define('BBPRESSLIST_FOLLOW_URL', plugin_dir_url( __FILE__ ) );


/**
* Core class for bbPress Follow Users
*
* @package bbP Follow Users
*
* @since 1.0
*/

class BBPress_List_Follow {

  /**
   * Constructor.
   *
   * Fires the hooks that load the scripts and displays the views.
  */
  public function __construct(){

    $this->setup_actions();
    $this->includes();
  }

/**
* Includes.
*/

  function includes() {
    include_once(BBPRESSLIST_FOLLOW_DIR . '/includes/actions.php');
    include_once(BBPRESSLIST_FOLLOW_DIR . '/includes/class-bbpress-list-user.php');
    include_once(BBPRESSLIST_FOLLOW_DIR . '/includes/class-bbpress-list-widget.php');
  }


  function setup_actions() {
    add_action ( 'bbp_enqueue_scripts', array( $this, 'load_scripts' ) );
    add_action('bbp_theme_after_reply_author_details', array($this, 'followlinks'));
  }

  /**
  * Enqueues the scripts.
  */

  function load_scripts(){
    wp_enqueue_script( 'follow-js', plugins_url('js/follow.js', __FILE__), array('jquery', 'jquery-ui-dialog'));
    wp_localize_script( 'follow-js', 'bbpresslist_js', array(
      'processing_error' => __( 'There was a problem processing your request.', 'pwuf' ),
  		'login_required'   => __( 'Oops, you must be logged-in to follow users.', 'pwuf' ),
  		'logged_in'        => is_user_logged_in() ? 'true' : 'false',
      'ajax_nonce'       => wp_create_nonce('bbpresslist_nonce'),
      'ajaxurl'          => admin_url('admin-ajax.php'),
      ) );
}

/**
* Loads the follow links below the user information inside the forums.
*
* @package bbP Follow Users
*
* @since 1.0
*/

  function followlinks() {
    ob_start();
    $iffollow = new BBPressList_User;
    $reply_author_id = get_post_field( 'post_author', bbp_get_reply_id() );
  	$user_data = get_userdata( $reply_author_id );
  	$follow_id = $user_data->ID;
    $user_id = get_current_user_id();
    if ($user_id !== $follow_id) {
      if( $iffollow->is_following( $user_id, $follow_id ) ) { ?>
        <div class="follow-link">
          <a href="#" class="unfollow" data-user-id="<?php echo $user_id; ?>" data-follow-id="<?php echo $follow_id; ?>">Unfollow this user</a>
        </div>
        <?php } else { ?>
          <div class="follow-link">
            <a href="#" class="follow"  data-user-id="<?php echo $user_id; ?>" data-follow-id="<?php echo $follow_id; ?>">Follow this user</a>
          </div>
          <?php }
        }
        echo ob_get_clean();
  }
}

global $BBPressLists;
   $$BBPressLists = new BBPress_List_Follow();

 ?>
