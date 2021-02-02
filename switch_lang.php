<?php
/**
 * @package languages
 * @subpackage functions
 * @version $Header$
 */

/**
 * Initialization
 */
require_once( '../kernel/setup_inc.php' );
include_once( KERNEL_PKG_CLASS_PATH.'BitBase.php' );

if (isset($_SERVER['HTTP_REFERER'])) {
	$orig_url = $_SERVER['HTTP_REFERER'];
} else {
	$orig_url = BIT_ROOT_URL;
}

if( !empty( $_GET['language'] ) ) {
	if($gBitSystem->isFeatureActive( 'users_preferences' ) && $gBitUser->isRegistered() && $gBitSystem->isFeatureActive( 'users_change_language' ) )  {
		$gBitUser->storePreference( 'bitlanguage', $_GET['language'] );
	} else {
		$_SESSION["bitlanguage"] = $_GET['language'];
		// $gBitLanguage->mLanguage will be read again in the location: redirect
	}
}

header("location: $orig_url");
exit;
?>
