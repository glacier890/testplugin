<?php
/**
 * Plugin Name: BB Press List
 * Version: 1.0
 * Plugin URI: https://wpclubmanager.com
 * Description: A plugin to help you create list of users you want to follow.
 * Author: Bryan Cisler
 * Author URI:
 * Requires at least: 3.8
 * Tested up to: 4.4.1
 *
 * Text Domain: bbpress-list
 * Domain Path:
 *
 */

if(!defined('BBPRESSLIST_FOLLOW_DIR')) define('BBPRESSLIST_FOLLOW_DIR', dirname( __FILE__ ) );
if(!defined('BBPRESSLIST_FOLLOW_URL')) define('BBPRESSLIST_FOLLOW_URL', plugin_dir_url( __FILE__ ) );

include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/actions.php' );
include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/class-bblist-user.php' );

 class BBPressList {

  public function __construct(){
   add_action ('wp_enqueue_scripts', array($this, 'load_scripts'));
   add_action('bbp_theme_after_reply_author_details', array($this, 'followlinks'));
   $this->includes();

  }

function includes() {
  include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/actions.php' );
  include_once( BBPRESSLIST_FOLLOW_DIR . '/includes/class-bblist-user.php' );
}

function load_scripts(){
  wp_enqueue_script( 'follow-js', plugins_url('js/follow.js', __FILE__), array('jquery'));
  wp_localize_script( 'follow-js', 'bbpresslist_js', array(
    'processing_error' => __( 'There was a problem processing your request.', 'pwuf' ),
		'login_required'   => __( 'Oops, you must be logged-in to follow users.', 'pwuf' ),
		'logged_in'        => is_user_logged_in() ? 'true' : 'false',
    'ajaxurl'          =>      admin_url( 'admin-ajax.php' ),
    'nonce'            => wp_create_nonce( 'follow_bbpresslist_nonce' )
     ) );
}

function followlinks() {
  ob_start();
  $iffollow = new BBPressList_User;
  $reply_author_id = get_post_field( 'post_author', bbp_get_reply_id() );
		$user_data = get_userdata( $reply_author_id );
		$follow_id = $user_data->ID;
    $user_id = get_current_user_id();
  ?>
  <?php if ($user_id !== $follow_id) {
    if( $iffollow->is_following( $user_id, $follow_id ) ) { ?>
  <div class="follow-link">
    <a href="#" class="unfollow" data-user-id="<?php echo $user_id; ?>" data-follow-id="<?php echo $follow_id; ?>">Unfollow this user</a>
  </div>
  <?php } else { ?>
    <div class="follow-link">
      <a href="#" class="follow" data-user-id="<?php echo $user_id; ?>" data-follow-id="<?php echo $follow_id; ?>">Follow this user</a>
    </div>
  <?php }
 }
  echo ob_get_clean();
}




}

global $BBPressLists;
   $$BBPressLists = new BBPressList();

 ?>
