<?php
/**
 * Display comments on posts and pages.
 *
 * TrackBacks, PingBacks, Comments and the comment form itself
 * are handled by this file.
 *
 * @package Thesis
 */

// Prevent direct access to this file
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die('Please do not load this page directly. Thanks.');

// Check for password protection
if (post_password_required()) {
	echo '<p>' . __('This post is password protected. Enter the password to view comments.', 'thesis') . "</p>\n";
	return;
}

global $thesis;
?>
			<div id="comments">
<?php
if (have_comments()) { // If there is available feedback of any kind. 
	foreach ($comments as $comment) {
		if ($comment->comment_type == 'trackback' || $comment->comment_type == 'pingback')
			$linkbacks[] = $comment;
		else
			$only_comments[] = $comment;
	}

	if ($linkbacks) {
		thesis_comments_intro(count($linkbacks), pings_open(), 'trackbacks');
?>
				<dl id="trackback_list">
<?php
		foreach ($linkbacks as $comment) {
?>
					<dt><?php comment_author_link(); ?></dt>
					<dd><span><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()); ?></span></dd>
<?php
		}
?>
				</dl>
<?php
	}

	// Display comments (how deep does this rabbit hole go?).
	if ($only_comments) {
		thesis_comments_intro(count($only_comments), comments_open());
?>
<?php thesis_comment_navigation(); ?>
				<dl id="comment_list">
<?php
		thesis_list_comments();
?>
				</dl>
<?php thesis_comment_navigation(2); ?>
<?php
	}
	elseif (comments_open())
		thesis_comments_intro(0, comments_open());
}

if (!comments_open()) {
?>
				<div class="comments_closed">
					<p><?php _e('Comments on this entry are closed.', 'thesis'); ?></p>
				</div>
<?php
}

if (comments_open()) {
	if (get_option('comment_registration') && !$user_ID) { // If registration is required and the user is NOT logged in...
?>
				<div class="login_alert">
					<p><?php printf(__('You must <a href="%s" rel="nofollow">log in</a> to post a comment.', 'thesis'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
				</div>
<?php 
	}
	else { // Otherwise, show the user the stinkin' comment form already!
?>
				<div id="respond">
					<div id="respond_intro">
						<p><?php comment_form_title(__('Leave a Comment', 'thesis'), __('Reply to %s:', 'thesis')); ?></p>
					</div>

					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php
		if (get_option('thread_comments')) {
?>
						<div id="cancel-comment-reply">
							<p><?php cancel_comment_reply_link(__('Cancel reply.', 'thesis')); ?></p>
						</div>

<?php
		}
?>
<?php 
		if ($user_ID) // If the user is logged in...
			echo '						<p>' . sprintf(__('Logged in as <a href="%1$s/wp-admin/profile.php" rel="nofollow">%2$s</a>.', 'thesis'), get_option('siteurl'), $user_identity) . ' ' . sprintf(__('<a href="%s" title="Log out of this account" rel="nofollow">Logout &rarr;</a>', 'thesis'), thesis_logout_url()) . '</p>' . "\n";
		else { // Otherwise, give your name to the doorman
?>
						<p><input class="text_input" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1"<?php if ($req) echo ' aria-required="true"'; ?> /><label for="author"><?php _e('Name', 'thesis'); if ($req) _e(' <span class="required" title="Required">*</span>', 'thesis'); ?></label></p>
						<p><input class="text_input" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2"<?php if ($req) echo ' aria-required="true"'; ?> /><label for="email"><?php _e('E-mail', 'thesis'); if ($req) _e(' <span class="required" title="Required">*</span>', 'thesis'); ?></label></p>
						<p><input class="text_input" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /><label for="url"><?php _e('Website', 'thesis'); ?></label></p>
<?php 
		}

		thesis_hook_comment_field();
?>
						<p class="comment_box">
							<textarea name="comment" id="comment" tabindex="4" cols="40" rows="8"></textarea>
<?php
						if ($thesis['display']['comments']['allowed_tags']) {
							echo '<span class="allowed"><span>' . "\n";
							echo '<em>' . __('You can use these <acronym title="HyperText Markup Language">HTML</acronym> tags and attributes:', 'thesis') . '</em> ';
							echo allowed_tags() . "\n";
							echo '</span></span>' . "\n";
						}
?>
						</p>
<ul style="list-style-type:none" ><li class="rss"><?php post_comments_feed_link( 'Subscribe to comments via RSS') ?> </li></ul><br />

						<?php thesis_hook_comment_form(); ?>
						<p>
							<input name="submit" class="form_submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit', 'thesis'); ?>" />
							<?php comment_id_fields(); ?>
						</p>
						<?php do_action('comment_form', $post->ID); ?>

					</form>
				</div>

<?php 
	}	
}
?>


			</div>