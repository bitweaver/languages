<?php

// $Header: /cvsroot/bitweaver/_bit_languages/import.php,v 1.1.1.1.2.1 2005/07/04 15:44:45 cemseker Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

$gBitSystem->verifyPermission( 'bit_p_import_languages' );

$impMsg = array();

// Lookup translated names for the languages
$impLanguages = $gBitLanguage->listLanguages();
foreach( array_keys($impLanguages) as $langCode ) {
	if( !$gBitLanguage->isImportFileAvailable( $langCode ) ) {
		unset( $impLanguages[$langCode] );
	}
}
$smarty->assign_by_ref('impLanguages', $impLanguages );

// Get languages that can be exported
$expLanguages = $gBitLanguage->getImportedLanguages();
$smarty->assign_by_ref('expLanguages', $expLanguages );

if (isset($_REQUEST["exp_language"])) {
	$exp_language = $_REQUEST["exp_language"];
	$smarty->assign('exp_language', $exp_language);
}

// Import
if (isset($_REQUEST["import"])) {
	if( !empty( $_REQUEST['imp_languages'] ) ) {
		foreach( $_REQUEST['imp_languages'] as $impLang ) {
			if( $gBitLanguage->importTranslationStrings( $impLang, $_REQUEST['overwrite'] ) ) {
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

} elseif (isset($_REQUEST["export"])) {
	$langCode = $_REQUEST['export_lang_code'];
	$gBitLanguage->loadLanguage( $langCode );
	$data  = "<?php\n";
	$data .= "// Save this to languages/lang/(lang_code)/language.php where lang_code is the language your are downloading.\n\n";
	$data .= "\$lang=Array(\n";

	//vd($gBitLanguage->mStrings);
	foreach( $gBitLanguage->mStrings[$_REQUEST['export_lang_code']] as $tran ) {
		if( !empty( $_REQUEST['all_trans'] ) ||  ($tran['version'] == BIT_MAJOR_VERSION && !empty( $tran['tran'] ) ) ) {
			$data .= "'" . str_replace( "'", "\\'", stripslashes( $tran["source"] ) ) . "' => '" . str_replace( "'", "\\'",stripslashes( $tran["tran"] ) ) . "',\n";
		}
	}

	$data = $data . ");\n?>";
	if( $_REQUEST['target'] == 'download' ) {
		header ("Content-type: application/unknown");
		header ("Content-Disposition: inline; filename=language-".$langCode.".php");
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
}

$smarty->assign('impmsg', $impMsg);

$gBitSystem->display( 'bitpackage:languages/import_languages.tpl');

?>
