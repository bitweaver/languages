<?php
/**
 * @package languages
 * @version $Header: /cvsroot/bitweaver/_bit_languages/Babelfish.php,v 1.3 2009/10/01 13:45:43 wjames5 Exp $
 *
 * Tiki is copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.
 *
 * This file copyright (c) 2002-2003, Ross Smith II
 */

/**
 * @package languages
 */
class Babelfish {
	/**
	 *	Return the host name of the server
	 *
	 *	@todo move to BitBase class
	 */
	function host() {
		if (isset($_SERVER['HTTP_HOST'])) {
			// HTTP_HOST already includes a ':port' if it is used
			return $_SERVER['HTTP_HOST'];
		}

		if (!isset($_SERVER['SERVER_NAME'])) {
			return false;
		}

		$rv = $_SERVER['SERVER_NAME'];

		if (!isset($_SERVER['SERVER_PORT'])) {
			return $rv;
		}
		
		if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
			if ($_SERVER['SERVER_PORT'] != 443) {
				$rv .= ':' . $_SERVER['SERVER_PORT'];
			}
		} else {
			if ($_SERVER['SERVER_PORT'] != 80) {
				$rv .= ':' . $_SERVER['SERVER_PORT'];
			}
		}

		return $rv;
	}
	
	/**
	 *	Return babelfish URL to translate \c $lang_from to \c $lang_to
	 *
	 * @param lang_from
	 * @param lang_to
	 */
	function url($lang_from, $lang_to) {
		static $url_map = array(
			'en'	=> 'english',
			'fr'	=> 'french',
			'de'	=> 'german',
			'it'	=> 'italian',
			'es'	=> 'spanish',
			'pt'	=> 'portugese',
		);

		$lang_from = strtolower($lang_from);
		$lang_to = strtolower($lang_to);
		
		if (!isset($url_map[$lang_from])) {
			return '';
		}
		
		$url = 'http://jump.altavista.com/translate_' . $url_map[$lang_from] . '.go' .
			'?http://babelfish.altavista.com/babelfish/tr?doit=done' .
			'&amp;lp=' . $lang_from . '_' . $lang_to .
			'&amp;urltext=http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
			$url .= 's';
		}
		$url .= '://' . Babelfish::host() . $_SERVER['REQUEST_URI'] .
			(strpos('?', $_SERVER['REQUEST_URI']) ? '&amp;' : '?') .
			'babelfish=' . $lang_from . '_' . $lang_to;

		return $url;
	}

	/**
	 *	Return HTML of babelfish links
	 *
	 *	@param lang_from Language to translate from
	 */
	function links($lang_from = 'en') {
		static $fishes = array(
			'en' => array(	# English
				'de' => '&Uuml;bersetzen&nbsp;Sie&nbsp;diese&nbsp;Seite&nbsp;ins&nbsp;Deutsche',
				'es' => 'Traduzca&nbsp;esta&nbsp;paginaci&oacute;n&nbsp;a&nbsp;espa&ntilde;ol',
				'fr' => 'Traduisez&nbsp;cette&nbsp;page&nbsp;en&nbsp;fran&ccedil;ais',
				'it' => 'Tradurre&nbsp;questa&nbsp;pagina&nbsp;in&nbsp;italiano',
				'pt' => 'Traduza&nbsp;esta&nbsp;p&aacute;gina&nbsp;em&nbsp;portugu&ecirc;ses',
				'zh' => '&#x7ffb;&#x8bd1;&#x8fd9;&#x9875;&#x6210;&#x6c49;&#x8bed;&nbsp;(CN)',
				'ja' => '&#x65e5;&#x672c;&#x8a9e;&#x306b;&#x3053;&#x306e;&#x30da;&#x30fc;&#x30b8;&#x3092;&#x7ffb;&#x8a33;&#x3057;&#x306a;&#x3055;&#x3044;&nbsp;(Nihongo)',
				'ko' => '&#xd55c;&#xad6d;&#xc778;&#xc73c;&#xb85c;&nbsp;&#xc774;&nbsp;&#xd398;&#xc774;&#xc9c0;&#xb97c;&nbsp;&#xbc88;&#xc5ed;&#xd558;&#xc2ed;&#xc2dc;&#xc694;&nbsp;(Hangul)',
			),
			'fr' => array(	# French
				'de' => '&Uuml;bersetzen&nbsp;Sie&nbsp;diese&nbsp;Seite&nbsp;in&nbsp;Deutschen',
				'en' => 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;English',
			),
			'de' => array(	# German
				'en' => 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;English',
				'fr' => 'Traduisez&nbsp;cette&nbsp;page&nbsp;en&nbsp;fran&ccedil;ais',
			),
			'it' => array(	# Italian
				'en' => 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;English',
			),
			'es' => array(	# Spanish
				'en' => 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;English',
			),
			'pt' => array(	# Portugese
				'en' => 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;English',
			),
			'ru' => array(	# Russian
				'en' => 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;English',
			),
		);

		// \todo Use phpsniff or PEAR's Net_UserAgent_Detect to detect the browser type
		// as Netscape 4.x and possibly others displays '&#xabcd;' literally
//		if (preg_match('/(mozilla\/4)/i', $_SERVER['HTTP_USER_AGENT'])) {
//			$fishes['en']['zh'] = 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;Chinese&nbsp;(CN)';
//			$fishes['en']['ja'] = 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;Japenese&nbsp;(Nihongo)';
//			$fishes['en']['ko'] = 'Translate&nbsp;this&nbsp;page&nbsp;into&nbsp;Korean&nbsp;(Hangul)';
//		}

		// If we have already translated this page (babelfish=en_fr), then don't display the strings again
		if (!isset($fishes[$lang_from]) || isset($_GET['babelfish'])) {
			return array();
		}

		$a = array();
		foreach ($fishes[$lang_from] as $lang_to => $msg) {
			$a[] = array('target' => $lang_to,
                         'href'   => Babelfish::url($lang_from, $lang_to),
                         'msg'    => $msg);
		}

		return $a;
	}

	/**
	 *	Return javascript code to display babelfish logo
	 *	
	 *	\static
	 */
	function logo($lang = 'en') {
		static $s = "<script language=\"JavaScript1.2\" src=\"http://www.altavista.com/r?%str\"></script>";

		$lang = strtolower($lang);

		switch ($lang) {
			case 'en':
			case 'de':
			case 'fr':
			case 'it':
				return sprintf($s, $lang);
			case 'es':
				return sprintf($s, 'esp');
			case 'pt':
				return sprintf($s, 'port');
		}

		return '';
	}

}

?>
