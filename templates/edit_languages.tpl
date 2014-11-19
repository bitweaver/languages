{strip}
<div class="floaticon">{bithelp}</div>

<div class="edit languages">
    <div class="header">
        <h1>{tr}Edit Languages{/tr}</h1>
    </div>

	<div class="body">
		{jstabs}
			{if $editDescription}
				{if $gBitUser->hasPermission( 'p_languages_create' )}
					{jstab title="Create or Edit Language"}
						{form legend="Create or Edit Language"}
							{formfeedback error=$saveErrors }
							<input type="hidden" name="update_lang_code" value="{$defaults.lang_code}" />
							<div class="form-group">
								{formlabel label="Native name of the language" for="native_name"}
								{forminput}
									<input type="text" id="native_name" name="native_name" size="45" value="{$defaults.native_name}" />
								{/forminput}
							</div>
							<div class="form-group">
								{formlabel label="English name of the language" for="english_name"}
								{forminput}
									<input type="text" name="english_name" id="english_name" size="45" value="{$defaults.english_name}" />
								{/forminput}
							</div>
							<div class="form-group">
								{formlabel label="Language code" for="lang_code"}
								{forminput}
									<input type="text" name="lang_code" id="lang_code" size="8" maxlength="32" value="{$defaults.lang_code}" />
									{formhelp note='For official language codes, see <a class="external" href="http://www.loc.gov/standards/iso639-2/langcodes.html">ISO639-1</a> and to add a localisation you can append the country code from <a class="external" href="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1.html">ISO 3166-1</a>.<br />e.g. ISO639-1 for english is "en" and the country code for britain is "uk". The resulting code is "en-uk".'}
								{/forminput}
							</div>
							<div class="form-group">
								{forminput label="checkbox"}
									<input type="checkbox" name="is_disabled" id="is_disabled" {if $isDisabled || $defaults.is_disabled}checked="checked"{/if} value="y" />Disabled
									{formhelp note="Disabling a language will remove it from available language menus."}
								{/forminput}
							</div>
							<div class="form-group submit">
								<input type="submit" class="btn btn-default" name="save_language" value="{tr}Save Language{/tr}" />
							</div>
							{formhelp note="A note for localisations: when you have a language, say 'de' and you add a localisation such as 'de-at' it will first check de-at for a string and then fall back to de. If it still hasn't found a translation, it will default to english."}
						{/form}
					{/jstab}
				{/if}
			{/if}

			{jstab title="Choose Language"}
				{formfeedback success=$saveSuccess}
				{form legend="Choose language"}
					<div class="form-group">
						{formlabel label="Select the language to edit" for="select_language"}
						{forminput}
							<select name="lang" id="select_language">
								{foreach from=$languages key=langCode item=lang}
									{if $langCode != 'en'}
										<option value="{$langCode}" {if $defaults.lang_code eq $langCode}selected="selected"{/if}>{$lang.full_name} {if $lang.is_disabled}*{tr}DISABLED{/tr}*{/if}</option>
									{/if}
								{/foreach}
							</select>
						{/forminput}
					</div>

					{if $gBitSystem->isFeatureActive( 'i18n_track_translation_usage' )}
						<div class="form-group">
							{forminput label="checkbox"}
								<input type="checkbox" id="all_trans" name="all_trans" {if $allTrans}checked="checked"{/if} value="y" />Display all strings
								{formhelp note="This will display translation strings for all bitweaver versions. This means it will also show strings that are not used at all and might be useless to you."}
							{/forminput}
						</div>
					{/if}

					<div class="form-group">
						{forminput label="checkbox"}
							<input type="checkbox" id="un_trans" name="un_trans" />Only Untranslated
							{formhelp note="Display only untranslated strings when editing the language translations."}
						{/forminput}
					</div>

					{formfeedback warning="Editing a language for the first time will cause an import of the language. this can take several minutes, depending on your configuration."}

					<div class="form-group submit">
						<input type="submit" class="btn btn-default" name="delete_language" value="{tr}Delete Language{/tr}" />&nbsp;
						<input type="submit" class="btn btn-default" name="edit_language" value="{tr}Edit Language{/tr}" />&nbsp;
					{if $gBitUser->hasPermission( 'p_languages_create' )}
							<button class="btn btn-default pull-right" name="new_language">{booticon iname="icon-plus-sign-alt"} {tr}New Language{/tr}</button>
					{/if}
					</div>

				{/form}
			{/jstab}

			{jstab title="Language Cache"}
				{formfeedback success=$saveSuccess}
				{form legend="Clear Language Cache"}
					<div class="form-group">
						{formlabel label="Clear Language Cache" for="clear_cache"}
						{forminput}
							<input type="submit" class="btn btn-default" name="clear_cache" id="clear_cache" value="{tr}Clear Cache{/tr}" />
							{formhelp note="Clear the cached language translations for all languages. It is necessary to clear the cache when you have made changes to the language database."}
						{/forminput}
					</div>
				{/form}
			{/jstab}
		{/jstabs}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
