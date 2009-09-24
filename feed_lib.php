<?php

function feed_get_actions( $pListHash ) {
	global $gBitDb;

	$whereSql = '';
	$bindVars = array();

	BitBase::prepGetList( $pListHash );
	if( !empty( $pListHash['user_id'] ) ) {
		$whereSql = " WHERE lal.user_id = ? ";
		$bindVars[] = $pListHash['user_id'];
	}else{
		$whereSql = "WHERE 1=1 ";
	}

	$query = "SELECT lal.content_id, lal.user_id, lal.log_message, MAX(lal.last_modified) AS last_modified, uu.login, uu.real_name, uu.email 
			  FROM liberty_action_log lal
			  INNER JOIN liberty_content lc ON (lc.content_id=lal.content_id)
			  INNER JOIN users_users uu ON (uu.user_id=lal.user_id)
			  $whereSql AND lc.content_type_guid != 'feedstatus'
			  GROUP BY lal.content_id, lal.user_id, uu.login, uu.real_name, uu.email, lal.log_message
			  ORDER BY MAX(lal.last_modified) DESC";

	$res = $gBitDb->query( $query, $bindVars, $pListHash['max_records'] );
	$conjugationQuery = "SELECT * FROM feed_conjugation";
	$overrides = $gBitDb->getAssoc( $conjugationQuery );

	$actions = array();
	
	//loop through directed actions
	while ( $action = $res->fetchRow() ){
		if( !empty($action['content_id']) ) { //indicates that this isn't a direct action, more of a "status update" ex. "Ronald is pleased with his artwork"
			if( $content = LibertyContent::getLibertyObject($action['content_id']) ) {
				$contentType = $content->getContentType();
				$action['real_log'] = BitUser::getDisplayName( empty( $pListHash['no_link_user'] ), $action ).' ';
				if(!empty($overrides[strtolower($contentType)])){
					$action['real_log'] .= $overrides[$contentType]['conjugation_phrase'];
					if($overrides[$contentType]['is_target_linked'] == 'y'){
						$action['real_log'] .= ' <a href="'.$content->getDisplayUrl().'">'.$content->getTitle().'</a>';
					}
					if( !empty( $overrides[$contentType]['feed_icon_url'] ) ) {
						 $action['feed_icon_url'] = $overrides[$contentType]['feed_icon_url'];
					}
				}else{
					$action['real_log'] .= tra( 'edited' ).' <a href="'.$content->getDisplayUrl().'">'.$content->getTitle().'</a>';
				}			
			} else {
				unset( $action ); //invalid content_id
			}

		if( empty( $action['feed_icon_url'] ) ) {
			 $action['feed_icon_url'] = FEED_PKG_URL.'icons/pixelmixerbasic/pencil_16.png';
		}

		$actions[] = $action;
		}
	}

	return $actions;
}

function feed_get_status( $pListHash ){

	global $gBitDb;

	$whereSql = '';
	$bindVars = array();
	$statuses = array();

	BitBase::prepGetList( $pListHash );
	if( !empty( $pListHash['user_id'] ) ) {
		$whereSql = " WHERE lal.user_id = ? ";
		$bindVars[] = $pListHash['user_id'];
	}else{
		$whereSql = "WHERE 1=1 ";
	}

	$query = "SELECT lal.content_id, lal.user_id, lal.log_message, MAX(lal.last_modified) AS last_modified, lc.data, uu.login, uu.real_name, uu.email 
			  FROM liberty_action_log lal
			  INNER JOIN liberty_content lc ON (lc.content_id=lal.content_id)
			  INNER JOIN liberty_comments lcs ON (lcs.content_id = lc.content_id)
			  INNER JOIN users_users uu ON (uu.user_id=lal.user_id)
			  $whereSql AND lc.content_type_guid = 'feedstatus'
			  GROUP BY lal.content_id, lal.user_id, uu.login, uu.real_name, uu.email, lal.log_message,lc.data
			  ORDER BY MAX(lal.last_modified) DESC";

	$res = $gBitDb->query( $query, $bindVars, $pListHash['max_records'] );

	$user = new BitUser($pListHash['user_id']);	
	$user->load();
	
	
	while ( $status = $res->fetchRow() ){
		$avatarUrl = $user->getThumbnailUrl();
		if(empty($avatarUrl)){
			$avatarUrl = USERS_PKG_URI."icons/silhouette.png";
		}
		
		$status['feed_icon_url'] = $avatarUrl;
		
		$comment = new LibertyComment(NULL,$status['content_id']);
		$replies = $comment->getComments($status['content_id'],null,null,'commentDate_asc');
		$status['replies'] = $replies;
		
		foreach ( $status['replies'] as &$reply ){
			$replyUser = new BitUser($reply['user_id']);
			$replyUser->load();
			$replyAvatarUrl = $replyUser->getThumbnailUrl();
			if(empty($replyAvatarUrl)){
				$replyAvatarUrl = USERS_PKG_URI."users/icons/silhouette.png";
			}
			$reply['feed_icon_url'] = $replyAvatarUrl;

		}

		$statuses[] = $status;	
	}

	return $statuses;
}

function feed_get_status_and_actions( $pParamHash ) {


}

function feed_set_status( $pParamHash ){

	global $gBitDb;
	
	require_once ('FeedStatus.php');
	
	$status = new FeedStatus();

	global $gBitUser;

	$pParamHash['root_id'] = $gBitUser->mContentId;
	$pParamHash['parent_id'] = $gBitUser->mContentId;

	$pParamHash['comment_data'] = $pParamHash['status_message'];
	$pParamHash['title'] = substr($pParamHash['status_message'],0,20);

	$status->storeComment($pParamHash);

}


?>
