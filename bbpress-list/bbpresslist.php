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

 class BBPressList {

  public function __construct(){
   add_action('bbp_template_after_user_profile', array($this, 'saysomething'));
   add_action ('bbp_theme_before_reply_author_details', array($this, 'robin_w_posted_by')) ;
  //  echo '</br></br><h3>HEy</h3>';
  }



public function saysomething() {
  echo 'Sweet plugin';
}

function robin_w_posted_by ()
  {
echo 'A thought by' ;
  }


}

global $BBPressLists;
   $$BBPressLists = new BBPressList();

 ?>


 ?>
