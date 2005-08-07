<?php
/**
 * Create a language link
 *
 * @package languages
 * @subpackage modules
 * @version $Header: /cvsroot/bitweaver/_bit_languages/modules/mod_switch_language_links.php,v 1.6 2006/01/10 21:13:02 squareing Exp $
 */ 
global $gBitLanguage;
$sel_lang = !empty( $gBitUser->mInfo['bitlanguage'] ) ? $gBitUser->mInfo['bitlanguage'] : $gBitLanguage->mLanguage;
$gBitSmarty->assign( 'sel_lang', $sel_lang );
$languages = array();
$languages = $gBitLanguage->listLanguages( FALSE );
$gBitSmarty->assign_by_ref('languages', $languages);
?>
