<?php
/**
 * Comments Template
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package   gwen
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<span>
				<?php _e( 'Comments', 'gwen' ); ?>
			</span>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'gwen' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'gwen' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'gwen' ) ); ?></div>

				</div>
			</nav>
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( apply_filters( 'gwen/comments/wp-list-comments-args', array(
				'avatar_size' => 60,
				'callback'    => 'gwen_comment_layout',
				'style'       => 'ol',
				'short_ping'  => true,
			) ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'gwen' ); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'gwen' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'gwen' ) ); ?></div>

				</div>
			</nav>
			<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php echo apply_filters( 'gwen/coments/comments-closed-message', esc_html__( 'Comments are closed.', 'gwen' ) ); ?></p>
		<?php
	endif;

	/*
	 * Reply Form
	 */
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	comment_form( apply_filters( 'gwen/comments/comment-form-args', array(
		'fields'               => array(
			'author' =>
				'<p class="comment-form-author"><label for="author">' . __( 'Name', 'gwen' ) .
				( $req ? '<span class="required">*</span>' : '' ) .
				'</label>' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" placeholder="' . esc_attr__( 'Name', 'gwen' ) . '" size="30"' . $aria_req . ' /></p>',

			'email' =>
				'<p class="comment-form-email"><label for="email">' . __( 'Email', 'gwen' ) .
				( $req ? '<span class="required">*</span>' : '' ) .
				'</label>' .
				'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
				'" placeholder="' . esc_attr__( 'Email', 'gwen' ) . '" size="30"' . $aria_req . ' /></p>',

			'url' =>
				'<p class="comment-form-url"><label for="url">' . __( 'Website', 'gwen' ) . '</label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" placeholder="' . esc_attr__( 'URL', 'gwen' ) . '" size="30" /></p>'
		),
		'comment_notes_before' => '',
		'title_reply'          => esc_html__( 'Leave a Comment', 'gwen' ),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title"><span>',
		'title_reply_after'    => '</span></h3>',
		'label_submit'         => __( 'Submit &raquo;', 'gwen' )
	) ) );
	?>

</div>