<?php
/**
 * @package languages
 * @version $Header: /cvsroot/bitweaver/_bit_languages/BitLanguage.php,v 1.3.2.4 2005/08/03 19:07:28 lsces Exp $
 *
 * Copyright (c) 2005 bitweaver.org
 * Copyright (c) 2004-2005, Christian Fowler, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 * @author spider <spider@steelsun.com>
 */

/**
 * @package languages
 */
class BitLanguage extends BitBase {
	// list of available (non-disabled) languages
	var $mLanguageList;

	var $mLanguage;

	function BitLanguage () {
		BitBase::BitBase();
		global $gBitSystem;

		# TODO - put '@' here due to beta1->beta2 upgrades - wolff_borg
		$this->mLanguageList = @$this->listLanguages();

		if (isset($_SESSION['bitlanguage'])) {
			// users not logged that change the preference
			$this->mLanguage = $_SESSION['bitlanguage'];
		} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && $gBitSystem->isFeatureActive( 'browser_languages' )) {
			// Get supported languages
			if( $browserLangs = split( ',', preg_replace('/;q=[0-9.]+/', '', $_SERVER['HTTP_ACCEPT_LANGUAGE']) ) ) {
				foreach( $browserLangs as $bl ) {
					if( !empty( $this->mLanguageList[$bl] ) ) {
						$this->setLanguage( $bl );
						break;
					} elseif( strpos( $bl, '-' ) )  {
						$baseLang = substr( $bl, 0, 2 );
						if( !empty( $this->mLanguageList[$baseLang] ) ) {
							$this->setLanguage( $baseLang );
							break;
						}
					}
				}
			}
		}
		if( empty( $this->mLanguage ) ) {
			$this->mLanguage = $gBitSystem->getPreference('bitlanguage', 'en');
		}
	}

	function getLanguage() {
		return( $this->mLanguage );
	}

	function setLanguage( $pLangCode ) {
		$this->mLanguage = $pLangCode;
	}

	function verifyLanguage( &$pParamHash ) {
		$langs = $this->listLanguages();
		if( empty( $pParamHash['lang_code'] ) || strlen( $pParamHash['lang_code'] ) < 2 ) {
			$this->mErrors['lang_code'] = tra( 'The language code must be at least 2 characters.' );
		} elseif( !empty( $langs[$pParamHash['lang_code']] ) && empty( $pParamHash['update_lang_code'] ) ) {
			$this->mErrors['lang_code'] = tra( 'This language code is already used by ' ).$langs[$pParamHash['lang_code']]['native_name'];
		}
		if( empty( $pParamHash['native_name'] ) ) {
			$this->mErrors['native_name'] = 'You must provide the native language name';
		}
		if( !isset( $pParamHash['english_name'] ) ) {
			$pParamHash['english_name'] = NULL;
		}
		return( count( $this->mErrors ) === 0 );
	}

	function storeLanguage( $pParamHash ) {
		if( $this->verifyLanguage( $pParamHash ) ) {
			if( empty( $pParamHash['update_lang_code'] ) ) {
				$query = "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_languages` (`lang_code`,`english_name`,`native_name`) values (?,?,?)";
				$result = $this->query( $query, array( $pParamHash['lang_code'], $pParamHash['english_name'], $pParamHash['native_name'] ) );
			} else {
				$query = "UPDATE `".BIT_DB_PREFIX."tiki_i18n_languages` SET `lang_code`=?, `english_name`=?, `native_name`=? WHERE `lang_code`=?";
				$result = $this->query( $query, array( $pParamHash['lang_code'], $pParamHash['english_name'], $pParamHash['native_name'], $pParamHash['update_lang_code'] ) );
			}
		}
		return( count( $this->mErrors ) == 0 );
	}

	function expungeLanguage( $pLangCode ) {
		if( !empty( $pLangCode ) ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."tiki_i18n_strings` WHERE `lang_code`=?";
			$result = $this->query( $query, array( $pLangCode ) );
			$query = "DELETE FROM `".BIT_DB_PREFIX."tiki_i18n_languages` WHERE `lang_code`=?";
			$result = $this->query( $query, array( $pLangCode ) );
			$this->mDb->CompleteTrans();
		}
	}

	function expungeMasterString( $pSourceHash ) {
		if( !empty( $pSourceHash ) ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."tiki_i18n_strings` WHERE `source_hash`=?";
			$result = $this->query( $query, array( $pSourceHash ) );
			$query = "DELETE FROM `".BIT_DB_PREFIX."tiki_i18n_masters` WHERE `source_hash`=?";
			$result = $this->query( $query, array( $pSourceHash ) );
			$this->mDb->CompleteTrans();
			return TRUE;
		}
	}

	function getImportedLanguages() {
		$ret = array();
		if( $rs = $this->query( 'SELECT DISTINCT(`lang_code`) AS `lang_code` FROM `'.BIT_DB_PREFIX.'tiki_i18n_strings`' ) ) {
			$res = array();
			while( !$rs->EOF ) {
				$res[] = $rs->fields['lang_code'];
				$rs->MoveNext();
			}
			$langs = $this->listLanguages();
			foreach( $res as $langCode ) {
				$ret[$langCode] = $langs[$langCode];
			}
		}
		return $ret;
	}

	function listLanguages( $pListDisabled=TRUE ) {
		$whereSql = '';
		if( !$pListDisabled ) {
			$whereSql = " WHERE `is_disabled` IS NULL ";
		}
		$ret = $this->GetAssoc( "SELECT til.`lang_code` AS `hash_key`, til.* FROM `".BIT_DB_PREFIX."tiki_i18n_languages` til $whereSql ORDER BY til.`lang_code`" );
		if( !empty( $ret ) ) {
			foreach( array_keys( $ret ) as $langCode ) {
				$ret[$langCode]['translated_name'] = $this->translate( $ret[$langCode]['english_name'] );
				$ret[$langCode]['full_name'] = $ret[$langCode]['native_name'].' ('.$this->translate( $ret[$langCode]['english_name'] ).', '.$langCode.')';
			}
		} else {
			$ret = array();
		}
		return $ret;
	}


	function verifyMastersLoaded() {
		// see if there is anything in the table
		$query = "SELECT COUNT(`source_hash`) FROM `".BIT_DB_PREFIX."tiki_i18n_masters`";
		$count = $this->getOne($query);
		if( empty( $count ) ) {
			$this->importMasterStrings();
		}
	}

	function masterStringExists( $pSourceHash ) {
		return( !empty( $this->mStrings['master'][$pSourceHash] ) );
	}

	function searchMasterStrings( $pQuerySource ) {
		$query = "SELECT tim.`source_hash` AS `hash_key`, `source`, `package`, tim.`source_hash`
				  FROM `".BIT_DB_PREFIX."tiki_i18n_masters` tim
				  WHERE UPPER( `source` ) LIKE ? ORDER BY tim.`source`";
		return( $this->GetAssoc( $query, array( '%'.strtoupper( $pQuerySource ).'%' ) ) );
	}

	function loadMasterStrings( $pSourceHash = NULL ) {
		$this->verifyMastersLoaded();
		$bindVars = NULL;
		$whereSql = NULL;
		if( $pSourceHash ) {
			$whereSql = ' WHERE `source_hash`=? ';
			$bindVars = array( $pSourceHash );
		}
		$query = "SELECT tim.`source_hash` AS `hash_key`, `source`, `package`, tim.`source_hash`
				FROM `".BIT_DB_PREFIX."tiki_i18n_masters` tim
				$whereSql ORDER BY tim.`source`";
		$this->mStrings['master'] = $this->GetAssoc( $query, $bindVars );
	}


	function storeMasterString( $pParamHash ) {
		global $gBitSmarty;
		if( !empty( $gBitSmarty->mCompileRsrc ) ) {
			list($type, $location) = split( ':', $gBitSmarty->mCompileRsrc );
			list($package, $file) = split( '/', $location );
		} else {
			$package = NULL;
		}

		$this->mDb->mDb->StartTrans();
		$newSourceHash = $this->getSourceHash( $pParamHash['new_source'] );
		if( $this->masterStringExists( $newSourceHash ) ) {
			$oldCount = $this->getOne( "SELECT COUNT(`source_hash`) FROM `".BIT_DB_PREFIX."tiki_i18n_strings` WHERE `source_hash`=?",  array( $pParamHash['source_hash'] ) );
			$newCount = $this->getOne( "SELECT COUNT(`source_hash`) FROM `".BIT_DB_PREFIX."tiki_i18n_strings` WHERE `source_hash`=?",  array( $newSourceHash ) );
			if( $newCount ) {
				$this->mErrors['master'] = 'There was a conflict updating the master string. The new string already has translations entered.';
			} else {
				// we have updated a master string to an existing master string
				$query = "UPDATE `".BIT_DB_PREFIX."tiki_i18n_strings` SET `source_hash`=?, `last_modified`=? WHERE `source_hash`=?";
				$trans = $this->query($query, array( $newSourceHash, time(), $pParamHash['source_hash'] ) );
				$query = "DELETE FROM `".BIT_DB_PREFIX."tiki_i18n_masters` WHERE `source_hash`=?";
				$trans = $this->query($query, array( $pParamHash['source_hash'] ) );
			}
		} elseif( $this->masterStringExists( $pParamHash['source_hash'] ) ) {
			$query = "UPDATE `".BIT_DB_PREFIX."tiki_i18n_strings` SET `source_hash`=?, `last_modified`=? WHERE `source_hash`=?";
			$trans = $this->query($query, array( $newSourceHash, time(), $pParamHash['source_hash'] ) );
			$query = "UPDATE `".BIT_DB_PREFIX."tiki_i18n_masters` SET `source_hash`=?, `source`=?, `created`=? WHERE `source_hash`=?";
			$trans = $this->query($query, array( $newSourceHash, $pParamHash['new_source'], time(), $pParamHash['source_hash'] ) );
			unset( $this->mStrings[$pParamHash['source_hash']] );
		} else {
			$query = "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_masters` (`source`,`source_hash`, `created`, `package`) VALUES (?,?,?,?)";
			$trans = $this->query($query, array( $pParamHash['new_source'], $this->getSourceHash( $pParamHash['new_source'] ), time(), $package ) );
		}
		if( count( $this->mErrors ) == 0 ) {
			$this->mStrings['master'][$newSourceHash]['source'] = $pParamHash['new_source'];
			$this->mStrings['master'][$newSourceHash]['source_hash'] = $newSourceHash;
		}
		$this->mDb->mDb->CompleteTrans();
		return( count( $this->mErrors ) == 0 );
	}


	function importMasterStrings( $pOverwrite=FALSE ) {
		global $lang;
		$count = 0;
		include_once ( LANGUAGES_PKG_PATH.'lang/masters.php' );

		foreach( $lang as $key=>$val ) {
			$sourceHash = $this->getSourceHash( $key );
			$query = "SELECT * FROM `".BIT_DB_PREFIX."tiki_i18n_masters` WHERE `source_hash`=?";
			$trans = $this->GetAssoc($query, array( $sourceHash ) );
			if( $trans ) {
				if( $pOverwrite ) {
					$query = "UPDATE `".BIT_DB_PREFIX."tiki_i18n_masters` SET `source`=?, `created`=? WHERE `source_hash`=?";
					$trans = $this->query($query, array( $val, time(), $sourceHash ) );
					$count++;
				}
			} else {
				$this->storeMasterString( array( 'new_source' => $val, 'source_hash' => $sourceHash ) );
				$count++;
			}
		}
		return( $count );
	}

	function storeTranslationString( $pLangCode, $pString, $pSourceHash ) {
		$query = "DELETE FROM `".BIT_DB_PREFIX."tiki_i18n_strings` WHERE `source_hash`=? AND `lang_code`=?";
		$result = $this->query( $query, array($pSourceHash, $pLangCode) );

		if( !empty( $pString ) ) {
			$query = "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_strings` (`lang_code`,`tran`,`source_hash`, `last_modified`) values (?,?,?,?)";
			$result = $this->query( $query, array( $pLangCode, $pString, $pSourceHash, time() ) );
		}

		$this->mStrings[$pLangCode][$pSourceHash]['tran'] = $pString;
	}

	function getTranslatedStrings( $pSourceHash ) {
		$query = "SELECT tis.`lang_code` AS `hash_key`, `tran`, tis.`source_hash`, tis.`lang_code`
				  FROM `".BIT_DB_PREFIX."tiki_i18n_strings` tis
					WHERE tis.`source_hash`=?
				  ORDER BY tis.`lang_code`";
		return( $this->GetAssoc($query, array( $pSourceHash ) ) );
	}

	function getTranslationString( $pSourceHash, $pLangCode ) {
		$this->verifyTranslationLoaded( $pLangCode );
		$query = "SELECT tim.`source_hash` AS `hash_key`, `source`, `tran`, tim.`source_hash`
				  FROM `".BIT_DB_PREFIX."tiki_i18n_masters` tim
				  	LEFT OUTER JOIN `".BIT_DB_PREFIX."tiki_i18n_strings` tis ON( tis.`source_hash`=tim.`source_hash` AND tis.`lang_code`=? )
				  WHERE tim.`source_hash`=?
				  ORDER BY tim.`source`";
		return( $this->GetAssoc($query, array( $pLangCode, $pSourceHash ) ) );
	}

	function isImportFileAvailable( $pLangCode ) {
		return( file_exists( LANGUAGES_PKG_PATH.'lang/'.$pLangCode.'/language.php' ) );
	}


	function importTranslationStrings( $pLangCode, $pOverwrite=FALSE, $pTable='tiki_i18n_strings`' ) {
		$count = 0;
		if( $this->isImportFileAvailable( $pLangCode ) ) {
			$this->loadMasterStrings();
			include_once ( LANGUAGES_PKG_PATH.'lang/'.$pLangCode.'/language.php' );
			foreach( $lang as $key=>$val ) {
				$hashKey = $this->getSourceHash( $key );
				if( !$this->masterStringExists( $hashKey ) ) {
					$this->storeMasterString( array( 'source_hash' => $hashKey, 'new_source' => $key ) );
				}
				$trans = $this->lookupTranslation( $key, $pLangCode, FALSE );
				if( $trans ) {
					if( $pOverwrite ) {
						$query = "UPDATE `".BIT_DB_PREFIX."tiki_i18n_strings` SET `tran`=?, `last_modified`=? WHERE `source_hash`=? AND `lang_code`=?";
						$trans = $this->query($query, array( $val, time(), $hashKey, $pLangCode ) );
						$count++;
					}
				} else {
					$query = "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_strings` (`tran`,`source_hash`,`lang_code`,`last_modified`) VALUES (?,?,?,?)";
					$trans = $this->query($query, array( $val, $hashKey, $pLangCode, time() ) );
					$count++;
				}
			}
		}
		return( $count );
	}

	function verifyTranslationLoaded( $pLangCode ) {
		// see if there is anything in the table
		$query = "SELECT COUNT(`source_hash`) FROM `".BIT_DB_PREFIX."tiki_i18n_strings` tis WHERE tis.`lang_code`=?";
		$count = $this->getOne($query, array( $pLangCode ) );
		if( empty( $count ) ) {
			$this->importTranslationStrings( $pLangCode );
		}
	}

	function loadLanguage( $pLangCode ) {
		$this->verifyMastersLoaded();
		$this->verifyTranslationLoaded( $pLangCode );
		$query = "SELECT tim.`source_hash` AS `hash_key`, `source`, `tran`, tim.`source_hash`, tivm.`version`
				  FROM `".BIT_DB_PREFIX."tiki_i18n_masters` tim
				  	LEFT OUTER JOIN `".BIT_DB_PREFIX."tiki_i18n_strings` tis ON( tis.`source_hash`=tim.`source_hash` AND tis.`lang_code`=? )
				  	LEFT OUTER JOIN `".BIT_DB_PREFIX."tiki_i18n_version_map` tivm ON( tim.`source_hash`=tivm.`source_hash` )
				  ORDER BY tim.`source`";
		$this->mStrings[$pLangCode] = $this->GetAssoc($query,array( $pLangCode ) );
	}

	function translate( $pString ) {
		$sourceHash = $this->getSourceHash( $pString );
		$cacheFile = TEMP_PKG_PATH."lang/".$this->mLanguage."/".$sourceHash;
		if( $this->mLanguage == 'en' ) {
			$ret = $pString;
		} elseif( !empty( $this->mStrings[$this->mLanguage][$sourceHash] ) ) {
			$ret = $this->mStrings[$this->mLanguage][$sourceHash];
		} elseif( file_exists( $cacheFile ) ) {
			$ret = file_get_contents( $cacheFile );
		} else {
			if( empty( $this->mStrings[$this->mLanguage] ) ) {
				$this->verifyTranslationLoaded( $this->mLanguage );
			}
			$tran = $this->lookupTranslation( $pString, $this->mLanguage );
			if( empty( $tran ) ) {
				// lookup failed. let's snag the first part of the langCode if it is a dialect (e.g. pt-br )
				$dialect = strpos( $this->mLanguage, '-' );
				if( $dialect ) {
					$tran = $this->lookupTranslation( $pString, substr( $this->mLanguage, 0, $dialect ) );
				}
				if( empty( $tran ) ) {
					$tran = $pString;
				}
			}
			// write out the cache - translated or not so we don't keep hitting the database
			mkdir_p( dirname( $cacheFile ) );
			$fp = fopen( $cacheFile, 'w' );
			fwrite( $fp, $tran );
			fclose( $fp );
			$this->mStrings[$this->mLanguage][$sourceHash] = $tran;
			$ret = $tran;
		}
		return $ret;
	}

	function lookupTranslation( $pString, $pLangCode, $pOverrideUsage = TRUE ) {
		global $gBitSystem;
		$sourceHash = $this->getSourceHash( $pString );
		$query = "SELECT `tran`, tivm.`version`, tivm.`source_hash` AS `usage_source_hash`
				  FROM `".BIT_DB_PREFIX."tiki_i18n_masters` tim
					LEFT OUTER JOIN `".BIT_DB_PREFIX."tiki_i18n_version_map` tivm ON( tivm.`source_hash`=tim.`source_hash` AND tivm.`version`=? )
				  	LEFT OUTER JOIN `".BIT_DB_PREFIX."tiki_i18n_strings` tis ON( tim.`source_hash`=tis.`source_hash` AND `lang_code`=? )
				  WHERE tim.`source_hash`=?";
		$ret = $this->mDb->GetRow($query, array( BIT_MAJOR_VERSION, $pLangCode, $sourceHash ) );
		if( $pOverrideUsage && $gBitSystem->isFeatureActive( 'record_untranslated' ) ) {
			$query = "SELECT `source_hash` FROM `".BIT_DB_PREFIX."tiki_i18n_masters` WHERE `source_hash`=?";
			$source = $this->GetOne($query, array( $this->getSourceHash( $pString ) ) );
			if( empty( $source ) ) {
				$this->storeMasterString( array( 'source_hash' => $this->getSourceHash( $pString ), 'new_source' => $pString ) );
			}
		}
		if( $pOverrideUsage && $gBitSystem->isFeatureActive( 'track_translation_usage' ) ) {
			if( empty( $ret['usage_source_hash'] ) ) {
				$query = "INSERT INTO `".BIT_DB_PREFIX."tiki_i18n_version_map` (`source_hash`,`version`) VALUES (?,?)";
				$trans = $this->query($query, array( $sourceHash, BIT_MAJOR_VERSION ) );
			}
		}
		return (!empty( $ret['tran'] ) ? $ret['tran'] : NULL );
	}

	function getSourceHash( $pString ) {
		return( md5( strtolower( trim( $pString ) ) ) );
	}

	function clearCache() {
		unlink_r( TEMP_PKG_PATH."lang/" );
		unlink_r( TEMP_PKG_PATH."templates_c/" );
	}

}

?>
