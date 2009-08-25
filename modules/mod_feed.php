<?php

global $gBitDb,$gQueryUser,$gBitSmarty;

$selectSql = "SELECT user_id, content_id, log_message,last_modified FROM liberty_action_log WHERE user_id = ? ORDER BY last_modified DESC LIMIT 10";
$selectSql2 = "SELECT * FROM feed_conjugation";


if( !empty($gQueryUser) ){

	$actions = $gBitDb->getAll( $selectSql, array( $gQueryUser->mUserId ) );
	$overrides = $gBitDb->getAssoc($selectSql2);
	foreach( $actions as &$action ){
		
		$content = LibertyContent::getLibertyObject($action['content_id']);
		if( !empty($content) ){
			
			$contentType = get_class($content);
		
			$action['real_log'] = '<a href="'.$gQueryUser->getDisplayUrl().'">'.$gQueryUser->mInfo['real_name'].'</a> ';
			$action['real_log'].= strtolower($action['log_message']).' '; //This is the name of the core action that occured. Currently only "created or updated", which is weak
			if(!empty($overrides[strtolower($contentType)])){
				$action['real_log'] .= $overrides[strtolower($contentType)]['conjugation_phrase'];
				if($overrides[strtolower($contentType)]['is_target_linked'] == 't'){
					$action['real_log'] .= ' <a href="'.$content->getDisplayUrl().'">'.$content->getTitle().'</a>';
				}
			}else{
				$action['real_log'] .= ' <a href="'.$content->getDisplayUrl().'">'.$content->getTitle().'</a>';
			}			
		}
	}

	$gBitSmarty->assign( 'actions', $actions);


}




?>
