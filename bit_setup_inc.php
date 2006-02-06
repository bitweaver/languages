<?php
	global $gBitSystem, $gBitLanguage, $gBitUser, $gBitSmarty;

	$gBitSystem->registerPackage( 'languages', dirname( __FILE__).'/' );

	// **********  BABELFISH  ************
	if ($gBitSystem->getPreference('feature_babelfish') == 'y')
	{
		require_once(LANGUAGES_PKG_PATH . 'Babelfish.php');
		$gBitSmarty->assign_by_ref('babelfish_links', Babelfish::links( $gBitSystem->getPreference('language', 'en') ));
	}
	if ($gBitSystem->getPreference('feature_babelfish_logo') == 'y')
	{
		require_once(LANGUAGES_PKG_PATH . 'Babelfish.php');
		$gBitSmarty->assign('babelfish_logo', Babelfish::logo($gBitLanguage->mLanguage));
	}
	if( $gBitSystem->isPackageActive( 'languages' ) && $gBitUser->hasPermission( 'bit_p_edit_languages' ) ) {
		$gBitSystem->registerAppMenu( LANGUAGES_PKG_NAME, ucfirst( LANGUAGES_PKG_DIR ), LANGUAGES_PKG_URL.'edit_languages.php', 'bitpackage:languages/menu_languages.tpl', 'Languages');
	}

	if( $gBitSystem->isFeatureActive( 'feature_user_preferences' ) && $gBitUser->isRegistered() ) {
		if( $gBitSystem->isFeatureActive( 'change_language' ) ) {
			if( $userLang = $gBitUser->getPreference( 'bitLanguage' ) ) {
				$gBitLanguage->setLanguage( $userLang );
			}
		}
	}

	// oe=XX global request parameter where XX is an enabled language code that overrides everything else
	// oe is Output Encoding, which is the var google uses
	if( !empty( $_REQUEST['oe'] ) && !empty( $gBitLanguage->mLanguageList[$_REQUEST['oe']] ) ) {
		$gBitLanguage->setLanguage( $_REQUEST['oe'] );
	}

	$gBitSmarty->assign('bitlanguage', $gBitLanguage->mLanguage);
?>
