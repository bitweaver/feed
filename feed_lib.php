<?php

function feed_get_actions( $pListHash ) {
	global $gBitDb;

	$whereSql = '';
	$bindVars = array();

	BitBase::prepGetList( $pListHash );
	if( !empty( $pListHash['user_id'] ) ) {
		$whereSql = " WHERE lal.user_id = ? ";
		$bindVars[] = $pListHash['user_id'];
	}

	$query = "SELECT lal.content_id, lal.user_id, MAX(lal.last_modified) AS last_modified, uu.login, uu.real_name, uu.email 
			  FROM liberty_action_log lal
				INNER JOIN liberty_content lc ON (lc.content_id=lal.content_id)
				INNER JOIN users_users uu ON (uu.user_id=lal.user_id)
			  $whereSql
			  GROUP BY lal.content_id, lal.user_id, uu.login, uu.real_name, uu.email
			  ORDER BY MAX(lal.last_modified) DESC";

	$res = $gBitDb->query( $query, $bindVars, $pListHash['max_records'] );
	$conjugationQuery = "SELECT * FROM feed_conjugation";
	$overrides = $gBitDb->getAssoc( $conjugationQuery );

	$actions = array();

	while ( $action = $res->fetchRow() ){
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
			if( empty( $action['feed_icon_url'] ) ) {
				 $action['feed_icon_url'] = FEED_PKG_URL.'icons/pixelmixerbasic/pencil_16.png';
			}
			$actions[] = $action;
		} else {
			unset( $action );
		}
	}
	return $actions;
}


?>
