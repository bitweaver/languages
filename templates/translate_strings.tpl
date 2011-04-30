{strip}
<div class="floaticon">{bithelp}</div>

<script type="text/javascript">/* <![CDATA[ */
{literal}
var ajax = new BitBase.SimpleAjax();
function autoTranslate( pElementId ) {
console.log( pElementId );
	ajax.connect( "{/literal}{$smarty.const.LANGUAGES_PKG_URL}ajax_translate.php{literal}"
		, "lang={/literal}{$editLang}{literal}&source_hash=" + escape( pElementId )
		, function (r) { 
				document.getElementById( 'h_'+pElementId ).value = r.responseText; 
			}
		, "GET"
	);
}
{/literal}
/* ]]> */</script>

<div class="edit languages">
    <div class="header">
        <h1>{tr}Edit Languages{/tr}</h1>
    </div>

	<div class="body">
		{form}
			<div class="row">
				{formlabel label="Select the language to edit" for="select_language"}
				{forminput}
					<select name="choose_lang" id="select_language" onchange="this.form.submit()">
						<option value="">{tr}Select the language to edit{/tr}</option>
						{foreach from=$languages key=langCode item=language}
							{if $langCode != 'en'}
								<option value="{$langCode}" {if $smarty.request.choose_lang == $langCode}selected="selected"{/if}>{$language.full_name}</option>
							{/if}
						{/foreach}
					</select>
				{/forminput}
			</div>

			{alphabar iall=1 lang=$smarty.request.lang translate=1 un_trans=$unTrans all_trans=$allTrans}

			<input type="hidden" name="lang" value="{$editLang}" />
			<input type="hidden" name="char" value="{$char}" />

			{if $smarty.request.lang}
				{legend legend="Edit `$languages.$lang.full_name` Language"}
					{foreach from=$tranStrings key=sourceHash item=tran}
						{if $allTrans || (!$gBitSystem->isFeatureActive( 'i18n_track_translation_usage' ) || $tran.version)}
							<div class="row{if !$tran.version and !allTrans} warning{/if}">
								<div class="formlabel">
									<label for="h_{$sourceHash}">{tr}Translate{/tr}</label>
									{if $gBitSystem->getConfig('google_api_key')}
										<div class="autotranslate" onclick="autoTranslate('{$sourceHash}')">{biticon iname="google-favicon" ipackage="languages" iexplain="Auto-Translate"} Auto</div>
									{/if}
								</div>
								{forminput}
									{$tran.source|escape|nl2br}<br/>
									{if $tran.textarea}
										<textarea style="font-size:medium;width:100%" name="edit_trans[{$sourceHash}]" id="h_{$sourceHash}" rows="5" cols="50">{$tran.trans|escape|stripslashes}</textarea>
									{else}
										<input style="font-size:medium;width:100%" name="edit_trans[{$sourceHash}]" id="h_{$sourceHash}" value="{$tran.trans|escape|stripslashes}" size="45" maxlength="255" />
									{/if}
								{/forminput}
							</div>
						{/if}
					{/foreach}

					<div class="row submit">
						<input type="submit" name="cancel" value="{tr}Cancel{/tr}" />&nbsp;
						<input type="submit" name="save_translations" value="{tr}Save{/tr}" />
					</div>

					{alphabar iall=1 lang=$editLang translate=1 un_trans=$unTrans all_trans=$allTrans}
				{/legend}
			{/if}
		{/form}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
