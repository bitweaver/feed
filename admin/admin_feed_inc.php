<?php

global $gBitSmarty;


$contentTypes = get_content_types();

$deleteSql = "DELETE FROM feed_conjugation";
$gBitDb->query($deleteSql);

foreach ( $contentTypes as $type ){
			$insertSql = "INSERT INTO feed_conjugation (content_type_guid, conjugation_phrase, is_target_linked) VALUES ( ?, ?, ?)";
		 	$gBitDb->query($insertSql, array( $type['content_type_guid'], $_REQUEST[$type['content_type_guid']], empty($_REQUEST[$type['content_type_guid'].'_target'])?'t':'f' ) );	
		}

$contentTypes = get_content_types();
$gBitSmarty->assign_by_ref('contentTypes',$contentTypes);





function get_content_types(){
	global $gBitDb;
	$selectSql = "SELECT lct.content_type_guid,conjugation_phrase, is_target_linked FROM liberty_content_types lct LEFT JOIN feed_conjugation fc ON (fc.content_type_guid = lct.content_type_guid)";
	$contentTypes = $gBitDb->getAll($selectSql);
	return $contentTypes;

}

?>
