<script type="text/javascript">/* <![CDATA[ */
{literal}
var autoHashArray = new Array();
var ajax = new BitBase.SimpleAjax();

function autoTranslate( pElementId, pLang ) {
console.log( "auto trans " + pElementId + ", " + pLang );
	ajax.connect( "{/literal}{$smarty.const.LANGUAGES_PKG_URL}ajax_translate.php{literal}"
		, "lang="+pLang+"&source_hash=" + escape( pElementId )
		, updateTranslation
		, "GET"
	);
}

function updateTranslation( pResponse ) {
	if( pResponse.responseText ) {
		rObj = eval('(' + pResponse.responseText  + ')');
		document.getElementById( rObj.lang_code + '_' + rObj.source_hash ).value = rObj.translation;
	}
	if( autoHashArray.length ) {
		var next = autoHashArray.pop().split('_',2);
		autoTranslate( next[1], next[0] );
	}
}

function autoTranslateEmpty() {
	var elem = document.getElementById('translateform').elements;
	for(var i = 0; i < elem.length; i++) {
		if( elem[i].type == 'text' || elem[i].type == 'textarea' ) {
			if( !elem[i].value && elem[i].id ) {
				autoHashArray.push( elem[i].id );
			}
		}
	} 
	if( autoHashArray.length ) {
		var next = autoHashArray.pop().split('_',2);
		autoTranslate( next[1], next[0] );
	}
}

{/literal}
/* ]]> */</script>


