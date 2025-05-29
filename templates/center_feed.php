<?php

global $gBitDb,$gQueryUser,$gBitSmarty;

require_once( FEED_PKG_INCLUDE_PATH.'feed_lib.php' );

if( !empty($gQueryUser) ){
	if( !empty( $moduleParams['module_params']['no_link_user'] ) ) {
		$listHash['no_link_user'] = TRUE;
	}
	if( !empty( $moduleParams['module_rows'] ) ) {
		$listHash['max_records'] = $moduleParams['module_rows'];
	}

	$listHash['user_id'] = $gQueryUser->mUserId;
	$actions = feed_get_actions( $listHash );
	$gBitSmarty->assign( 'actions', $actions);


}




?>
