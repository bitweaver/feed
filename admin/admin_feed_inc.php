<?php

global $gBitSmarty;


$contentTypes = get_content_types();

if( !empty( $_REQUEST['store_feed'] ) ) {

	$deleteSql = "DELETE FROM feed_conjugation";
	$gBitDb->query($deleteSql);

	foreach ( array_keys( $contentTypes ) as $type ){
		if( !empty( $_REQUEST[$type]['conjugation_phrase'] ) || !empty( $_REQUEST[$type]['is_target_linked'] ) ) {
			$insertSql = "INSERT INTO feed_conjugation (content_type_guid, conjugation_phrase, is_target_linked) VALUES ( ?, ?, ?)";
			$gBitDb->query($insertSql, array( $type, $_REQUEST[$type]['conjugation_phrase'], empty($_REQUEST[$type]['is_target_linked'])?'y' : NULL ) );	
		}
	}

}

$contentTypes = get_content_types();
$gBitSmarty->assignByRef('contentTypes',$contentTypes);



function get_content_types(){
	global $gBitDb;
	$selectSql = "SELECT lct.content_type_guid,conjugation_phrase, is_target_linked FROM liberty_content_types lct LEFT JOIN feed_conjugation fc ON (fc.content_type_guid = lct.content_type_guid)";
	$contentTypes = $gBitDb->getAssoc($selectSql);
	return $contentTypes;

}

?>
