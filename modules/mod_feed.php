<?php

global $gQueryUser,$gBitSmarty;

require_once( FEED_PKG_PATH.'feed_lib.php' );

if( !empty($gQueryUser) ){

	$listHash['user_id'] = $gQueryUser->mUserId;
	$actions = feed_get_actions( $listHash );

	$gBitSmarty->assign( 'actions', $actions);


}




?>
