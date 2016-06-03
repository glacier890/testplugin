jQuery(document).ready(function($){

$( ".bbpresslist-edit-follower" ).dialog({
  autoOpen: false
});

$('.bbp-user-edit-followers-link').click(function(event){
    event.preventDefault();
  $('.bbpresslist-edit-follower').dialog("open");
})

  /*******************************
add / delete a user from your list
*******************************/



$('.follow-link a').click(function(event){
  event.preventDefault();


    var current_user_id = $(this).data('user-id');
    var current_follow_id = $(this).data('follow-id');

  $.ajax({
  url: bbpresslist_js.ajaxurl,
  type:'POST',
    data: {
      "action" : $(this).hasClass('follow') ? "bbpresslist_process_follow" : "bbpresslist_process_unfollow",
      "user_id": current_user_id,
      "follow_id": current_follow_id },
  success: function(results){
    if (results == 'follow'){
      $('.follow-link .follow').attr('class', 'unfollow').text('Unfollow this user');
    } else {
      $('.follow-link .unfollow').attr('class', 'follow').text('Follow this user');
    }
  }
});
})



})
