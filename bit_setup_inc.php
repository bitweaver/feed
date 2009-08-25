<?php
global $gBitSystem, $gBitUser, $gBitThemes;

$registerHash = array(
	'package_name' => 'feed',
	'package_path' => dirname( __FILE__ ).'/',
//	'service' => LIBERTY_SERVICE_FEED,
);

$gBitSystem->registerPackage( $registerHash );


if( $gBitSystem->isPackageActive( 'feed' ) /*&& $gBitUser->hasPermission( 'p_tags_view' )*/) {

	$menuHash = array(
		'package_name'  => FEED_PKG_NAME,
//		'index_url'     => FEED_PKG_URL.'index.php',
//		'menu_template' => 'bitpackage:feed/menu_feed.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
}

?>
