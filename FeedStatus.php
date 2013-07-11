<?php
/**
 * @version $Header$
 *
 * FeedStatus class
 *
 * @version  $Revision$
 * @package  feed
 */

/**
 * required setup
 */
require_once( LIBERTY_PKG_PATH.'LibertyComment.php' );
require_once( USERS_PKG_PATH.'BitUser.php');

define( 'FEEDSTATUS_CONTENT_TYPE_GUID','feedstatus');


/**
 * FeedStatus
 * @package  feed
 */
class FeedStatus extends LibertyComment {

	/**
	* During initialisation, be sure to call our base constructors
	**/
	function FeedStatus($pCommentId = NULL, $pContentId = NULL, $pInfo = NULL) {
		
		LibertyComment::LibertyComment($pCommentId,$pContentId,$pInfo);
	
/*		// Permission setup
		$this->mViewContentPerm  = 'p_boards_read';
		$this->mUpdateContentPerm  = 'p_boards_post_update';
		$this->mAdminContentPerm = 'p_boards_admin';
*/
		
		$this->mContentTypeGuid = FEEDSTATUS_CONTENT_TYPE_GUID;
		$this->registerContentType( FEEDSTATUS_CONTENT_TYPE_GUID, array(
				'content_type_guid' => FEEDSTATUS_CONTENT_TYPE_GUID,
				'content_name' => 'Feed Status',
				'handler_class' => 'FeedStatus',
				'handler_package' => 'feed',
				'handler_file' => 'FeedStatus.php',
				'maintainer_url' => 'http://www.bitweaver.org'
			) );
/*
		$this->mViewContentPerm  = 'p_loc_view';
		$this->mCreateContentPerm  = 'p_loc_edit';
		$this->mUpdateContentPerm  = 'p_loc_edit';
		$this->mAdminContentPerm = 'p_loc_admin';
*/
	}
	
	function getThumbnailUrl($pSize = 'avatar', $pInfoHash = NULL){
		$rootUser = new BitUser(NULL,$this->mInfo['root_id']);
		$rootUser->load();
		$thumbnailUrl = $rootUser->getThumbnailUrl( $pSize );
		if( empty ($thumbnailUrl) ){
			$thumbnailUrl = USERS_PKG_URL.'icons/silhouette.png';
		}
		return $thumbnailUrl;
	}

}
?>
