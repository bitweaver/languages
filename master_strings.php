<?php
/**
 * @package languages
 * @subpackage functions
 * @version $Header: /cvsroot/bitweaver/_bit_languages/master_strings.php,v 1.1.1.1.2.3 2005/12/19 00:30:36 lsces Exp $
 */

// Copyright (c) 2005, bitweaver.org
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
/**
 * Initialization
 */
require_once( '../bit_setup_inc.php' );

$gBitSystem->verifyPermission( 'bit_p_edit_master_strings' );

$languages = $gBitLanguage->listLanguages();
$gBitSmarty->assign_by_ref( 'languages', $languages );

if( !empty( $_REQUEST['change_master'] ) ) {
	$newSourceHash = $gBitLanguage->getSourceHash( $_REQUEST['edit_master'] );
	$gBitLanguage->loadMasterStrings();
	if( $newSourceHash != $_REQUEST['source_hash'] ) {
		if( $gBitLanguage->storeMasterString( array( 'source_hash' => $_REQUEST['source_hash'], 'new_source' => $_REQUEST['edit_master'] ) ) ) {
			$_REQUEST['source_hash'] = $newSourceHash;
			$masterMsg['success'] = 'Master translation string has been updated';
		} else {
			$masterMsg['error'] = $gBitLanguage->mErrors['master'];
		}
	}
	$gBitLanguage->loadMasterStrings( $_REQUEST['source_hash'] );
	$gBitSmarty->assign_by_ref( 'masterStrings', $gBitLanguage->mStrings['master'] );
	$gBitSmarty->assign_by_ref( 'tranStrings', $gBitLanguage->getTranslatedStrings( $_REQUEST['source_hash'] ) );
	$gBitSmarty->assign( 'sourceHash', $_REQUEST['source_hash'] );
} elseif( !empty( $_REQUEST['delete_master'] ) && !empty( $_REQUEST['source_hash'] ) ) {
	if( empty( $_REQUEST['confirm'] ) ) {
		$gBitSystem->setBrowserTitle( tra( 'Confirm Delete' ) );
		$formHash['delete_master'] = TRUE;
		$formHash['source_hash'] = $_REQUEST['source_hash'];
		$msgHash = array(
			'label' => tra( 'Delete Master String' ),
			'confirm_item' => empty( $_REQUEST['edit_master'] ) ? NULL : $_REQUEST['edit_master'],
			'warning' => tra( 'This will remove the language master string. If you are tracking translations and the string is still used, it will be inserted again, however, any translations associated with it will be lost.' ),
		);
		$gBitSystem->confirmDialog( $formHash, $msgHash );
		die;
	} else {
		if( $gBitLanguage->expungeMasterString( $_REQUEST['source_hash'] ) ) {
			$gBitSmarty->assign( 'successMsg', 'The master string was deleted successfully.' );
		} else {
			$gBitSmarty->assign( 'errorMsg', 'The master string could not be deleted.' );
		}
	}
} elseif( !empty( $_REQUEST['guess_translations'] ) ) {
	$gBitLanguage->loadMasterStrings( $_REQUEST['source_hash'] );
	$masterStrings = $gBitLanguage->mStrings['master'];
	if( strlen( $masterStrings[$_REQUEST['source_hash']]['source'] ) > 70 ) {
		$masterStrings[$_REQUEST['source_hash']]['textarea'] = TRUE;
	}
	$gBitSmarty->assign_by_ref( 'masterStrings', $masterStrings );
	$masterString = $gBitLanguage->mStrings['master'][$_REQUEST['source_hash']];
	$tranArray = array( 'de', 'es', 'fr', 'it', 'pt', 'ja', 'ko', 'zh-CN' );
	$tranStrings = array();
	foreach( $tranArray as $toLangCode ) {
		$handle = fopen("http://translate.google.com/translate_t?ie=UTF-8&oe=UTF-8&text=".urlencode( $masterString['source'] )."&langpair=en|$toLangCode", "r");
		if($handle) {
			$contents = '';
			while (!feof($handle)) {
				$contents .= fread($handle, 8192);
			}
			fclose($handle);
			preg_match_all( "/(.*)(<textarea name=q[^>]*>)([^>]*)<\/textarea>.*/", $contents, $matches );
			if( isset( $matches[3][0] ) ) {
				$tranStrings[$toLangCode]['guessed'] = TRUE;
				$tranStrings[$toLangCode]['source_hash'] = $_REQUEST['source_hash'];
				$tranStrings[$toLangCode]['tran'] = $matches[3][0];
				$tranStrings[$toLangCode]['lang_code'] = $toLangCode;
			}
		}
	}
	$gBitSmarty->assign( 'sourceHash', $_REQUEST['source_hash'] );
	$gBitSmarty->assign_by_ref( 'tranStrings', $tranStrings );
} elseif( !empty( $_REQUEST['save_translations'] ) ) {
	$tranStrings = $gBitLanguage->getTranslatedStrings( $_REQUEST['source_hash'] );
	$gBitSmarty->assign( 'source_hash', $_REQUEST['source_hash'] );
	$sourceHash = $_REQUEST['source_hash'];
	foreach( $_REQUEST['edit_trans'] as $langCode => $string ) {
		// store if (We had a string and it is now empty) or ( we have a new string and it is different from before)
		if( (empty( $string ) && !empty( $tranStrings[$langCode] ))
			|| (!empty( $string ) && (empty( $tranStrings[$langCode] ) || $string != $tranStrings[$langCode]['tran']) ) ) {
			$gBitLanguage->storeTranslationString( $langCode, $string, $sourceHash );
		}
	}
	header( 'Location: '.$_SERVER['PHP_SELF'].'?source_hash='.$_REQUEST['source_hash'] );
	die;
} elseif( !empty( $_REQUEST['source_hash'] ) && empty( $_REQUEST['cancel'] ) ) {
	$gBitLanguage->loadMasterStrings( $_REQUEST['source_hash'] );
	$masterStrings = $gBitLanguage->mStrings['master'];
	if( strlen( $masterStrings[$_REQUEST['source_hash']]['source'] ) > 70 ) {
		$masterStrings[$_REQUEST['source_hash']]['textarea'] = TRUE;
	}
	$gBitSmarty->assign_by_ref( 'masterStrings', $masterStrings );
	$translate = $gBitLanguage->getTranslatedStrings( $_REQUEST['source_hash'] );
	$gBitSmarty->assign_by_ref( 'tranStrings', $translate );
	$gBitSmarty->assign( 'sourceHash', $_REQUEST['source_hash'] );
} elseif( !empty( $_REQUEST['find'] ) && !empty( $_REQUEST['search'] ) ) {
	$gBitSmarty->assign_by_ref( 'masterStrings', $gBitLanguage->searchMasterStrings( $_REQUEST['find'] ) );
} else {
	$gBitLanguage->loadMasterStrings();
	// work out what strings to display
	if( empty( $_REQUEST['char'] ) ) {
		$pattern = "/^a/i";
	} elseif ( $_REQUEST['char'] == '0-9' ) {
		$pattern = "/^\d/";
	} elseif ( $_REQUEST['char'] == '+' ) {
		$pattern = "/^[^a-zA-Z]/";
	} elseif ( $_REQUEST['char'] == 'all' ) {
		$pattern = "//";
	} else {
		$pattern = "/^".$_REQUEST['char']."/i";
	}
	$masterStr = $gBitLanguage->mStrings['master'];
	foreach( $masterStr as $key => $master ) {
		if( preg_match( $pattern, $master['source'] ) ) {
			$masterStrings[$key] = $master;
		}
	}
	$gBitSmarty->assign( 'char', empty( $_REQUEST['char'] ) ? '' : $_REQUEST['char'] );
	$gBitSmarty->assign_by_ref( 'masterStrings', $masterStrings );
}

// Display the template
$gBitSmarty->assign_by_ref( 'masterMsg', $masterMsg );
$gBitSystem->display( 'bitpackage:languages/language_master_strings.tpl', 'Edit Master Strings' );
?>
