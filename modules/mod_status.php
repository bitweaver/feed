<?php

global $gQueryUser,$gBitSmarty;

require_once( FEED_PKG_PATH.'feed_lib.php' );

if( !empty( $_REQUEST['feed_status'] ) ){
	
	$pParamHash['status_message'] = $_REQUEST['feed_status'];
	feed_set_status($pParamHash);		
}

if( !empty( $moduleParams['module_params']['no_link_user'] ) ) {
	$listHash['no_link_user'] = TRUE;
}
if( !empty( $moduleParams['module_rows'] ) ) {
	$listHash['max_records'] = $moduleParams['module_rows'];
}elseif (!empty($moduleParams['module_params']['max_records'])){
	$listHash['max_records'] = $moduleParams['module_params']['max_records'];
}

if( !empty( $moduleParams['module_params']['user_id'] ) ){
	$listHash['user_id'] = $moduleParams['module_params']['user_id'];
}else{
	$listHash['user_id'] = $gQueryUser->mUserId;
}

$statuses = feed_get_status( $listHash );
$gBitSmarty->assign( 'statuses', $statuses);

foreach ($statuses as $status){

	$commentContentId = 'comment_'.$status['content_id'];
	if(!empty($_REQUEST[$commentContentId])){
		//then there is a reply to this comment and break, we only handle one at a time
		$reply = new LibertyComment();

		$pParamHash['root_id'] =   $status['content_id'];
		$pParamHash['parent_id'] = $status['content_id'];

		$pParamHash['comment_data'] = $_REQUEST[$commentContentId];
		$pParamHash['title'] = substr($_REQUEST[$commentContentId],0,20);

		$reply->storeComment($pParamHash);
		
		$statuses = feed_get_status( $listHash );

		$gBitSmarty->assign( 'statuses', $statuses);
		break;
	}
}

?>

