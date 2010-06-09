<?php
/**
 * @version $Header$
 */
global $gBitInstaller;

$infoHash = array(
	'package'      => LANGUAGES_PKG_NAME,
	'version'      => str_replace( '.php', '', basename( __FILE__ )),
	'description'  => "Set core package version number.",
);
$gBitInstaller->registerPackageUpgrade( $infoHash );
?>
