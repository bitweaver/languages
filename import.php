<?php
/**
 * @package languages
 * @subpackage functions
 * @version $Header: /cvsroot/bitweaver/_bit_languages/import.php,v 1.11 2007/01/16 11:40:37 squareing Exp $
 */

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

/**
 * Initialization
 */
require_once( '../bit_setup_inc.php' );

$gBitSystem->verifyPermission( 'p_languages_import' );

$impMsg = array();

$mid = 'bitpackage:languages/import_languages.tpl';

// Lookup translated names for the languages
$impLanguages = $gBitLanguage->listLanguages( TRUE, TRUE );
foreach( array_keys($impLanguages) as $langCode ) {
	if( !$gBitLanguage->isImportFileAvailable( $langCode ) ) {
		unset( $impLanguages[$langCode] );
	}
}
$gBitSmarty->assign_by_ref('impLanguages', $impLanguages );

// Get languages that can be exported
$expLanguages = $gBitLanguage->getImportedLanguages();
$gBitSmarty->assign_by_ref('expLanguages', $expLanguages );

if (isset($_REQUEST["exp_language"])) {
	$exp_language = $_REQUEST["exp_language"];
	$gBitSmarty->assign('exp_language', $exp_language);
}

// Import
if (isset($_REQUEST["import"])) {
	if( !empty( $_REQUEST['imp_languages'] ) ) {
		foreach( $_REQUEST['imp_languages'] as $impLang ) {
			if( $gBitLanguage->importTranslationStrings( $impLang, ($_REQUEST['overwrite'] ) == 'y') ) {
				$impMsg['success'][] = "Imported lang/" . $impLang . "/language.php";
			} else {
				$impMsg['error'][] = "Language could not be imported";
			}
		}
	}

	if( !empty( $_REQUEST["import_master"] ) && $gBitUser->isAdmin() ) {
		$gBitLanguage->importMasterStrings( $_REQUEST['overwrite'] );
		$impMsg['success'] = "Imported lang/masters.php";
	}

	if( !empty( $_FILES['upload_file']['tmp_name'] ) ) {
		$gBitLanguage->importTranslationStrings( $_REQUEST['upload_lang_code'], ($_REQUEST['overwrite'] == 'y'), 'i18n_strings`', $_FILES['upload_file']['tmp_name'] );
	}

	if( ($_REQUEST['overwrite'] == 'r') && !empty( $gBitLanguage->mImportConflicts ) ) {
		unset( $impMsg['error'] );
		$impMsg['warning'][] = tra( "Conflicts occured during language import" );
		$gBitSmarty->assign_by_ref( 'impConflicts', $gBitLanguage->mImportConflicts );
		$mid = 'bitpackage:languages/import_resolve.tpl';
	}

} elseif (isset($_REQUEST["resolve"])) {
	if( !empty( $_REQUEST['conflict'] ) ) {
		foreach( array_keys( $_REQUEST['conflict'] ) as $langCode ) {
			foreach( array_keys( $_REQUEST['conflict'][$langCode] ) as $sourceHash ) {
				if( !empty( $_REQUEST['conflict'][$langCode][$sourceHash] ) ) {
					$gBitLanguage->storeTranslationString( $langCode, $_REQUEST['conflict'][$langCode][$sourceHash], $sourceHash );
				}
			}
		}
		$impMsg['success'][] = "Language conflicts have been resolved.";
	}
} elseif (isset($_REQUEST["export"])) {
	$langCode = $_REQUEST['export_lang_code'];
	$gBitLanguage->loadLanguage( $langCode );
	$data  = "<?php\n";
	$data .= "// Save this to languages/lang/(lang_code)/language.php where lang_code is the language your are downloading.\n\n";
	$data .= "\$lang=Array(\n";

	//vd($gBitLanguage->mStrings);
	foreach( $gBitLanguage->mStrings[$_REQUEST['export_lang_code']] as $tran ) {
		if( !empty( $_REQUEST['all_trans'] ) ||  ( $tran['version'] == BIT_MAJOR_VERSION && !empty( $tran['trans'] ))) {
			if( !empty( $_REQUEST['include_empty'] ) || !empty( $tran['trans'] )) {
				//$data .= "'" . str_replace( "'", "\\'", stripslashes( $tran["source"] )) . "' => '" . str_replace( "'", "\\'",stripslashes( $tran["trans"] )) . "',\n";
				$data .= stripslashes( $tran["version"] ) . "\n";
			}
		}
	}

	$data = $data . ");\n?>";
	if( $_REQUEST['target'] == 'download' ) {
		header ("Content-type: application/unknown");
		header ("Content-Disposition: attachment; filename=language-".$langCode.".php");
		echo $data;
		exit (0);
	} else {
		// This file MUST be name "...txt" for security reasons.
		// if the file ended with .php - an evil editor could enter evil shit into a translation, and export it to your temp dir, and then execute it.
		// XOXO spiderr
		$fileName = 'lang/'.$langCode.'-language.php.txt';
		$file = fopen( TEMP_PKG_PATH.$fileName, "w" );
		fwrite( $file, $data );
		fclose( $file );
		$impMsg['success'] = "Language file has been exported to <a href=\"".TEMP_PKG_URL.$fileName."\">$fileName</a>";
	}

	// unset this massive array to free up memory
	unset( $gBitLanguage->mStrings[$_REQUEST['export_lang_code']] );
}

$gBitSmarty->assign('impmsg', $impMsg);

$gBitSystem->display( $mid, 'Languages Im/Export' );

?>
