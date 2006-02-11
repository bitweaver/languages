<?php
	global $gBitSystem, $gBitLanguage, $gBitUser, $gBitSmarty;

	$gBitSystem->registerPackage( 'languages', dirname( __FILE__).'/' );

	// **********  BABELFISH  ************
	if ($gBitSystem->isFeatureActive('babelfish') ) {
		require_once(LANGUAGES_PKG_PATH . 'Babelfish.php');
		$gBitSmarty->assign_by_ref('babelfish_links', Babelfish::links( $gBitSystem->getPreference('language', 'en') ));
	}
	if ($gBitSystem->isFeatureActive('babelfish_logo') ) {
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

	require_once( LANGUAGES_PKG_PATH . 'LibertyTranslations.php' );
	$gLibertySystem->registerService( LIBERTY_SERVICE_TRANSLATION, LANGUAGES_PKG_NAME, array(
		//'content_display_function' => 'translation_content_display',
		//'content_preview_function' => 'translation_content_edit',
		'content_edit_function' => 'translation_content_edit',
		'content_store_function' => 'translation_content_store',
		//'content_list_function' => 'translation_content_list',
		//'content_load_function' => 'translation_content_load',
		'content_edit_mini_tpl' => 'bitpackage:languages/select_translations.tpl',
		//'content_icon_tpl' => 'bitpackage:languages/translate_service_icon.tpl',
	) );

	if( !empty( $_POST['translate'] ) ) {
		if( is_numeric( $_POST['translate_content_id'] ) ) {
			$get = 'content_id='.$_POST['translate_content_id'];
		} else {
			$get = 'lang_code='.$_POST['translate_content_id'];
		}
		if( LibertyBase::verifyId( $_POST['translate_id'] ) ) {
			$get .= '&translate_group_id='.$_POST['translate_id'];
		} else {
			$get .= '&translate_from_id='.$_POST['content_id'];
		}
		header( 'Location: '.$_SERVER['SCRIPT_URL'].'?'.$get );
		die;
	}
?>
