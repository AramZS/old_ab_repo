<?php
/*
RS FeedBurner - uninstall.php
Version: 1.5.1

This script uninstalls RS FeedBurner and removes all options and traces of its existence.
*/

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) { exit(); }

function rsfb_uninstall_plugin() {
	/* Delete Options */
	$rsfb_option_names = array( 'rs_feedburner_version', 'rs_feedburner_settings', 'rs_feedburner_token', 'rsfb_admin_notices' );
	foreach( $rsfb_option_names as $i => $rsfb_option ) { delete_option( $rsfb_option ); }
	/* Delete User Meta */
	$del_user_meta = array( 'rsfb_nag_status', 'rsfb_nag_notices' );
	$user_ids = get_users( array( 'blog_id' => '', 'fields' => 'ID' ) );
	foreach ( $user_ids as $user_id ) { foreach( $del_user_meta as $i => $key ) { delete_user_meta( $user_id, $key ); } }
	}

rsfb_uninstall_plugin();

?>