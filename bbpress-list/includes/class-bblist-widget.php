<?php
class BBPressList_Widget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'BBPress Favorite Users' );
}

	/**
	* Displays the widget.
	*/
	function widget( $args, $instance ) {

		// Stops function if user is logged in
		if ( ! is_user_logged_in() ) {
			return;
		}

		$current_user = get_current_user_id();
		// Widget output
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo '<h2>' . $title . '</h2>';


		$get_users = new BBPressList_User;

		// returns array of users the logg-ed user is following
		$get_followers = $get_users->get_following( $current_user );

		$followers_string = implode(',', $get_followers);


		$bbp_args = array(
		'post_type'      => bbp_get_topic_post_type(), // Narrow query down to bbPress topics
		'author'				=> $followers_string,
		);

		// Calls Loop to display users that the current user is following.
		$bbp_list_widget = new WP_Query( $bbp_args );

		if ( ! $bbp_list_widget->have_posts() ) {
			return;
		} ?>

		<ul>

		<?php while ( $bbp_list_widget->have_posts() ) : $bbp_list_widget->the_post();
			$topic_id = bbp_get_topic_id( $bbp_list_widget->post->ID );
			$author_link = bbp_get_topic_author_link( array( 'post_id' => $topic_id, 'type' => 'name' ) );
			?>
			<li>
				<a class="bbp-forum-title" href="<?php bbp_topic_permalink( $topic_id ); ?>"><?php bbp_topic_title( $topic_id ); ?></a>
				<div>
					Posted by: <span><?php echo $author_link; ?></span>
				</div>
				<div>
					<?php bbp_topic_last_active_time( $topic_id ); ?>
				</div>
			</li>

<?php endwhile;


	}

	/**
	* Saves widget settings.
	*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	/**
	* Widget settings form
	*/
	function form( $instance ) {
		$title = esc_attr($instance['title']);
		?>
		<p>
  <label>Title</label>
  <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<?php

	}
}



add_action( 'widgets_init', create_function( '', 'return register_widget("BBPressList_Widget");' ) );
?>
