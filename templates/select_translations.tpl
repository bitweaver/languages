{* don't show if this is the page creation *}
{if $gContent->mContentId}
	<div class="control-group">
		{formlabel label="Translations" for="to_id"}
		{forminput}
			<input type="hidden" name="i18n[translation_id]" value="{$translationId}" />
			<input type="hidden" name="i18n[from_id]" value="{$smarty.request.i18n.from_id|default:$gContent->mContentId}" />
			<select name="i18n[to_id]" id="to_id">
				{foreach from=$translationsList key=langCode item=lang}
					<option value="{$lang.content_id|default:$langCode}">{$lang.native_name}: &nbsp; {$lang.title|escape|default:"&bull; {tr}Create New{/tr} &bull;"}</option>
				{/foreach}
			</select>
			<br />
			<input type="submit" class="btn btn-default" name="i18n[translate]" value="{tr}Translate{/tr}" />
			&nbsp; <label><input type="checkbox" name="i18n[google]" /> {tr}Attempt Google translation{/tr}</label>
			{formhelp note="To translate this page into a different language, select that language above and click <strong>Translate</strong>. To use Google's translation service, enable the checkbox first (depending on the size of this page's text, Google's translation might take a while). "}
		{/forminput}
	</div>
{/if}
