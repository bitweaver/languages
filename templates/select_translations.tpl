{* don't show if this is the page creation *}
{if $translationList.from}
	<div class="row">
		{formlabel label="Translate this page" for=""}
		{forminput}
			From: {html_options values=$translationsList.from options=$translationsList.from name="translate[from]"}
			&nbsp;&nbsp;&nbsp; To: {html_options values=$translationsList.to   options=$translationsList.to   name="translate[to]"}
			<br />
			<input type="submit" name="translate[submit]" value="{tr}Translate{/tr}" />
			<input type="submit" name="translate[google]" value="{tr}Google translation{/tr}" />
			{formhelp note="If you feel like translating this page into a different language, please select the correct languages above and hit <strong>translate</strong>."}
		{/forminput}
	</div>
{else}
	there is no translation data in the table yet and therefore we can't select what language to translate from.
	we'll need a dropdown to set the language of any given page when editing it.
	for now, i think we should just set the lang_code column in liberty_content to whatever the site language is.
{/if}
