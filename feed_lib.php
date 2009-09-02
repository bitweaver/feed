<?php

function feed_get_actions( $pListHash ) {
	global $gBitDb;

	$query = "SELECT lal.content_id, lal.user_id, MAX(lal.last_modified) AS last_modified, uu.login, uu.real_name, uu.email 
			  FROM liberty_action_log lal
				INNER JOIN liberty_content lc ON (lc.content_id=lal.content_id)
				INNER JOIN users_users uu ON (uu.user_id=lal.user_id)
			  WHERE lal.user_id = ? 
			  GROUP BY lal.content_id, lal.user_id, uu.login, uu.real_name, uu.email
			  ORDER BY lal.last_modified DESC LIMIT 10";
	$actions = $gBitDb->getAll( $query, array( $pListHash['user_id'] ) );

	$conjugationQuery = "SELECT * FROM feed_conjugation";
	$overrides = $gBitDb->getAssoc( $conjugationQuery );
	foreach( array_keys( $actions ) as $k ) {
		if( $content = LibertyContent::getLibertyObject($actions[$k]['content_id']) ) {
			$contentType = $content->getContentType();
			$actions[$k]['real_log'] .= BitUser::getDisplayName( empty( $pParams['nolink'] ), $actions[$k] ).' ';
			if(!empty($overrides[strtolower($contentType)])){
				$actions[$k]['real_log'] .= $overrides[$contentType]['conjugation_phrase'];
				if($overrides[$contentType]['is_target_linked'] == 'y'){
					$actions[$k]['real_log'] .= ' <a href="'.$content->getDisplayUrl().'">'.$content->getTitle().'</a>';
				}
				if( !empty( $overrides[$contentType]['feed_icon_url'] ) ) {
					 $actions[$k]['feed_icon_url'] = $overrides[$contentType]['feed_icon_url'];
				}
			}else{
				$actions[$k]['real_log'] .= tra( 'edited' ).' <a href="'.$content->getDisplayUrl().'">'.$content->getTitle().'</a>';
			}			
			if( empty( $actions[$k]['feed_icon_url'] ) ) {
				 $actions[$k]['feed_icon_url'] = FEED_PKG_URL.'icons/pixelmixerbasic/pencil_16.png';
			}
		} else {
			unset( $actions[$k] );
		}
	}

	return $actions;
}


?>
