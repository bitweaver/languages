<?php
/**
 * @package languages
 * @version $Header: /cvsroot/bitweaver/_bit_languages/LibertyTranslations.php,v 1.13 2008/09/18 03:57:44 spiderr Exp $
 *
 * @author ?
 */

/**
 * @package languages
 */
 class LibertyTranslations extends LibertyBase {
	function LibertyTranslations( $pContentId = NULL ) {
		$this->mContentId = $pContentId;
		LibertyBase::LibertyBase();
	}

	function getContentTranslations() {
		global $gBitSystem, $gBitLanguage;
		$ret = array();
		if( @BitBase::verifyId( $this->mContentId ) ) {
			$translationId = $this->mDb->getOne( "SELECT `translation_id` FROM `".BIT_DB_PREFIX."i18n_content_trans_map` WHERE `content_id`=?", array( $this->mContentId ) );
			if( @BitBase::verifyId( $translationId ) ) {
				$query = "SELECT lc.`content_id`, lc.`title`, lc.`lang_code`, ictm.`translation_id`
					FROM `".BIT_DB_PREFIX."i18n_content_trans_map` ictm
						INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id`=ictm.`content_id` )
					WHERE ictm.`translation_id`=?";
				$result = $this->mDb->query( $query, array( $translationId ) );
				while( $aux = $result->fetchRow() ) {
					// default to site language
					if( empty( $aux['lang_code'] )) {
						$aux['lang_code'] = $gBitLanguage->mLanguage;
					}
					$ret[$aux['lang_code']] = $aux;
				}
			}
		}
		return $ret;
	}

	function storeTranslation( $pParamHash ) {
		if( $this->verify( $pParamHash ) ) {
			$table = BIT_DB_PREFIX."i18n_content_trans_map";
			if( !@BitBase::verifyId( $pParamHash['translation_store']['translation_id'] ) && is_array( $pParamHash['translation_store'] ) ) {
				foreach( $pParamHash['translation_store'] as $store ) {
					$result = $this->mDb->associateInsert( $table, $store );
				}
			} else {
				$result = $this->mDb->associateInsert( $table, $pParamHash['translation_store'] );
			}
		}
	}

	function verify( &$pParamHash ) {
		$i = 0;

		// make sure we don't have a translation_id for this content yet
		if( @BitBase::verifyId( $pParamHash['from_id'] ) ) {
			$pParamHash['translation_id'] = $this->mDb->getOne( "SELECT `translation_id` FROM `".BIT_DB_PREFIX."i18n_content_trans_map` WHERE `content_id`=?", array( $pParamHash['from_id'] ) );
		}

		// if we have this page in this translation, we should inform the user somehow.
		// in theory, this shouldn't happen, but there might be a situation where we end up with 2 users translating the same page at the same time. (is this true?)

		// if we have a translation_id, we add this content to the same group of translations
		if( @BitBase::verifyId( $pParamHash['translation_id'] ) ) {
			$pParamHash['translation_store']['translation_id']     = $pParamHash['translation_id'];
			$pParamHash['translation_store']['content_id']         = $pParamHash['content_id'];
		} elseif( @BitBase::verifyId( $pParamHash['from_id'] ) ) {
			// we have a from_id but no translation_id, this is a new entry in the translation map and we need both, the original and the new content_id entered
			// we can simply use the from_id as the translation_id
			$pParamHash['translation_store'][$i]['translation_id'] = $pParamHash['from_id'];
			$pParamHash['translation_store'][$i]['content_id']     = $pParamHash['from_id'];
			$i++;
			$pParamHash['translation_store'][$i]['translation_id'] = $pParamHash['from_id'];
			$pParamHash['translation_store'][$i]['content_id']     = $pParamHash['content_id'];
		}
		return( count( $this->mErrors ) == 0 );
	}

	function expunge() {
		if( @BitBase::verifyId( $this->mContentId ) ) {
			$result = $this->mDb->query( "DELETE FROM `".BIT_DB_PREFIX."i18n_content_trans_map` WHERE `content_id`=?", $this->mContentId );
		}
	}
}

// ================== service functions ==================

function translation_content_display( &$pObject ) {
	global $gBitSmarty, $gBitLanguage;
	$trans = new LibertyTranslations( $pObject->mContentId );
	$translations = $trans->getContentTranslations();
	// merge this information that we can display the appropriate flags
	if( count( $translations ) > 1 ) {
		foreach( $translations as $key => $trans ) {
			$translations[$key] = array_merge( $gBitLanguage->mLanguageList[$trans['lang_code']], $trans );
		}
		$gBitSmarty->assign( 'i18nTranslations', $translations );
	}
}

function translation_content_edit( &$pObject, &$pParamHash ) {
	global $gBitLanguage, $gBitSmarty, $gBitUser;
	$trans = new LibertyTranslations( $pObject->mContentId );
	$translationId = NULL;
	$translations = $trans->getContentTranslations();
	foreach( $gBitLanguage->mLanguageList as $lang_code => $language ) {
		$translationsList[$lang_code] = $language;
		if( !empty( $translations[$lang_code]['content_id'] ) ) {
			$translationsList[$lang_code]['content_id'] = $translations[$lang_code]['content_id'];
			$translationsList[$lang_code]['title'] = $translations[$lang_code]['title'];
			$translationId = $translations[$lang_code]['translation_id'];
		}
	}
	$gBitSmarty->assign( 'translationsList', $translationsList );
	$gBitSmarty->assign( 'translationId', $translationId );

	if( @BitBase::verifyId( $_REQUEST['i18n']['from_id'] ) ) {
		// load the content we're translating from
		$transObject = $trans->getLibertyObject( $_REQUEST['i18n']['from_id'] );
		$gBitSmarty->assign_by_ref( "translateFrom", $transObject );

		// attempt google translation
		if( !empty( $_REQUEST['i18n']['google'] ) && !empty( $transObject->mInfo['data'] )) {
			// temporarily replace \n with a string
			$nl = 'nlnlnlnlnl';
			// initiate some variables
			$transObject->mInfo['google_guess'] = '';
			// we need to split the strings into small chunks due to url length limitations
			$strings = str_split( $transObject->mInfo['data'], 1500 );
			foreach( $strings as $string ) {
				$requestUrl = "http://translate.google.com/translate_t?ie=UTF-8&oe=UTF-8&text=".urlencode( preg_replace( '/[\n]/', $nl, $string ))."&langpair=en|{$_REQUEST['i18n']['lang_code']}";
				if( $handle = fopen( $requestUrl, "r" )) {
					$data = '';
					while( !feof( $handle )) {
						$data .= fread( $handle, 8192 );
					}
					fclose( $handle );
					preg_match_all( "!<div id=result_box[^>]*>([^<]*)</div>.*!", $data, $matches );
					if( isset( $matches[1][0] )) {
						$transObject->mInfo['google_guess'] .= preg_replace( "/".preg_quote( $nl, "/" )."/", "\n", $matches[1][0] );
					}
				}
			}
die;
		}
	}
}

// store the content
function translation_content_store( $pObject, $pParamHash ) {
	// if we are creating this content and we have a from_id, we know that we're translating a page
	// mInfo['content_id'] isn't set when content is created
	if( empty( $pObject->mInfo['content_id'] ) && @BitBase::verifyId( $_REQUEST['i18n']['from_id'] ) ) {
		$trans = new LibertyTranslations();
		$storeHash = $_REQUEST['i18n'];
		$storeHash['content_id'] = $pParamHash['content_id'];
		if( !$trans->storeTranslation( $storeHash ) ) {
			// error
		}
	}
}

function translation_content_exunge( $pObject, $pParamHash ) {
	$trans = new LibertyTranslations( $pObject->mContentId );
	$trans->expunge();
}
?>
