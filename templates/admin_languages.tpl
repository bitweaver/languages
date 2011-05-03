{form legend="Language Settings"}
	<input type="hidden" name="page" value="{$page}" />

	<div class="row">
		{formlabel label="Language" for="bitlanguage"}
		{forminput}
			<select name="bitlanguage" id="bitlanguage">
				{foreach from=$languages key=langCode item=lang}
					<option value="{$langCode}" {if $gBitSystem->getConfig('bitlanguage') eq $langCode}selected="selected"{/if}>{$lang.full_name|escape}</option>
				{/foreach}
			</select>
			{formhelp note="Select the default language of your site."}
		{/forminput}
	</div>

	{foreach from=$formLanguageToggles key=feature item=output}
		<div class="row">
			{formlabel label=`$output.label` for=$feature}
			{forminput}
				{html_checkboxes name=$feature values="y" checked=$gBitSystem->getConfig($feature) labels=false id=$feature}
				{formhelp hash=$output}
			{/forminput}
		</div>
	{/foreach}

	<div class="row">
		{formlabel label="Google API Key" for="google_api_key"}
		{forminput}
			{biticon iname="google-favicon" ipackage="languages" iexplain="Auto-Translate"}
			<input type="text" name="google_api_key" value="{$gBitSystem->getConfig('google_api_key')}" style="width:30em"/>
			{formhelp note="Enter your <a href='http://www.google.com/search?q=Google+translate+API'>Google Translate API KEY</a>"}
		{/forminput}
	</div>

	<div class="row submit">
		<input type="submit" name="prefs" value="{tr}Change Settings{/tr}" />
	</div>
{/form}
