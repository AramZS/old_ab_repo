<?php
/*
Plugin Name: AJAX Comment Preview
Plugin URI: http://blogwaffe.com/ajax-comment-preview/
Description:  Click Button Coment Preview which filters content through WordPress filters.
Version: 2.4
Author: Michael D Adams
Author URI: http://blogwaffe.com/
*/

/*
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

Inspired in part by Bitflux GmbH via Jeff Minard.
*/

// TODO: New themes use wp_list_comments.  Try to tap into those callbacks.

if ( !defined( 'ABSPATH' ) ) exit;

class Ajax_Comment_Preview {
	function version() { return '2.4'; }

	function init() {
		add_option( 'ajax_comment_preview', array(
			'template' => <<<EOM
<br />
<ul class="commentlist">
	<li class="comment even thread-even depth-1" id="comment-preview">
		<div id="div-comment-preview">
			<div class="comment-author vcard">
				%avatar:40%
				<cite class="fn">%author%</cite> <span class="says">says:</span>
			</div>
			<div class="comment-meta commentmetadata">
				<a href="#comment-preview">%date%</a>
			</div>
			<div class="comment-body">
				%content%
			</div>
		</div>
	<br />
	</li>
</ul>
EOM
,
			'date_format' => __( 'F j, Y \a\t g:i a' ),
			'empty_string' => __( 'Click the "Preview" button to preview your comment here.' ),
			'button_value' => __( 'Preview' )
		));
	}

	function wp_print_scripts() {
		if ( !is_singular() || !comments_open() )
			return;
		$preview_vars = get_option( 'ajax_comment_preview' );
		wp_enqueue_script( 'ajax_comment_preview', plugins_url( 'ajax-comment-preview.js', __FILE__ ), array( 'jquery' ), Ajax_Comment_Preview::version() );
		wp_localize_script( 'ajax_comment_preview', 'AJAXCommentPreview', array(
			'loading' => ent2ncr( __( 'Loading&hellip;' ) ),
			'error' => ent2ncr( __( 'Preview error' ) ),
			'emptyString' => ent2ncr( $preview_vars['empty_string'] ),
			'url' => admin_url( 'admin-ajax.php?action=ajax_comment_preview' ),
		) );
	}

	function comment_form() {
		Ajax_Comment_Preview::preview_button();
		Ajax_Comment_Preview::preview_div();
        }

	// TODO - should probabl inject with JS
	function comment_id_fields( $html ) {
		return "$html\n" . self::get_preview_button();
	}

	function get_preview_button() {
		static $already = false;
		if ( $already )
			return;
		$already = true;

		$preview_vars = get_option( 'ajax_comment_preview' );
		return '<input name="acp-preview" type="button" id="acp-preview" tabindex="6" value="' . esc_attr( $preview_vars['button_value'] ) . '" />';
	}

	function preview_button() {
		echo self::get_preview_button();
	}

	function preview_div() {
		static $already = false;
		if ( $already )
			return;
		$already = true;

		echo '<div id="ajax-comment-preview"></div>';
	}

	function send() {
		global $user_ID, $user_url, $user_identity, $user_email;
		$author	= isset( $_POST['author'] ) ? trim($_POST['author']) : NULL;
		if ( !$author )
			$author = 'Anonymous';
		$url	 = isset( $_POST['url'] ) ? trim($_POST['url']) : '';
		$text	 = isset( $_POST['comment'] ) ? trim($_POST['comment']) : '';
		$email = isset( $_POST['email'] ) ? trim($_POST['email']) : '';

		get_currentuserinfo();
		if ( $user_ID ) :
			$author	= addslashes($user_identity);
			$url	= addslashes($user_url);
			$email  = addslashes($user_email);
		endif;

		$text = apply_filters('pre_comment_content', $text);
		$text = apply_filters('post_comment_text', $text); // Deprecated
		$text = apply_filters('comment_content_presave', $text); // Deprecated
		$text = stripslashes($text);
		$text = apply_filters('get_comment_text', $text);
		$text = apply_filters('comment_text', $text);

		$author = apply_filters('pre_comment_author_name', $author);
		$author = stripslashes($author);
		$author = apply_filters('get_comment_author', $author);

		$email = apply_filters('pre_comment_author_email', $email);
		$email = stripslashes($email);
		$email = apply_filters('get_comment_author_email', $email);

		if ( $url && 'http://' !== $url ) :
			$url = apply_filters('pre_comment_author_url', $url);
			$url = stripslashes($url);
			$url = apply_filters('get_comment_url', $url);
			$author = '<a href="' . $url . '" rel="external">' . $author . '</a>';
			$author = apply_filters('get_comment_author_link', $author);
			$author = apply_filters('comment_author_link', $author);
		endif;
		$preview_vars = get_option( 'ajax_comment_preview' );
		$preview_vars['template'] = str_replace(
			array('%author%', '%date%', '%content%', '%email%'),
			array($author, date_i18n($preview_vars['date_format'], time() + get_option('gmt_offset') * 3600 - date('Z')), $text, $email),
			$preview_vars['template']
		);
		if ( false !== strpos( $preview_vars['template'], '%avatar' ) ) {
			if ( function_exists( 'get_avatar' ) && preg_match( '/%(avatar[^%]*)%/i', $preview_vars['template'], $matches ) ) {
				$avatar_args = split( ':', $matches[1] );
				$avatar_args[0] = $user_ID ? $user_ID : $email;
				$preview_vars['template'] = str_replace( $matches[0], call_user_func_array( 'get_avatar', $avatar_args ), $preview_vars['template'] );
			}
		}

		if ( false !== strpos($preview_vars['template'], '%email_hash%') )
			$preview_vars['template'] = str_replace('%email_hash%', md5($email), $preview_vars['template']);

		// If the site is serving XML (application/xhtml+xml, for example), we need to make sure we don't have any untoward HTML entities
		return ent2ncr( trim( $preview_vars['template'] ) );
	}

	function admin_menu() {
		$hook = add_options_page( 'AJAX Comment Preview', 'AJAX Comment Preview', 'manage_options', 'acp-admin', array( 'Ajax_Comment_Preview', 'admin_page' ) );
		add_action( "load-$hook", array( 'Ajax_Comment_Preview', 'admin_page_load' ) );

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( 'Ajax_Comment_Preview', 'plugin_action_links' ) );
	}
	
	function plugin_action_links( $links ) {
		array_unshift( $links, '<a href="options-general.php?page=acp-admin">' . __( 'Settings' ) . "</a>" );
		return $links;
	}

	function admin_page_load() {
		add_action( 'admin_head', array( 'Ajax_Comment_Preview', 'admin_page_css' ) );

		if ( 'post' != strtolower( $_SERVER['REQUEST_METHOD'] ) || !isset( $_POST['ajax_comment_preview_options_submit'] ) || empty( $_POST['ajax_comment_preview_options_submit'] ) )
			return;

		check_admin_referer( 'ajax_comment_preview' );

		$ajax_comment_preview_options = stripslashes_deep( $_POST['acp'] );
		$ajax_comment_preview_options = array_map( 'convert_chars', $ajax_comment_preview_options );
		if ( !$ajax_comment_preview_options['button_value'] )
			$ajax_comment_preview_options['button_value'] = __( 'Preview' );

		update_option( 'ajax_comment_preview', $ajax_comment_preview_options );
		wp_safe_redirect( add_query_arg( 'updated', 'true' ) );
		exit;
	}

	function admin_page_css() {
?>

<style type="text/css">
.acp-focusable:focus {background-color: #ffe}
dl { margin-left: 3em }
</style>

<?php
	}

	function admin_page() {
		extract( get_option( 'ajax_comment_preview' ) );
?>

<div class="wrap">
<h2>Ajax Comment Preview Options</h2>
<form method="post">
<fieldset>
	<div>
		<p>Enter the markup from your theme's comment template here.  The following special tags are available.</p>
		<dl>
			<dt>%author%</dt>
			<dd>The name of the comment author linked to the comment author's url.</dd>
			<dt>%date%</dt>
			<dd>The date formatted as <a><label for="date-format">below</label></a>.</dd>
			<dt>%content%</dt>
			<dd>The text of the comment.</dd>
			<dt>%email%</dt>
			<dd>The email of the comment author.</dd>
			<dt>%email_hash%</dt>
			<dd>The MD5 hash of the comment author's email address.  Useful for gravatars.</dd>
			<dt>%avatar[:size[:default[:alt]]]%</dt>
			<dd>Call to <code>get_avatar()</code> function.</dd>
		</dl>

		<h3>Comment Template</h3>

		<textarea name="acp[template]" class="acp-focusable widefat" rows="10"><?php echo esc_textarea( $template ); ?></textarea>

		<p>
			<label for="date-format"><a href="http://codex.wordpress.org/Formatting_Date_and_Time">Date format</a> of the date to be displayed in the preview.<br />
			<input name="acp[date_format]" id="date-format" class="acp-focusable" type="text" value="<?php echo esc_attr( $date_format ); ?>" /></label>
		</p>

		<p>
			<label for="button-value">Text to appear on the Preview Button.<br />
			<input name="acp[button_value]" id="button-value" class="acp-focusable" type="text" value="<?php echo esc_attr( $button_value ); ?>" /></label>
		</p>

		<p>
			<label for="empty-string">This text will appear in the preview area before the user previews the comment.  Leave blank to make the preview area initially invisible.<br />
			<input name="acp[empty_string]" id="empty-string" type="text" class="acp-focusable widefat" value="<?php echo esc_attr( $empty_string ); ?>" /></label>
		</p>
	</div>
</fieldset>
<p class="submit">
	<input type="submit" name="ajax_comment_preview_options_submit" value="Update Options &#187;" />
	<?php wp_nonce_field( 'ajax_comment_preview' ); ?>
</p>
</form>
</div>

<?php
	} // admin_page()

	function ajax_response() {
		@header('Content-Type: application/xml; charset=utf-8'); // charset must be UTF-8 for AJAX response
		echo "<?xml version='1.0' encoding='utf-8' ?>\n";
		echo '<acp xmlns="http://www.w3.org/1999/xhtml"><![CDATA['; // We can't be sure the comment template is valid XML
		echo self::send();
		echo ']]></acp>';
		exit;
	}
} // Ajax_Comment_Preview

add_action( 'init', array( 'Ajax_Comment_Preview', 'init' ) );
add_action( 'admin_menu', array( 'Ajax_Comment_Preview', 'admin_menu' ) );
add_action( 'wp_print_scripts', array( 'Ajax_Comment_Preview', 'wp_print_scripts' ) );
add_action( 'comment_form', array( 'Ajax_Comment_Preview', 'comment_form' ) );
add_action( 'comment_id_fields', array( 'Ajax_Comment_Preview', 'comment_id_fields' ) );
add_action( 'wp_ajax_ajax_comment_preview', array( 'Ajax_Comment_Preview', 'ajax_response' ) );
add_action( 'wp_ajax_nopriv_ajax_comment_preview', array( 'Ajax_Comment_Preview', 'ajax_response' ) );
