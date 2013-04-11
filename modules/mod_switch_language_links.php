<?php
/**
 * Create a language link
 *
 * @package languages
 * @subpackage modules
 * @version $Header$
 */ 
global $gBitLanguage;
$sel_lang = !empty( $gBitUser->mInfo['bitlanguage'] ) ? $gBitUser->mInfo['bitlanguage'] : $gBitLanguage->mLanguage;
$_template->tpl_vars['sel_lang'] = new Smarty_variable( $sel_lang );
$languages = array();
$languages = $gBitLanguage->listLanguages( FALSE );
$gBitSmarty->assign_by_ref('languages', $languages);
?>
