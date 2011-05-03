<?php
/**
 * @package languages
 * @subpackage functions
 * @version $Header$
 */

// Copyright (c) 2005, bitweaver.org
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
/**
 * Initialization
 */
require_once( '../kernel/setup_inc.php' );

$gBitSystem->verifyPermission( 'p_languages_edit_master' );

$languages = $gBitLanguage->listLanguages();
$gBitSmarty->assign_by_ref( 'languages', $languages );
$feedback = $masterMsg = array();

if( !empty( $_REQUEST['source_hash'] ) && !is_array( $_REQUEST['source_hash'] ) ) {
	$_REQUEST['source_hash'] = array( $_REQUEST['source_hash'] );
}

if( !empty( $_REQUEST['delete_master'] ) && !empty( $_REQUEST['source_hash'] ) ) {
	if( empty( $_REQUEST['confirm'] ) ) {
		$gBitSystem->setBrowserTitle( tra( 'Confirm Delete' ) );
		$formHash['delete_master'] = TRUE;
		$msgHash = array(
			'label' => tra( 'Delete Master Strings' ),
			'warning' => tra( 'This will remove the language master string. If you are tracking translations and the string is still used, it will be inserted again, however, any translations associated with it will be lost.' ),
			'confirm_item' => tra( "The following Master Strings will be removed" ).":",
		);
		foreach( $_REQUEST['source_hash'] as $source_hash ) {
			$gBitLanguage->loadMasterStrings( $source_hash );
			$formHash['input'][] = '<input type="hidden" name="source_hash[]" value="'.$source_hash.'"/>'.htmlentities( $gBitLanguage->mStrings['master'][$source_hash]['source'] );
		}
		$gBitSystem->confirmDialog( $formHash, $msgHash );
	} else {
		foreach( $_REQUEST['source_hash'] as $source_hash ) {
			if( $gBitLanguage->expungeMasterString( $source_hash ) ) {
				$success = TRUE;
			} else {
				$error = TRUE;
			}
		}

		if( !empty( $error ) ) {
			$feedback['error'] = 'At least one of the master strings could not be deleted.';
		} elseif( !empty( $success ) ) {
			$feedback['success'] = 'The requested master strings were successfully deleted.';
		}
	}
} elseif( !empty( $_REQUEST['save_translations'] ) ) {
	foreach( $_REQUEST['edit_trans'] as $sourceHash => $sources ) {
		foreach( $sources as $langCode => $string ) {
			$tranStrings[$sourceHash] = $gBitLanguage->getTranslatedStrings( $sourceHash );
			// store if (We had a string and it is now empty) or ( we have a new string and it is different from before)
			if( (empty( $string ) && !empty( $tranStrings[$sourceHash][$langCode] ))
				|| (!empty( $string ) && (empty( $tranStrings[$sourceHash][$langCode] ) || $string != $tranStrings[$sourceHash][$langCode]['trans']) ) ) {
				$gBitLanguage->storeTranslationString( $langCode, $string, $sourceHash );
			}
		}
		$gBitLanguage->loadMasterStrings( $sourceHash );
		if( !empty( $_REQUEST['edit_master'][$sourceHash] ) ) {
			$newSourceHash = $gBitLanguage->getSourceHash( $_REQUEST['edit_master'][$sourceHash] );
			$gBitLanguage->loadMasterStrings();
			if( $newSourceHash != $sourceHash ) {
				if( $gBitLanguage->storeMasterString( array( 'source_hash' => $sourceHash, 'new_source' => $_REQUEST['edit_master'][$sourceHash] ) ) ) {
					unset( $_REQUEST['source_hash'] );
					$_REQUEST['source_hash'][] = $newSourceHash;
					$tranStrings[$newSourceHash] = $gBitLanguage->getTranslatedStrings( $newSourceHash );
					$masterMsg['success'][] = 'Master translation string has been updated';
				} else {
					$masterMsg['error'][] = $gBitLanguage->mErrors['master'];
				}
			}
		}
	}
	$masterMsg['success'][] = 'Translation strings have been updated';
} elseif( !empty( $_REQUEST['find'] ) && !empty( $_REQUEST['search'] ) ) {
	$gBitSmarty->assign_by_ref( 'masterStrings', $gBitLanguage->searchMasterStrings( $_REQUEST['find'] ) );
} else {
	$gBitLanguage->loadMasterStrings(
		NULL,
		( !empty( $_REQUEST['filter'] ) ? $_REQUEST['filter'] : NULL ),
		( !empty( $_REQUEST['filter_lang'] ) ? $_REQUEST['filter_lang'] : NULL )
	);

	// work out what strings to display
	if( empty( $_REQUEST['char'] )) {
		$pattern = "/^a/i";
	} elseif ( $_REQUEST['char'] == '0-9' ) {
		$pattern = "/^\d/";
	} elseif ( $_REQUEST['char'] == '+' ) {
		$pattern = "/^[^a-zA-Z0-9]/";
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


if( !empty( $_REQUEST['source_hash'] ) && empty( $_REQUEST['cancel'] ) ) {
	foreach( $_REQUEST['source_hash'] as $reqSourceHash ) {
		$gBitLanguage->loadMasterStrings( $reqSourceHash );
		if( strlen( $gBitLanguage->mStrings['master'][$reqSourceHash]['source'] ) > 100 ) {
			$gBitLanguage->mStrings['master'][$reqSourceHash]['textarea'] = TRUE;
		}
		$translate[$reqSourceHash] = $gBitLanguage->getTranslatedStrings( $_REQUEST['source_hash'] );
	}
	$gBitSmarty->assign_by_ref( 'masterStrings', $gBitLanguage->mStrings['master'] );
	$gBitSmarty->assign_by_ref( 'tranStrings', $translate );
	$gBitSmarty->assign( 'sources', $_REQUEST['source_hash'] );
}

// Display the template
$gBitSmarty->assign( 'masterMsg', $masterMsg );
$gBitSmarty->assign( 'feedback', $feedback );
$gBitSystem->display( 'bitpackage:languages/language_master_strings.tpl', 'Edit Master Strings' , array( 'display_mode' => 'display' ));
?>
