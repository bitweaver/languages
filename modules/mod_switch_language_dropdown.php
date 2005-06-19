<?php
// setup has already set the $language variable
//Create a list of languages
global $gBitLanguage, $gBitUser;
//vd($_COOKIE);
//vd($_SESSION);
$sel_lang = !empty( $gBitUser->mInfo['tikilanguage'] ) ? $gBitUser->mInfo['tikilanguage'] : $gBitLanguage->mLanguage;
$smarty->assign( 'sel_lang', $sel_lang );
$languages = array();
$languages = $gBitLanguage->listLanguages( FALSE );
$smarty->assign_by_ref('languages', $languages);
?>
