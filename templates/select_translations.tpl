{* don't show if this is the page creation *}
<div class="row">
	{formlabel label="Translations" for=""}
	{forminput}
		{if $translationId}
			<input type="hidden" name="translation_id" value="{$translationId}" />
		{/if}
		<select name="translate_content_id">
		{foreach from=$translationsList key=langCode item=lang}
			<option value="{$lang.content_id|default:$langCode}">{$lang.native_name}: {$lang.title|default:"~~Create New~~"}</option>
		{/foreach}
		</select>
		<br />
		<input type="checkbox" name="translate_google" /> {tr}Attempt Google translation{/tr} <br/>
		<input type="submit" name="translate" value="{tr}Translate{/tr}" />
		{formhelp note="If you feel like translating this page into a different language, please select the correct languages above and hit <strong>translate</strong>."}
	{/forminput}
</div>
