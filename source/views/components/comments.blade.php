<?php

// This is a required file:
// developer.wordpress.org/themes/release/required-theme-files/

# Leave if post password is required and not provided.
if ( post_password_required() ) {
	return;
}

/**
* Single comment layout.
*
* Provided as a callback to wp_list_comments().
*
* @since  1.0
* @param  object  $comment  The current comment.
* @param  array  $args  The arguments passed to wp_list_comments().
* @param  int  $depth  Unsure whether is the current comment depth or the maximum comment depth.
* @return  void
*/
function primeraFunctionPrefix_comment_layout($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;

	$comment_reply_link = get_comment_reply_link( array_merge( $args, array(
		'reply_text' => esc_html_x('Reply','Comment reply link','primeraTextDomain'),
		'depth'      => (int)$depth,
		'max_depth'  => (int)$args['max_depth'],
	) ) );

	$text = esc_html_x('Edit','Comment edit link','primeraTextDomain');
	$link = '<a class="comment-edit-link" href="'.esc_url( get_edit_comment_link($comment) ).'">'.$text.'</a>';
	$edit_comment_link = apply_filters( 'edit_comment_link', $link, $comment->comment_ID, $text );

	?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class('comment'); ?>>
		<div class="comment-inner">

			<?php
				if ( $avatar_size = absint($args['avatar_size']) ) {
					echo '<div class="comment-avatar">';
					echo get_avatar( $comment, min( $avatar_size, 512 ) );
					echo '</div>';
				}
			?>

			<div class="comment-main">
				<div class="comment-meta">
					<span class="comment-author"><?php comment_author_link(); ?></span>
					<span class='comment-author-date-divider'> – </span>
					<span class="comment-date"><span class="date"><?php comment_date(); ?></span></span>
					<span class='comment-date-time-divider'> <?php _ex('at','Comment date and time divider','primeraTextDomain'); ?> </span>
					<span class="comment-time"><span class="time"><?php comment_time(); ?></span></span>
				</div>
				<div class="comment-content">
					<?php
						if( ! boolval($comment->comment_approved) ) {
							echo '<p class="comment-moderation">'.esc_html__('Your comment is awaiting moderation.','primeraTextDomain').'</p>';
						} else {
							comment_text();
						}
					?>
				</div>
				<?php
					if ( $edit_comment_link || $comment_reply_link ) {
						echo '<div class="comment-reply">';
						if ( $edit_comment_link ) echo $edit_comment_link;
						if ( $edit_comment_link && $comment_reply_link ) echo ' / ';
						if ( $comment_reply_link ) echo $comment_reply_link;
						echo '</div>';
					}
				?>
			</div>

		</div>
	<?php // WP will supply the closing tag automatically
}
?>

<div class="comments">
<?php

	if ( have_comments() ) {

		echo '<ol class="comment-list">';
		wp_list_comments( array(
			'type'        => 'all',
			'style'       => 'ol',
			'callback'    => 'primeraFunctionPrefix_comment_layout',
			'short_ping'  => true,
			'avatar_size' => 40,
		) );
		echo '</ol>';

		the_comments_navigation();
	}

	if ( ! comments_open() ) {

		echo '<p class="comments-closed-note">';
		echo esc_html_x( 'Comments are closed.', 'Comments closed note', 'primeraTextDomain' );
		echo '</p>';
	}

	comment_form();

?>
</div>
