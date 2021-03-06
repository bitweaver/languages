<?php

$registerHash = array(
	'package_name' => 'languages',
	'package_path' => dirname( dirname( __FILE__ ) ).'/',
	'service' => LIBERTY_SERVICE_TRANSLATION,
	'required_package'=> TRUE,
);
$gBitSystem->registerPackage( $registerHash );

// **********  BABELFISH  ************
if ($gBitSystem->isFeatureActive('babelfish') ) {
	require_once(LANGUAGES_PKG_CLASS_PATH.'Babelfish.php');
	$gBitSmarty->assignByRef('babelfish_links', Babelfish::links( $gBitSystem->getConfig('language', 'en') ));
}
if ($gBitSystem->isFeatureActive('babelfish_logo') ) {
	require_once(LANGUAGES_PKG_CLASS_PATH.'Babelfish.php');
	$gBitSmarty->assign('babelfish_logo', Babelfish::logo($gBitLanguage->mLanguage));
}
if( $gBitSystem->isPackageActive( 'languages' ) && $gBitUser->hasPermission( 'p_languages_edit' ) ) {
	$menuHash = array(
		'package_name'  => LANGUAGES_PKG_NAME,
		'index_url'     => LANGUAGES_PKG_URL.'edit_languages.php',
		'menu_template' => 'bitpackage:languages/menu_languages.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
}

if( $gBitSystem->isFeatureActive( 'users_preferences' ) && $gBitUser->isRegistered() ) {
	if( $gBitSystem->isFeatureActive( 'users_change_language' ) ) {
		if( $userLang = $gBitUser->getPreference( 'bitlanguage' ) ) {
			$gBitLanguage->setLanguage( $userLang );
		}
	}
}

// oe=XX global request parameter where XX is an enabled language code that overrides everything else
// oe is Output Encoding, which is the var google uses
if( !empty( $_REQUEST['oe'] ) && !empty( $gBitLanguage->mLanguageList[$_REQUEST['oe']] ) ) {
	$gBitLanguage->setLanguage( $_REQUEST['oe'] );
}

$gBitSmarty->assignByRef('gBitLanguage', $gBitLanguage);
$gBitSmarty->assign('bitlanguage', $gBitLanguage->mLanguage);

if( !empty( $gLibertySystem ) && $gBitSystem->isFeatureActive( 'i18n_content_translation' ) ) {
	require_once( LANGUAGES_PKG_CLASS_PATH.'LibertyTranslations.php' );
	$gLibertySystem->registerService( LIBERTY_SERVICE_TRANSLATION, LANGUAGES_PKG_NAME, array(
		'content_display_function' => 'translation_content_display',
		//'content_preview_function' => 'translation_content_edit',
		'content_edit_function' => 'translation_content_edit',
		'content_store_function' => 'translation_content_store',
		'content_expunge_function' => 'translation_content_exunge',
		//'content_list_sql_function' => 'translation_content_list',
		//'content_load_sql_function' => 'translation_content_load',
		'content_edit_mini_tpl' => 'bitpackage:languages/select_translations.tpl',
		'content_icon_tpl' => 'bitpackage:languages/i18n_service_icons.tpl',
	) );

	if( !empty( $_POST['i18n']['translate'] ) ) {
		if( @BitBase::verifyId( $_POST['i18n']['to_id'] ) ) {
			$get = '&content_id='.$_POST['i18n']['to_id'];
		} else {
			$get = 'i18n[lang_code]='.$_POST['i18n']['to_id'];
		}
		if( @BitBase::verifyId( $_POST['i18n']['translation_id'] ) ) {
			$get .= '&i18n[translation_id]='.$_POST['i18n']['translation_id'];
		}
		if( !empty( $_POST['i18n']['google'] ) ) {
			$get .= '&i18n[google]=1';
		}
		$get .= '&i18n[from_id]='.$_POST['i18n']['from_id'];
		header( 'Location: '.$_SERVER['SCRIPT_NAME'].'?'.$get );
		die;
	}
}
?>
