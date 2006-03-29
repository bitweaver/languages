<?php

global $gBitSystem, $gUpgradeFrom, $gUpgradeTo;

$upgrades = array(

'BONNIE' => array(
	'BWR1' => array(

// STEP 2
array( 'DATADICT' => array(
	array( 'DROPTABLE' => array(
		'tiki_language', 'tiki_languages', 'tiki_untranslated',
	)),
	array( 'CREATE' => array (
		'tiki_i18n_languages' => "
			lang_code C(32) PRIMARY,
			native_name C(255),
			english_name C(255),
			is_disabled C(1)
		",

		'tiki_i18n_masters' => "
			source_hash C(32) PRIMARY,
			package C(100),
			created I8 NOTNULL,
			source X NOTNULL
		",

		'tiki_i18n_strings' => "
			source_hash C(32) PRIMARY,
			lang_code C(32) PRIMARY,
			last_modified I8 NOTNULL,
			tran X NOTNULL
		",

		'tiki_i18n_version_map' => "
			source_hash C(32) PRIMARY,
			version C(32)
		"
	)),
)),

// STEP 3
array( 'DATADICT' => array(
	array( 'CREATEINDEX' => array(
		'tiki_i18n_masters_pkg_idx' => array( 'tiki_i18n_masters', '`package`', array() ),
		'tiki_i18n_strings_lang_idx' => array( 'tiki_i18n_strings', '`lang`', array() ),
		'tiki_i18n_strings_lang_idx' => array( 'tiki_i18n_strings', '`source_hash`', array() ),
		'tiki_tiki_i18n_version_src_idx' => array( 'tiki_i18n_version_map', '`source_hash`', array() ),
		'tiki_tiki_i18n_version_ver_idx' => array( 'tiki_i18n_version_map', '`version`', array() ),
	)),
)),

// STEP 4 - add some defaults
array( 'QUERY' =>
	array( 'SQL92' => array(
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ar', 'ﺎﻠﻋﺮﺒﻳﺓ', 'Arabic' )",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('cs', 'Český', 'Czech')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('da', 'Dansk', 'Danish')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('de', 'Deutsch', 'German')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('en', 'English', 'English')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('en-uk', 'British English', NULL)",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('es', 'Español', 'Spanish')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('el', 'Greek', 'Greek')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('fr', 'Français', 'French')",
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('hr', 'Hrvatski', 'Croatian' )",
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('hu', 'Magyar', 'Hungarian' )",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('it', 'Italiano', 'Italian')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ja', '日本語', 'Japanese')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ko', '한국말', 'Korean')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('nl', 'Nederlands', 'Dutch')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('no', 'Norwegian', 'Norwegian')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('pl', 'Polish', 'Polish')",
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('pt', 'Português', 'Portuguese' )",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('pt-br', 'Português Brasileiro', 'Brazilian Portuguese')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ru', 'Russian', 'Russian')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sb', 'Pijin Solomon', 'Pijin Solomon')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sk', 'Slovenský', 'Slovak')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sr', 'Српски', 'Serbian')",
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sr-latn', 'Srpski', 'Serbian Latin' )",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sv', 'Svenska', 'Swedish')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tw', '中文(繁体字)', 'Traditional Chinese')",
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tv', 'Tuvaluan', NULL )",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('uk', 'Українська', 'Ukrainian')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('zh-cn', 'Chinese', 'Chinese')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ca', 'Catalan', 'Catalan')",
	)),
),

	)
),

	'BWR1' => array(
		'BWR2' => array(
// de-tikify tables
array( 'DATADICT' => array(
	array( 'RENAMETABLE' => array(
		'tiki_i18n_languages' => 'i18n_languages',
		'tiki_i18n_masters' => 'i18n_masters',
		'tiki_i18n_strings' => 'i18n_strings',
		'tiki_i18n_version_map' => 'i18n_version_map',
	)),
	array( 'ALTER' => array(
		'i18n_languages' => array( '`left_to_right`', 'VARCHAR(1)' ),
	)),
	array( 'CREATE' => array (
		'i18n_content_trans_map' => "
			content_id I4 NOTNULL,
			translation_id I4 NOTNULL
			CONSTRAINT ', CONSTRAINT `liberty_translation_ref` FOREIGN KEY (`content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content`( `content_id` )'
		",
	)),
	array( 'RENAMECOLUMN' => array(
		'i18n_strings' => array(
			'`value`' => 'pref_value'
		),
	)),
)),
		)
	),
);

if( isset( $upgrades[$gUpgradeFrom][$gUpgradeTo] ) ) {
	$gBitSystem->registerUpgrade( LANGUAGES_PKG_NAME, $upgrades[$gUpgradeFrom][$gUpgradeTo] );
}


?>
