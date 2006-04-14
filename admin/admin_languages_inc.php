<?php
$formLanguageToggles = array(
	'browser_languages' => array(
		'label' => 'Browser Language Recognition',
		'note' => 'This will automatically recognise what the browsers default language is set to and display that language.<br />Please make sure you import appropriate languages first and disable / remove languages you don\'t want to support since loading a language for the first time will induce a lot of database traffic and might cause your system to slow down temporarily.',
	),
	'i18n_content_translation' => array(
		'label' => 'Content Translation',
		'note' => 'This will activate the content translation service. Users will be given links to content in alternate languages, and prompted to create translation while editing content.',
	),
	'interactive_translation' => array(
		'label' => 'Interactive Translations',
		'note' => 'This will help you translate your site very effitiently by giving you direct access to the correct translation page.<br />Once you are done translating, make sure you turn this feature off and clear the language cache.<br />This feature only works when you set <em>$smarty_force_compile</em> to TRUE in your <em>kernel/config_inc.php</em> file',
		'page' => 'TranslationTutorial',
		'link' => array(
			'title' => 'Language cache',
			'package' => 'languages',
			'file' => 'edit_languages.php'
		),
	),
	'interactive_bittranslation' => array(
		'label' => 'Interactive bitTranslations',
		'note' => 'If you have a <a href="http://doc.bitweaver.org/forums/viewtopic.php?t=948">translators account</a> on bitweaver.org, the translation links will redirect you there that you can modify the tranlations there. Due to the different setup on bitweaver.org, there might be strings that are not available for translation on that server.',
	),
	'languages_record_untranslated' => array(
		'label' => 'Record untranslated',
		'note' => 'This will record any untranslated language strings.',
	),
	'track_translation_usage' => array(
		'label' => 'Track Translation Usage',
		'note' => 'Track which strings are used in your version of bitweaver so only the currently used strings appear while editing translations. You must clear your language and templates cache after enabling this option.',
		'link' => array(
			'title' => 'Language cache',
			'package' => 'languages',
			'file' => 'edit_languages.php'
		),
	),
);
$gBitSmarty->assign( 'formLanguageToggles',$formLanguageToggles );

// Handle Update
if (isset($_REQUEST["prefs"])) {
	foreach ($formLanguageToggles as $toggle => $data) {
		simple_set_toggle ($toggle, LANGUAGES_PKG_NAME);
	}

	$pref_byref_values = array(
		"bitlanguage",
	);
	foreach ($pref_byref_values as $britem) {
		byref_set_value ($britem, NULL, LANGUAGES_PKG_NAME);
	}
	global $gBitLanguage;
	$gBitLanguage->setLanguage( $gBitSystem->getConfig( 'bitlanguage' ) );
} else {
	$gBitSmarty->assign("language", $gBitSystem->getConfig("language", "en"));
}

// Get list of available languages
$languages = array();
$languages = $gBitLanguage->listLanguages();
$gBitSmarty->assign_by_ref("languages",$languages );
?>
