<?php
$formLanguageToggles = array(
	'browser_languages' => array(
		'label' => 'Browser Language Recognition',
		'note' => 'This will automatically recognise what the browsers default language is set to and display that language.<br />Please make sure you import appropriate languages first and disable / remove languages you don\'t want to support since loading a language for the first time will induce a lot of database traffic and might cause your system to slow down temporarily.',
	),
	'record_untranslated' => array(
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
$smarty->assign( 'formLanguageToggles',$formLanguageToggles );

// Handle Update
if (isset($_REQUEST["prefs"])) {
	
    foreach ($formLanguageToggles as $toggle => $data) {
        simple_set_toggle ($toggle);
    }

    $pref_byref_values = array(
        "tikilanguage",
    );
    foreach ($pref_byref_values as $britem) {
		byref_set_value ($britem, NULL, LANGUAGES_PKG_NAME);
    }
	global $gBitLanguage;
	$gBitLanguage->setLanguage( $gBitSystem->getPreference( 'tikilanguage' ) );
} else {
	$smarty->assign("language", $gBitSystem->getPreference("language", "en"));
}

// Get list of available languages
$languages = array();
$languages = $gBitLanguage->listLanguages();
$smarty->assign_by_ref("languages",$languages );
?>
