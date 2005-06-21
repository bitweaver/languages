<?php
global $gBitLanguage;
$sel_lang = !empty( $gBitUser->mInfo['bitlanguage'] ) ? $gBitUser->mInfo['bitlanguage'] : $gBitLanguage->mLanguage;
$smarty->assign( 'sel_lang', $sel_lang );
$languages = array();
$languages = $gBitLanguage->listLanguages( FALSE );
$smarty->assign_by_ref('languages', $languages);
?>
