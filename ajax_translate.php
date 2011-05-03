<?php

$gLightweightScan = TRUE;
require_once( '../kernel/setup_inc.php' );

$translation = NULL;

if( !empty( $_REQUEST['lang'] ) && !empty( $_REQUEST['source_hash'] ) ) {
	if( $masterString = $gBitLanguage->getMasterString( $_REQUEST['source_hash'] ) ) {
		// convert smarty to tags so it is shielded from translation
		$preppedMaster = preg_replace( '/\{/', '<smarty ', $masterString );
		// needs to be a full tag so we can cleanly de-tagify after translation
		$preppedMaster = preg_replace( '/}/', '></smarty>', $preppedMaster );

		$googleUrl = "https://www.googleapis.com/language/translate/v2?key=".$gBitSystem->getConfig('google_api_key')."&source=en&target=".$_REQUEST['lang']."&q=".urlencode( $preppedMaster );

		if( $fh = fopen( $googleUrl, "r" ) ) {
			$jsonResponse = fread( $fh, 8192 );
			$data = json_decode( $jsonResponse );
			fclose( $fh );
		}
		if( !empty( $data->data->translations[0]->translatedText ) ) {
			$translation = urldecode( $data->data->translations[0]->translatedText );
			if( $translation != $masterString ) {
				//detagify
				$preppedTranslation = preg_replace( '/<smarty /', '{', $translation );
				// needs to be a full tag so we can cleanly de-tagify after translation
				$preppedTranslation = preg_replace( '/><\/smarty>/', '}', $preppedTranslation );
				
				print json_encode( array( 'lang_code' => $_REQUEST['lang'], 'source_hash' => $_REQUEST['source_hash'], 'translation' => $preppedTranslation ) );
			}
		}
	}
}

