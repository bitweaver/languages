<?php
global $gBitLanguage;
$sel_lang = !empty( $gBitUser->mInfo['bitlanguage'] ) ? $gBitUser->mInfo['bitlanguage'] : $gBitLanguage->mLanguage;
$gBitSmarty->assign( 'sel_lang', $sel_lang );
$languages = array();
$languages = $gBitLanguage->listLanguages( FALSE );
$gBitSmarty->assign_by_ref('languages', $languages);
?>
