<?php
class LibertyTranslations extends LibertyBase {
	function LibertyTranslations( $pContentId = NULL ) {
		$this->mContentId = $pContentId;
		LibertyBase::LibertyBase();
	}

	function getContentTranslations() {
		global $gBitSystem;
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
				// if we want to use a sequence
				//$translationId = $this->mDb->GenID( 'i18n_content_trans_id_seq' );

				// --- i can't work out why this isn't storing! driving me nuts ----
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
		// in theory, this shouldn't happen, but there might be a situation where we end up with 2 users translating the same page at the same time.

		// we have a from_id but no translation_id, this is a new entry in the translation map and we need both, the original and the new content_id entered
		if( @BitBase::verifyId( $pParamHash['translation_id'] ) ) {
			$pParamHash['translation_store']['translation_id']     = $pParamHash['translation_id'];
			$pParamHash['translation_store']['content_id']         = $pParamHash['content_id'];
			} elseif( @BitBase::verifyId( $pParamHash['from_id'] ) ) {
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

function translation_content_edit( &$pObject, &$pParamHash ) {
	global $gBitLanguage, $gBitSmarty, $gBitUser;
	$trans = new LibertyTranslations( $pObject->mContentId );
	$translationId = NULL;
	$translations = $trans->getContentTranslations();
	//vd($translations);
	foreach( $gBitLanguage->mLanguageList as $lang_code => $language ) {
		$translationsList[$lang_code] = $language;
		if( !empty( $translations[$lang_code]['content_id'] ) ) {
			$translationsList[$lang_code]['content_id'] = $translations[$lang_code]['content_id'];
			$translationsList[$lang_code]['title'] = $translations[$lang_code]['title'];
			$translationId = $translations[$lang_code]['translation_id'];
		}
	}
	//vd($translationsList);
	//vd($translationId);
	$gBitSmarty->assign( 'translationsList', $translationsList );
	$gBitSmarty->assign( 'translationId', $translationId );

	if( @BitBase::verifyId( $_REQUEST['i18n']['from_id'] ) ) {
		// load the content we're translating from
		$transObject = $trans->getLibertyObject( $_REQUEST['i18n']['from_id'] );
		$gBitSmarty->assign_by_ref( "translateFrom", $transObject );
	}
}

// store the content
function translation_content_store( $pObject, $pParamHash ) {
	// if we are creating this content and we have a from_id, we know that we're translating a page
	// i think content_id isn't set when content is created
	if( !@BitBase::verifyId( $pObject->mInfo['content_id'] ) && @BitBase::verifyId( $_REQUEST['i18n']['from_id'] ) ) {
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
