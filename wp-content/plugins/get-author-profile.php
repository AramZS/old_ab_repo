<?php
/*
Plugin Name: Get Author Profile
Plugin URI: http://guff.szub.net/get-author-profile
Description: Assigns specified author profile information to global variables for use in your blog.
Version: 0.5.1
Author: Kaf Oseo
Author URI: http://szub.net

	Copyright (c) 2004, 2005, 2006 Kaf Oseo (http://szub.net)
	Get Author Profile is released under the GNU General Public
	License (GPL) http://www.gnu.org/licenses/gpl.txt

	This is a WordPress plugin (http://wordpress.org).

~Changelog:
0.5.1 (Jan-12-2006)
Bug fix to get_author_profile() for author query call.

0.5 (Jan-08-2006)
WordPress 2.0 fixes. Added three new variables:

	$author_jabber (author_profile('jabber'))
	$author_nicename (author_profile('nicename'))
	$author_displayname (author_profile('displayname'))

$author_displayname is the name format users select under "How
to display name" on the Users control panel.

0.4 (Jul-11-2005)
Added 'display' parameter to author_profile(). If set to FALSE,
will only return the value, and not display it.

0.3 (Jul-09-2005)
Code changes for WordPress 1.5. If used without specifying user
ID in "author.php" template, will profile the 'current' author.

0.2 (Dec-13-2004)
Added two new variables from outside WordPress' user profile set
(but still considered part of it):

 * $author_posts (number of posts for author)
 * $author_posts_link (link to all author's posts)

There's also a new function: author_profile(). This merely echos
the values of the variables--for anyone who prefers doing things
the WordPress way.
*/

function get_author_profile($auth_id='') {
	global $wp_query, $wp_version;
	global $author_aim, $author_email, $author_firstname, $author_icq, $author_jabber, $author_lastname, $author_level, $author_login, $author_msn, $author_nickname, $author_posts, $author_posts_link, $author_profile, $author_url, $author_yim, $author_nicename, $author_displayname;

	if(!$auth_id && is_author()) {
		$author = $wp_query->get_queried_object();
		$auth_id = $author->ID;
	}

	$auth_id = (int) $auth_id;
	$profile = get_authordata($auth_id);

	$author_email = $profile->user_email;
	$author_login = $profile->user_login;
	$author_nicename = $profile->user_nicename;
	$author_url = $profile->user_url;
	$author_posts = get_usernumposts($auth_id);
	$author_posts_link = get_author_link(0, $auth_id, $author_nicename);

	if($wp_version < 2) {
		$author_aim = $profile->user_aim;
		$author_displayname = get_displayname($profile->user_idmode, $profile);
		$author_firstname = $profile->user_firstname;
		$author_icq = $profile->user_icq;
		$author_lastname = $profile->user_lastname;
		$author_level = $profile->user_level;
		$author_msn = $profile->user_msn;
		$author_nickname = $profile->user_nickname;
		$author_profile = $profile->user_description;
		$author_yim = $profile->user_yim;
	} else {
		$author_aim = $profile->aim;
		$author_displayname = $profile->display_name;
		$author_firstname = $profile->first_name;
		$author_icq = $profile->icq;
		$author_jabber = $profile->jabber;
		$author_lastname = $profile->last_name;
		$author_level = $profile->user_level;
		$author_msn = $profile->msn;
		$author_nickname = $profile->nickname;
		$author_profile = $profile->description;
		$author_yim = $profile->yim;
	}
}

function author_profile($info='nickname', $display=true) {
	global $author_aim, $author_email, $author_firstname, $author_icq, $author_jabber, $author_lastname, $author_level, $author_login, $author_msn, $author_nickname, $author_posts, $author_posts_link, $author_profile, $author_url, $author_yim, $author_nicename, $author_displayname;

	switch ($info) {
		case 'aim':
			$text = $author_aim;
			break;
		case 'displayname':
			$text = $author_displayname;
			break;
		case 'email':
			$text = $author_email;
			break;
		case 'firstname':
			$text = $author_firstname;
			break;
		case 'icq':
			$text = $author_icq;
			break;
		case 'jabber':
			$text = $author_jabber;
			break;
		case 'lastname':
			$text = $author_lastname;
			break;
		case 'level':
			$text = $author_level;
			break;
		case 'login':
			$text = $author_login;
			break;
		case 'msn':
			$text = $author_msn;
			break;
		case 'nicename':
			$text = $author_nicename;
			break;
		case 'posts':
			$text = $author_posts;
			break;
		case 'posts_link':
			$text = $author_posts_link;
			break;
		case 'profile':
			$text = $author_profile;
			break;
		case 'url':
			$text = $author_url;
			break;
		case 'yim':
			$text = $author_yim;
			break;
		default:
			$text = $author_nickname;
	}

	if($display)
		echo $text;

	return $text;
}

function get_displayname($idmode, $authordata) { // 1.5.x support of $author_displayname
	switch($idmode) {
		case 'nickname':
			$id = $authordata->user_nickname;
		case 'login':
			$id = $authordata->user_login;
		case 'firstname':
			$id = $authordata->user_firstname;
		case 'lastname':
			$id = $authordata->user_lastname;
		case 'namefl':
			$id = $authordata->user_firstname.' '.$authordata->user_lastname;
		case 'namelf':
			$id = $authordata->user_lastname.' '.$authordata->user_firstname;
		default:
			$id = $authordata->user_nickname;
	}

    return $id;
}

function get_authordata($id) {
	global $wpdb;
	$id = (int) $id;
	if (!$id)
		return false;

	$author = @$wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = '$id' LIMIT 1");

	$wpdb->hide_errors();
	$metavalues = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id = '$id'");
	$wpdb->show_errors();

	if ($metavalues) {
		foreach ($metavalues as $meta) {
			@ $value = unserialize($meta->meta_value);
			if ($value === FALSE)
				$value = $meta->meta_value;
			$author->{$meta->meta_key} = $value;

			if ( $wpdb->prefix . 'user_level' == $meta->meta_key )
				$author->user_level = $meta->meta_value;
		}
	}
	return $author;
}
?>