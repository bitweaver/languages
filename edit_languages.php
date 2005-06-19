<?php

// $Header: /cvsroot/bitweaver/_bit_languages/edit_languages.php,v 1.1 2005/06/19 04:54:47 bitweaver Exp $

// Copyright (c) 2005, bitweaver.org
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

$gBitSystem->verifyPermission( 'bit_p_edit_languages' );

// Get available languages from DB
$languages = $gBitLanguage->listLanguages();
$smarty->assign_by_ref('languages', $languages);

if( !empty( $_REQUEST['all_trans'] ) ) {
	$smarty->assign( 'allTrans', 1 );
}

if( !empty( $_REQUEST['un_trans'] ) ) {
	$smarty->assign( 'unTrans', 1 );
}


if( !empty( $_REQUEST['clear_cache'] ) ) {
	$gBitLanguage->clearCache();
	$smarty->assign( 'saveSuccess', tra( 'System template and language cache have been cleared.' ) );
} elseif( !empty( $_REQUEST['translate'] ) ) {
	$editLang = $_REQUEST['lang'];
	$smarty->assign( 'lang', $editLang );
	$smarty->assign( 'translate', TRUE );
	if( !empty( $_REQUEST['hash'] ) ) {
		$tranStrings = $gBitLanguage->getTranslationString( $_REQUEST['hash'], $editLang );
		$smarty->assign_by_ref('tranStrings', $tranStrings );
	} else {
		$gBitLanguage->loadLanguage( $editLang );
		$tranStr = $gBitLanguage->mStrings[$editLang];
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
		foreach( $tranStr as $key => $tran ) {
			// display only the wanted strings and apply a textbox if the string is too long
			if( !empty( $_REQUEST['un_trans'] ) && empty( $tran['tran'] ) || empty( $_REQUEST['un_trans'] ) ) {
				if( preg_match( $pattern, $tran['source'] ) ) {
					$tranStrings[$key] = $tran;
					if( strlen( $tran['source'] ) > 70 ) {
						$tranStrings[$key]['textarea'] = TRUE;
					}
				}
			}
		}
		$smarty->assign( 'char', empty( $_REQUEST['char'] ) ? '' : $_REQUEST['char'] );
		$smarty->assign_by_ref( 'tranStrings', $tranStrings );
	}
} elseif( isset($_REQUEST["delete_language"] ) ) {
	if( $gBitUser->hasPermission( 'bit_p_delete_languages' ) ) {
		if( isset( $_REQUEST["confirm"] ) ) {
			$gBitLanguage->expungeLanguage( $_REQUEST['delete_lang_code'] );
			unset( $languages[$_REQUEST['delete_lang_code']] );
		} else {
			$formHash['delete_lang_code'] = $_REQUEST['lang'];
			$formHash['delete_language'] = TRUE;
			$msgHash = array(
				'label' => 'Delete Language',
				'confirm_item' => 'Are you sure you want to remove the language "'.$languages[$_REQUEST['lang']]['native_name'].'"',
				'warning' => 'This will permanently remove the languages and all translations.',
			);
			$gBitSystem->confirmDialog( $formHash,$msgHash );
		}
	}
} elseif( isset($_REQUEST["save_language"] ) ) {
	if( $gBitLanguage->storeLanguage( $_REQUEST ) ) {
		$languages = $gBitLanguage->listLanguages();
		$smarty->assign( 'saveSuccess', tra( 'The language has been saved.' ) );
		$smarty->assign_by_ref( 'defaults', $_REQUEST );
	} else {
		$smarty->assign_by_ref( 'saveErrors', $gBitLanguage->mErrors );
		$smarty->assign_by_ref( 'defaults', $_REQUEST );
		$smarty->assign( 'editDescription', TRUE );
	}
} elseif( isset($_REQUEST["new_language"] ) ) {
	$smarty->assign( 'editDescription', TRUE );
} elseif( isset($_REQUEST["edit_language"] ) ) {
	if( !empty( $languages[$_REQUEST['lang']] ) ) {
		$smarty->assign_by_ref( 'defaults', $languages[$_REQUEST['lang']] );
	}
	$smarty->assign( 'editDescription', TRUE );
} elseif( !empty( $_REQUEST['save_translations'] ) ) {
	$editLang = $_REQUEST['lang'];
	$gBitLanguage->loadLanguage( $editLang );
	$saveSuccess = NULL;
	foreach( $_REQUEST['edit_trans'] as $sourceHash => $string ) {
		if( $string != $gBitLanguage->mStrings[$editLang][$sourceHash]['tran'] ) {
			$gBitLanguage->storeTranslationString( $editLang, $string, $sourceHash );
			// update string in template as well
			$tranStrings[$sourceHash]['tran'] = $string;
			// this has to be the source, otherwise the translated string will enter the db and be recognised as a used master
			$saveSuccess[] = $gBitLanguage->mStrings[$editLang][$sourceHash]['source'];
		}
	}
	$tranStrings = $gBitLanguage->getTranslationString( $sourceHash, $editLang );
	$smarty->assign_by_ref('tranStrings', $tranStrings );
	$smarty->assign( 'lang', $editLang );
	$smarty->assign( 'translate', TRUE );
	$smarty->assign( 'saveSuccess', $saveSuccess );
}

$gBitSystem->display( 'bitpackage:languages/edit_languages.tpl');

?>
