<?php

global $gQueryUser,$gBitSmarty;

require_once( FEED_PKG_PATH.'feed_lib.php' );


if( !empty($gQueryUser) ){

	if( !empty( $moduleParams['module_params']['no_link_user'] ) ) {
		$listHash['no_link_user'] = TRUE;
	}
	if( !empty( $moduleParams['module_rows'] ) ) {
		$listHash['max_records'] = $moduleParams['module_rows'];
	}
	if( !empty( $moduleParams['module_params']['user_id'] ) ){
		$listHash['user_id'] = $moduleParams['module_params']['user_id'];
	}else{
		$listHash['user_id'] = $gQueryUser->mUserId;
	}

	$actions = feed_get_actions( $listHash );

	$_template->tpl_vars['actions'] = new Smarty_variable( $actions);
		
	
}




?>
