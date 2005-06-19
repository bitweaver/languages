{form legend="Language Settings"}
	<input type="hidden" name="page" value="{$page}" />

	<div class="row">
		{formlabel label="Language" for="language"}
		{forminput}
			<select name="tikilanguage" id="tikilanguage">
				{foreach from=$languages key=langCode item=lang}
					<option value="{$langCode}" {if $gBitSystemPrefs.tikilanguage eq $langCode}selected="selected"{/if}>{$lang.full_name|escape}</option>
				{/foreach}
			</select>
			{formhelp note="Select the default language of your site."}
		{/forminput}
	</div>

	{foreach from=$formLanguageToggles key=feature item=output}
		<div class="row">
			{formlabel label=`$output.label` for=$feature}
			{forminput}
				{html_checkboxes name=$feature values="y" checked=`$gBitSystemPrefs.$feature` labels=false id=$feature}
				{formhelp hash=$output}
			{/forminput}
		</div>
	{/foreach}

	<div class="row submit">
		<input type="submit" name="prefs" value="{tr}Change Settings{/tr}" />
	</div>
{/form}
