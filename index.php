<?php
// @version  $Header: /cvsroot/bitweaver/_bit_feed/index.php,v 1.2 2009/09/04 18:17:01 spiderr Exp $

// +----------------------------------------------------------------------+
// | Copyright (c) 2004, bitweaver.org
// +----------------------------------------------------------------------+
// | All Rights Reserved. See copyright.txt for details and a complete list of authors.
// | Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
// |
// | For comments, please use phpdocu.sourceforge.net documentation standards!!!
// | -> see http://phpdocu.sourceforge.net/
// +----------------------------------------------------------------------+
// | Authors: spider <spider@steelsun.com>
// +----------------------------------------------------------------------+

require_once( '../bit_setup_inc.php' );
require_once( FEED_PKG_PATH.'feed_lib.php' );

$gBitSystem->verifyPermission( 'p_feed_master' );
$listHash['max_records'] = 100;
$actions = feed_get_actions( $listHash );
$gBitSmarty->assign( 'actions', $actions);

$gBitSystem->display( 'bitpackage:feed/master_feed.tpl', FEED_PKG_NAME );
