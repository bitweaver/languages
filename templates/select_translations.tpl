{* don't show if this is the page creation *}
<div class="row">
	{formlabel label="Translations" for=""}
	{forminput}
		<input type="hidden" name="translation_id" value="{$translationId}" />
		<select name="translate_content_id">
			{foreach from=$translationsList key=langCode item=lang}
				<option value="{$lang.content_id|default:$langCode}">{$lang.native_name}: &nbsp; {$lang.title|default:"&bull; {tr}Create New{/tr} &bull;"}</option>
			{/foreach}
		</select>
		<br />
		<label><input type="checkbox" name="translate_google" /> {tr}Attempt Google translation{/tr}</label><br/>
		<input type="submit" name="translate" value="{tr}Translate{/tr}" />
		{formhelp note="If you feel like translating this page into a different language, please select the correct languages above and hit <strong>translate</strong>."}
	{/forminput}
</div>
