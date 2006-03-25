{* don't show if this is the page creation *}
<div class="row">
	{formlabel label="Translations" for="to_id"}
	{forminput}
		<input type="hidden" name="i18n[translation_id]" value="{$translationId}" />
		<input type="hidden" name="i18n[from_id]" value="{$smarty.request.i18n.from_id|default:$gContent->mContentId}" />
		<select name="i18n[to_id]" id="to_id">
			{foreach from=$translationsList key=langCode item=lang}
				<option value="{$lang.content_id|default:$langCode}">{$lang.native_name}: &nbsp; {$lang.title|escape|default:"&bull; {tr}Create New{/tr} &bull;"}</option>
			{/foreach}
		</select>
		&nbsp; <label><input type="checkbox" name="i18n[google]" /> {tr}Attempt Google translation{/tr}</label>
		<br />
		<input type="submit" name="i18n[translate]" value="{tr}Translate{/tr}" />
		{formhelp note="If you feel like translating this page into a different language, please select the correct language above and hit <strong>Translate</strong>."}
	{/forminput}
</div>
