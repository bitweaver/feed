<?php
$tables = array(
  'feed_conjugation' => "
	content_type_guid C(16) NOTNULL,
	conjugation_phrase C(255) NOTNULL,
	feed_icon_url C(255),
	is_target_linked   C(1)
    CONSTRAINT ', CONSTRAINT `feed_conj_content_type_ref` FOREIGN KEY (`content_type_guid`) REFERENCES `".BIT_DB_PREFIX."liberty_content_types` ( `content_type_guid` )'
  "
);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( FEED_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerSchemaDefault( FEED_PKG_NAME, array(
	"INSERT INTO `".BIT_DB_PREFIX."feed_conjugation` (`content_type_guid`, `conjugation_phrase`, `is_target_linked`,`feed_icon_url`) VALUES ('bituser', 'updated their profile', 'y','".FEED_PKG_URL."icons/pixelmixerbasic/user_16.png')",
	"INSERT INTO `".BIT_DB_PREFIX."feed_conjugation` (`content_type_guid`,`conjugation_phrase`,`is_target_linked`,`feed_icon_url`) VALUES ('bitcomment','commented','y','".FEED_PKG_URL."icons/pixelmixerbasic/bubble_16.png')",
));

$gBitInstaller->registerPackageInfo( FEED_PKG_NAME, array(
	'description' => "User feed package that makes use of Liberty action log",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( FEED_PKG_NAME, array(
	array( 'p_feed_admin', 'Can admin feeds', 'admin', FEED_PKG_NAME ),
	array( 'p_feed_view', 'Can view feed', 'basic', FEED_PKG_NAME ),
) );

?>
