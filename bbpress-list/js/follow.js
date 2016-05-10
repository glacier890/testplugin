jQuery(document).ready(function($){
  /*******************************
add / delete a user from your list
*******************************/
$('.bbpresslist-follow').click(function(event){
  event.preventDefault();

  var $this = $(this);

  var data = {
    action: 'bbpresslist_process_follow',
    user_id: $this.data('user-id'),
    follow_id: $this.data('follow-id'),
    nonce: bbpresslist_js.nonce
  }
  $.ajax({
  url: bbpresslist_js.ajaxurl,
  type:'POST',
  data: data,
  success: function(results){
  alert('User has been added.');
  }
});
})

})
