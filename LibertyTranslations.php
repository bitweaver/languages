<?
class LibertyTranslations extends BitBase {
	function LibertyTranslations( $pContentId = NULL ) {
		$this->mContentId = $pContentId;
		LibertyBase::LibertyBase();
	}

	function getContentTranslations() {
		global $gBitSystem;
		$ret = array();
		if( @BitBase::verifyId( $this->mContentId ) ) {
			$query = "SELECT lc.`content_id`, lc.`title`, lc.`lang_code`
				FROM `".BIT_DB_PREFIX."liberty_content` lc
				LEFT OUTER JOIN `".BIT_DB_PREFIX."i18n_content_translation_map` ictm ON( lc.`content_id`=ictm.`content_id` )
				WHERE ictm.`content_id`=?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );
			while( $aux = $result->fetchRow() ) {
				if( !empty( $contentTypes[$aux['content_type_guid']] ) ) {
					$ret[$aux['lang_code']] = $aux;
				}
			}
		}
		return $ret;
	}
}

// ================== service functions ==================

// we should force the preview stuff to preview the original code
function translation_content_edit( &$pObject, &$pParamHash ) {
	global $gBitLanguage, $gBitSmarty, $gBitUser;
	$trans = new LibertyTranslations( $pObject->mContentId );
	$translations = $trans->getContentTranslations();
	foreach( $gBitLanguage->mLanguageList as $lang_code => $language ) {
		if( !empty( $translations[$lang_code] ) ) {
			$translationsList['from'][$lang_code] = $language['translated_name'].": ".$translations[$lang_code]['title'];
			$translationsList['to'][tra( 'Translated' )][$lang_code] = $language['translated_name'].": ".$translations[$lang_code]['title'];
		} else {
			$translationsList['to'][tra( 'Untranslated' )][$lang_code] = $language['translated_name'];
		}
	}
	$gBitSmarty->assign( 'translationsList', $translationsList );
}

// store the content
function translation_content_store() {
	// we need a parameter on store that we can insert something in liberty_content.lang_code
}
?>
