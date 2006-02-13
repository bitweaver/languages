<?php
/**
 * @package languages
 * @subpackage functions
 * @version $Header: /cvsroot/bitweaver/_bit_languages/switch_lang.php,v 1.8 2006/02/13 10:06:16 squareing Exp $
 */

/**
 * Initialization
 */
require_once( '../bit_setup_inc.php' );
include_once( KERNEL_PKG_PATH.'BitBase.php' );

if (isset($_SERVER['HTTP_REFERER'])) {
	$orig_url = $_SERVER['HTTP_REFERER'];
} else {
	$orig_url = BIT_ROOT_URL;
}

if( !empty( $_GET['language'] ) ) {
	if($gBitSystem->isFeatureActive( 'users_preferences' ) && $gBitUser->isRegistered() && $gBitSystem->isFeatureActive( 'change_language' ) )  {
		$gBitUser->storePreference( 'bitlanguage', $_GET['language'] );
	} else {
		$_SESSION["bitlanguage"] = $_GET['language'];
		// $gBitLanguage->mLanguage will be read again in the location: redirect
	}
}

header("location: $orig_url");
exit;
?>
