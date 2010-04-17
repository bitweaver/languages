<?php

$tables = array(

'i18n_languages' => "
	lang_code C(32) PRIMARY,
	native_name C(255),
	english_name C(255),
	is_disabled C(1),
	right_to_left C(1)
",

'i18n_masters' => "
	source_hash C(32) PRIMARY,
	package C(100),
	created I8 NOTNULL,
	source X NOTNULL
",

'i18n_strings' => "
	source_hash C(32) PRIMARY,
	lang_code C(32) PRIMARY,
	last_modified I8 NOTNULL,
	trans X NOTNULL
",

'i18n_version_map' => "
	source_hash C(32) PRIMARY,
	version C(32) PRIMARY
",

'i18n_content_trans_map' => "
	content_id I4 NOTNULL,
	translation_id I4 NOTNULL
	CONSTRAINT ', CONSTRAINT `liberty_translation_ref` FOREIGN KEY (`content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content`( `content_id` )'
",

);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( LANGUAGES_PKG_NAME, $tableName, $tables[$tableName], TRUE );
}

$indices = array (
	'i18n_masters_pkg_idx' => array( 'table' => 'i18n_masters', 'cols' => 'package', 'opts' => NULL ),
	'i18n_masters_created_idx' => array( 'table' => 'i18n_masters', 'cols' => 'created', 'opts' => NULL ),
	'i18n_strings_lang_idx' => array( 'table' => 'i18n_strings', 'cols' => 'lang_code', 'opts' => NULL ),
	'i18n_strings_lang_idx' => array( 'table' => 'i18n_strings', 'cols' => 'source_hash', 'opts' => NULL ),
	'i18n_strings_modif_idx' => array( 'table' => 'i18n_strings', 'cols' => 'last_modified', 'opts' => NULL ),
	'i18n_version_src_idx' => array( 'table' => 'i18n_version_map', 'cols' => 'source_hash', 'opts' => NULL ),
	'i18n_version_ver_idx' => array( 'table' => 'i18n_version_map', 'cols' => 'version', 'opts' => NULL  ),
);
$gBitInstaller->registerSchemaIndexes( LANGUAGES_PKG_NAME, $indices );

// ### Sequences
//$sequences = array (
//	'i18n_content_trans_id_seq' => array( 'start' => 1 ),
//);
//$gBitInstaller->registerSchemaSequences( LIBERTY_PKG_NAME, $sequences );

$gBitInstaller->registerPackageInfo( LANGUAGES_PKG_NAME, array(
	'description' => "This package allows you to translate your site into a different language.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( LANGUAGES_PKG_NAME, array(
	array( LANGUAGES_PKG_NAME, 'i18n_record_untranslated','y' ),
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( LANGUAGES_PKG_NAME, array(
	array('p_languages_create', 'Can create new languages', 'admin', LANGUAGES_PKG_NAME),
	array('p_languages_edit', 'Can edit translations', 'editors', LANGUAGES_PKG_NAME),
	array('p_languages_delete', 'Can delete languages', 'admin', LANGUAGES_PKG_NAME),
	array('p_languages_edit_master', 'Can edit master translation strings', 'admin', LANGUAGES_PKG_NAME),
	array('p_languages_import', 'Can import and export language files', 'editors', LANGUAGES_PKG_NAME),
) );

$gBitInstaller->registerSchemaDefault( LANGUAGES_PKG_NAME, array(
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`,`right_to_left`) VALUES ('ar', 'ﺎﻠﻋﺮﺒﻳﺓ', 'Arabic','y' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ca', 'Català', 'Catalan')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('cs', 'Český', 'Czech')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('cy', 'Cymraeg', 'Welsh')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('da', 'Dansk', 'Danish')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('de', 'Deutsch', 'German')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('en', 'English', 'English')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('en-uk', 'British English', 'British English')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('es', 'Español', 'Spanish')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('el', 'Ελληνικά', 'Greek')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`,`right_to_left`) VALUES ('fa', 'فارسی', 'Farsi', 'y' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('fi', 'suomi', 'Finish')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('fr', 'Français', 'French')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`,`right_to_left`) VALUES ('he', 'עברית', 'Hebrew', 'y' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('hr', 'Hrvatski', 'Croatian' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('hu', 'Magyar', 'Hungarian' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('it', 'Italiano', 'Italian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ja', '日本語', 'Japanese')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ko', '한국어', 'Korean')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('lt', 'Lietuviškai', 'Lithuanian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('mk', 'Македонски', 'Macedonian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('nl', 'Nederlands', 'Dutch')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('no', 'Norsk', 'Norwegian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('pl', 'Polski', 'Polish')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('pt', 'Português', 'Portuguese' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('pt-br', 'Português Brasileiro', 'Brazilian Portuguese')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ru', 'Pyccĸий', 'Russian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sb', 'Pijin Solomon', 'Pijin Solomon')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sk', 'Slovenský', 'Slovak')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sr', 'Srpski', 'Serbian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sr-latn', 'Српски', 'Serbian Latin' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('sv', 'Svenska', 'Swedish')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tw', '�繁體中文', 'Traditional Chinese')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('ti', 'ภาษาไทย', 'Thai')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tr', 'Türkçe', 'Turkish'  )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('tv', 'Tuvaluan', 'Tuvaluan' )",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('uk', 'Українська', 'Ukrainian')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`,`right_to_left`) VALUES ('ur', 'اردو', 'Urdu', 'y')",
	"INSERT INTO `".BIT_DB_PREFIX."i18n_languages` (`lang_code`,`native_name`,`english_name`) VALUES ('zh-cn', '简体中文', 'Chinese')",
) );

// Package requirements
$gBitInstaller->registerRequirements( LANGUAGES_PKG_NAME, array(
	'liberty'   => array( 'min' => '2.1.4' ),
	'users'     => array( 'min' => '2.1.0' ),
	'kernel'    => array( 'min' => '2.0.0' ),
	'themes'    => array( 'min' => '2.0.0' ),
));
?>
