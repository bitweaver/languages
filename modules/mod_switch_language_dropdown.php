<?php
/**
 * Create a list of languages
 *
 * @package languages
 * @subpackage modules
 * @version $Header: /cvsroot/bitweaver/_bit_languages/modules/mod_switch_language_dropdown.php,v 1.2.2.2 2005/08/03 19:07:29 lsces Exp $
 */ 
global $gBitLanguage, $gBitUser;
//vd($_COOKIE);
//vd($_SESSION);
$sel_lang = !empty( $gBitUser->mInfo['bitlanguage'] ) ? $gBitUser->mInfo['bitlanguage'] : $gBitLanguage->mLanguage;
$gBitSmarty->assign( 'sel_lang', $sel_lang );
$languages = array();
$languages = $gBitLanguage->listLanguages( FALSE );
$gBitSmarty->assign_by_ref('languages', $languages);
?>
