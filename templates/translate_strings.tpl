{strip}
<div class="floaticon">{bithelp}</div>
{include file="bitpackage:languages/translate_google_ajax_inc.tpl"}
<div class="edit languages">
    <div class="header">
        <h1>{tr}Edit Languages{/tr}</h1>
    </div>

	<div class="body">
		{form id="translateform"}
			<div class="form-group">
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

			{alphabar iall=1 choose_lang=$editLang translate=1 un_trans=$unTrans all_trans=$allTrans}

			<input type="hidden" name="lang" value="{$editLang}" />
			<input type="hidden" name="char" value="{$char}" />

			{if $editLang}
				{legend legend=$languages.$lang.full_name}
					{foreach from=$tranStrings key=sourceHash item=tran}
						{if $allTrans || (!$gBitSystem->isFeatureActive( 'i18n_track_translation_usage' ) || $tran.version)}
							<div class="{if !$tran.version and !allTrans} warning{/if}">
								{forminput}
									<a href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php?source_hash={$sourceHash}">{$tran.source|escape|nl2br}</a><br/>
									{if $tran.textarea}
										<textarea class="form-control" name="edit_trans[{$sourceHash}]" id="{$editLang}_{$sourceHash}" lang="{$editLang}" rows="5" cols="50">{$tran.trans|escape|stripslashes}</textarea>
									{else}
									<div class="input-group">
										{if $gBitSystem->getConfig('google_api_key')}
										<div class="input-group-addon">
											<div onclick="autoTranslate('{$sourceHash}','{$editLang}')">{biticon iname="google-favicon" ipackage="languages" iexplain="Auto-Translate"} {tr}Auto{/tr}</div>
										</div>
										{/if}
										<input class="form-control" name="edit_trans[{$sourceHash}]" id="{$editLang}_{$sourceHash}" lang="{$editLang}" value="{$tran.trans|escape|stripslashes}" maxlength="2048" />
									</div>
									{/if}
								{/forminput}
							</div>
						{/if}
					{/foreach}

					<div class="form-group submit">
						<input type="submit" class="btn btn-default" name="cancel" value="{tr}Cancel{/tr}" />&nbsp;
						<input type="submit" class="btn btn-default" name="save_translations" value="{tr}Save{/tr}" />
						{if $gBitSystem->getConfig('google_api_key')}
						<div class="btn btn-default" onclick="return autoTranslateEmpty()">{tr}Auto Translate Empty Strings{/tr}</div>
						{/if}
					</div>

					{alphabar iall=1 lang=$editLang translate=1 un_trans=$unTrans all_trans=$allTrans}
				{/legend}
			{/if}
		{/form}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}

