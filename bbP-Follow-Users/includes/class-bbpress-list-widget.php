<?php
class BBPressList_Widget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct( false, 'BBPress Favorite Users',
	 		array( 'description'=> 'Widget allows the user to view BBPress posts from forum authors they are following.'));
}

	/**
	* Displays the widget.
	*/
	function widget( $args, $instance ) {
		// Stops function if user is logged in
		if ( ! is_user_logged_in() ) {
			return;
		}
		echo '<section id="bbp-list-following-widget" class="widget widget_bbplist-following-posts">';
		$current_user = get_current_user_id();
		// Widget output
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo '<h2>' . $title . '</h2>';

		$get_users = new BBPressList_User;

		// returns array of users the logg-ed user is following
		$get_followers = $get_users->get_following( $current_user );

		if( !empty( $get_followers ) ) {
			$followers_string = implode(',', $get_followers);

			if ( empty ( $instance['max_posts_shown'] ) ) {
				$instance['max_posts_shown'] = 16;
			}


		$bbp_args = array(
		'post_type'      => array( bbp_get_topic_post_type(), bbp_get_reply_post_type() ), // Narrow query down to bbPress topics
		'author'				=> $followers_string,
		'posts_per_page'	=> (int) $instance['max_posts_shown'],
		'ignore_sticky_posts'	=> true,
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

		} else {
			echo "<p>You are not currently following any users.</p>";
		}
		echo '</section>';
	}

	/**
	* Saves widget settings.
	*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['max_posts_shown'] = (int) $new_instance['max_posts_shown'];

		return $instance;
	}

	/**
	* Widget settings form
	*/
	function form( $instance ) {
		$title = esc_attr($instance['title']);
		$maxpostsshown = esc_attr($instance['max_posts_shown']);
		?>
		<p>
  	<label>Title</label>
  	<input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<label>Maximum replies to show: </label>
		<input class="widefat" name="<?php echo $this->get_field_name('max_posts_shown'); ?>" type="text" value="<?php echo $maxpostsshown; ?>" />
		<?php
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("BBPressList_Widget");' ) );
?>
