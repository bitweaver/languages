<?php
/**
 * @package languages
 * @subpackage functions
 * @version $Header$
 *
 * Copyright (c) 2005 bitweaver.org
 * Copyright (c) 2004-2005, Christian Fowler, et. al.
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 */

/**
 * Initialization
 */
require_once( '../kernel/setup_inc.php' );

$gBitSystem->verifyPermission( 'p_languages_edit' );

// Get available languages from DB
$languages = $gBitLanguage->listLanguages();
$gBitSmarty->assignByRef('languages', $languages);

if( !empty( $_REQUEST['all_trans'] ) ) {
	$gBitSmarty->assign( 'allTrans', 1 );
}

if( !empty( $_REQUEST['un_trans'] ) ) {
	$gBitSmarty->assign( 'unTrans', 1 );
}


if( !empty( $_REQUEST['clear_cache'] ) ) {
	$gBitLanguage->clearCache();
	$gBitSmarty->assign( 'saveSuccess', tra( 'System template and language cache have been cleared.' ) );
} elseif( !empty( $_REQUEST['translate'] ) ) {
	$editLang = $_REQUEST['lang'];
	$gBitSmarty->assign( 'lang', $editLang );
	$gBitSmarty->assign( 'translate', TRUE );
	if( !empty( $_REQUEST['hash'] ) ) {
		$tranStrings = $gBitLanguage->getTranslationString( $_REQUEST['hash'], $editLang );
		$gBitSmarty->assignByRef('tranStrings', $tranStrings );
	} else {
		// what strings do we want to display?
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
		$gBitLanguage->loadLanguage( $editLang );
		$tranStr = $gBitLanguage->mStrings[$editLang];
		foreach( $tranStr as $key => $tran ) {
			// display only the wanted strings and apply a textbox if the string is too long
			if( !empty( $_REQUEST['un_trans'] ) && empty( $tran['trans'] ) || empty( $_REQUEST['un_trans'] ) ) {
				if( preg_match( $pattern, $tran['source'] ) ) {
					$tranStrings[$key] = $tran;
					if( strlen( $tran['source'] ) > 70 ) {
						$tranStrings[$key]['textarea'] = TRUE;
					}
				}
			}
		}
		$gBitSmarty->assign( 'char', empty( $_REQUEST['char'] ) ? '' : $_REQUEST['char'] );
		$gBitSmarty->assignByRef( 'tranStrings', $tranStrings );
	}
} elseif( isset($_REQUEST["delete_language"] ) ) {
	if( $gBitUser->hasPermission( 'p_languages_delete' ) ) {
		if( isset( $_REQUEST["confirm"] ) ) {
			$gBitLanguage->expungeLanguage( $_REQUEST['delete_lang_code'] );
			unset( $languages[$_REQUEST['delete_lang_code']] );
		} else {
			$formHash['delete_lang_code'] = $_REQUEST['lang'];
			$formHash['delete_language'] = TRUE;
			$msgHash = array(
				'label' => tra('Delete Language'),
				'confirm_item' => tra('Are you sure you want to remove this language?') . ' ' . $languages[$_REQUEST['lang']]['native_name'],
				'warning' => tra('This will permanently remove the languages and all translations.'),
			);
			$gBitSystem->confirmDialog( $formHash,$msgHash );
		}
	}
} elseif( isset( $_REQUEST["save_language"] ) && $gBitUser->hasPermission( 'p_languages_create' ) ) {
	if( $gBitLanguage->storeLanguage( $_REQUEST ) ) {
		$languages = $gBitLanguage->listLanguages();
		$gBitSmarty->assign( 'saveSuccess', tra( 'The language has been saved.' ) );
		$gBitSmarty->assignByRef( 'defaults', $_REQUEST );
	} else {
		$gBitSmarty->assignByRef( 'saveErrors', $gBitLanguage->mErrors );
		$gBitSmarty->assignByRef( 'defaults', $_REQUEST );
		$gBitSmarty->assign( 'editDescription', TRUE );
	}
} elseif( isset($_REQUEST["new_language"] ) ) {
	$gBitSmarty->assign( 'editDescription', TRUE );
} elseif( isset($_REQUEST["edit_language"] ) ) {
	if( !empty( $languages[$_REQUEST['lang']] ) ) {
		$gBitSmarty->assignByRef( 'defaults', $languages[$_REQUEST['lang']] );
	}
	$gBitSmarty->assign( 'editDescription', TRUE );
}

$gBitSystem->display( 'bitpackage:languages/edit_languages.tpl', tra( 'Edit Languages' ) , array( 'display_mode' => 'edit' ));

?>
