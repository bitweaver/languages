<?php

$tables = array(

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

);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( LANGUAGES_PKG_DIR, $tableName, $tables[$tableName], TRUE );
}

$indices = array (
	'tiki_i18n_masters_pkg_idx' => array( 'table' => 'tiki_i18n_masters', 'cols' => '`package`', 'opts' => NULL ),
	'tiki_i18n_masters_created_idx' => array( 'table' => 'tiki_i18n_masters', 'cols' => '`created`', 'opts' => NULL ),
	'tiki_i18n_strings_lang_idx' => array( 'table' => 'tiki_i18n_strings', 'cols' => '`lang_code`', 'opts' => NULL ),
	'tiki_i18n_strings_lang_idx' => array( 'table' => 'tiki_i18n_strings', 'cols' => '`source_hash`', 'opts' => NULL ),
	'tiki_i18n_strings_modif_idx' => array( 'table' => 'tiki_i18n_strings', 'cols' => '`last_modified`', 'opts' => NULL ),
	'tiki_i18n_version_src_idx' => array( 'table' => 'tiki_i18n_version_map', 'cols' => '`source_hash`', 'opts' => NULL ),
	'tiki_i18n_version_ver_idx' => array( 'table' => 'tiki_i18n_version_map', 'cols' => '`version`', 'opts' => NULL  ),
);

$gBitInstaller->registerSchemaIndexes( LANGUAGES_PKG_DIR, $indices );

$gBitInstaller->registerPackageInfo( LANGUAGES_PKG_NAME, array(
	'description' => "This package allows you to translate your site into a different language.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
	'version' => '0.1',
	'state' => 'experimental',
	'dependencies' => '',
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( LANGUAGES_PKG_NAME, array(
	array(LANGUAGES_PKG_NAME, 'feature_babelfish','n'),
	array(LANGUAGES_PKG_NAME, 'feature_babelfish_logo','n'),
	array(LANGUAGES_PKG_NAME, 'record_untranslated','y'),
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( LANGUAGES_PKG_NAME, array(
	array('bit_p_edit_languages', 'Can edit translations and create new languages', 'editors', 'tiki'),
	array('bit_p_delete_languages', 'Can delete languages', 'admin', 'tiki'),
	array('bit_p_edit_master_strings', 'Can edit master translation strings', 'admin', 'tiki'),
	array('bit_p_import_languages', 'Can import and export language files', 'editors', 'tiki'),
) );

$gBitInstaller->registerSchemaDefault( LANGUAGES_PKG_NAME, array(
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
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tr', 'Turkish', 'Türkçe' )",
	"INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tv', 'Tuvaluan', NULL )",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('uk', 'Українська', 'Ukrainian')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('zh', 'Chinese', 'Chinese')",
    "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ca', 'Catalan', 'Catalan')",
) );

//  lang file is not UTF-8  'cn' => array(  '中文(簡体字)',      tra("Simplified Chinese')",
//  lang file is not UTF-8  'he' => array(  'Hebrew',    tra("Hebrew')",

?>
