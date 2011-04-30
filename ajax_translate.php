<?php

$gLightweightScan = TRUE;
require_once( '../kernel/setup_inc.php' );

$translation = NULL;

if( !empty( $_REQUEST['lang'] ) && !empty( $_REQUEST['source_hash'] ) ) {
	if( $masterString = $gBitLanguage->getMasterString( $_REQUEST['source_hash'] ) ) {

		$googleUrl = "https://www.googleapis.com/language/translate/v2?key=".$gBitSystem->getConfig('google_api_key')."&source=en&target=".$_REQUEST['lang']."&q=".urlencode( $masterString );

		if( $fh = fopen( $googleUrl, "r" ) ) {
			$jsonResponse = fread( $fh, 8192 );
			$data = json_decode( $jsonResponse );
			fclose( $fh );
		}
		if( !empty( $data->data->translations[0]->translatedText ) ) {
			$translation = $data->data->translations[0]->translatedText;
		}
	}
}

print $translation;
