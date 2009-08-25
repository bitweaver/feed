<?php
global $gBitSystem, $gBitUser, $gBitThemes;

$registerHash = array(
	'package_name' => 'feed',
	'package_path' => dirname( __FILE__ ).'/',
);

$gBitSystem->registerPackage( $registerHash );


if( $gBitSystem->isPackageActive( 'feed' ) ) {

	$menuHash = array(
		'package_name'  => FEED_PKG_NAME,
	);
	$gBitSystem->registerAppMenu( $menuHash );
}

?>
