{strip}
<div class="floaticon">{bithelp}</div>

<div class="edit languages">
    <div class="header">
        <h1>{tr}Edit Languages{/tr}</h1>
    </div>

	<div class="body">
		{if !$translate}
			{jstabs}
				{if $editDescription}
					{if $gBitUser->hasPermission( 'bit_p_create_languages' )}
						{jstab title="Create or Edit Language"}
							{form legend="Create or Edit Language"}
								{formfeedback error=$saveErrors }
								<input type="hidden" name="update_lang_code" value="{$defaults.lang_code}" />
								<div class="row">
									{formlabel label="Native name of the langugage" for="native_name"}
									{forminput}
										<input type="text" id="native_name" name="native_name" size="45" value="{$defaults.native_name}" />
									{/forminput}
								</div>
								<div class="row">
									{formlabel label="English name of the langugage" for="english_name"}
									{forminput}
										<input type="text" name="english_name" id="english_name" size="45" value="{$defaults.english_name}" />
									{/forminput}
								</div>
								<div class="row">
									{formlabel label="Langugage code" for="lang_code"}
									{forminput}
										<input type="text" name="lang_code" id="lang_code" size="8" maxlength="32" value="{$defaults.lang_code}" />
										{formhelp note='For official language codes, see <a class="external" href="http://www.loc.gov/standards/iso639-2/langcodes.html">ISO639-1</a> and to add a localistion you can append the country code from <a class="external" href="http://www.iso.org/iso/en/prods-services/iso3166ma/02iso-3166-code-lists/list-en1.html">ISO 3166-1</a>.<br />e.g. ISO639-1 for english is "en" and the country code for britain is "uk". The resulting code is "en-uk".'}
									{/forminput}
								</div>
								<div class="row">
									{formlabel label="Disabled" for="is_disabled"}
									{forminput}
										<input type="checkbox" name="is_disabled" id="is_disabled" {if $isDisabled || $defaults.is_disabled}checked="checked"{/if} value="y" />
										{formhelp note="Disabling a language will remove it from available language menus."}
									{/forminput}
								</div>
								<div class="row submit">
									<input type="submit" name="save_language" value="{tr}Save Language{/tr}" />
								</div>
								{formhelp note="A note for localisations: when you have a language, say 'de' and you add a localisation such as 'de-at' it will fist check de-at for a string and then fall back to de. If it still hasn't found a translation, it will default to english."}
							{/form}
						{/jstab}
					{/if}
				{/if}

				{jstab title="Choose Language"}
					{formfeedback success=$saveSuccess}
					{form legend="Choose language"}
						<div class="row">
							{formlabel label="Select the language to edit" for="select_language"}
							{forminput}
								<select name="lang" id="select_language">
									{foreach from=$languages key=langCode item=lang}
										{if $langCode != 'en'}
											<option value="{$langCode}" {if $defaults.lang_code eq $langCode}selected="selected"{/if}>{$lang.full_name}</option>
										{/if}
									{/foreach}
								</select>
							{/forminput}
						</div>

						{if $gBitSystem->isFeatureActive( 'track_translation_usage' )}
							<div class="row">
								{formlabel label="Display all strings" for="all_trans"}
								{forminput}
									<input type="checkbox" id="all_trans" name="all_trans" {if $allTrans}checked="checked"{/if} value="y" />
									{formhelp note="This will display translation strings for all bitweaver versions. This means it will also show strings that are not used at all and might be useless to you."}
								{/forminput}
							</div>
						{/if}

						<div class="row">
							{formlabel label="Only Untranslated" for="un_trans"}
							{forminput}
								<input type="checkbox" id="un_trans" name="un_trans" />
								{formhelp note="Display only untranslated strings when editing the language translations."}
							{/forminput}
						</div>

						{formfeedback warning="Editing a language for the first time will cause an import of the language. this can take several minutes, depending on your configuration."}

						<div class="row submit">
							<input type="submit" name="delete_language" value="{tr}Delete Language{/tr}" />&nbsp;
							<input type="submit" name="edit_language" value="{tr}Edit Description{/tr}" />&nbsp;
							<input type="submit" name="translate" value="{tr}Edit Translations{/tr}" />
						</div>

						{formhelp note="
							<dl>
								<dt>Delete Language</dt>
								<dd>Delete the language from your server.</dd>
								<dt>Edit Description</dt>
								<dd>Edit the description of the language, including language code.</dd>
								<dt>Edit Translations</dt>
								<dd>Edit the translated strings of the selected language.</dd>
							</dl>
						"}

						{if $gBitUser->hasPermission( 'bit_p_create_languages' )}
							<div class="row submit">
								<input type="submit" name="new_language" value="{tr}Create New Language{/tr}" />
							</div>
						{/if}
					{/form}
				{/jstab}

				{jstab title="Language Cache"}
					{formfeedback success=$saveSuccess}
					{form legend="Clear Language Cache"}
						<div class="row">
							{tr}Clear the cached language translations for all languages.{/tr}
						</div>

						<div class="row submit">
							<input type="submit" name="clear_cache" value="{tr}Clear Cache{/tr}" />
						</div>
					{/form}
				{/jstab}
			{/jstabs}

		{else}

			{form legend="Edit `$languages.$lang.full_name` Language"}
				{alphabar iall=1 lang=$lang translate=1 un_trans=$unTrans all_trans=$allTrans}

				<input type="hidden" name="lang" value="{$lang}" />
				<input type="hidden" name="char" value="{$char}" />

				{foreach from=$tranStrings key=sourceHash item=tran}
					{if $allTrans || (!$gBitSystem->isFeatureActive( 'track_translation_usage' ) || $tran.version)}
						<div class="row{if !$tran.version and !allTrans} warning{/if}">
							{formlabel label="Translate" for="h_$sourceHash"}
							{forminput}
								{$tran.source|escape}<br/>
								{if $tran.textarea}
									<textarea name="edit_trans[{$sourceHash}]" id="h_{$sourceHash}" rows="5" cols="80">{$tran.tran|escape}</textarea>
								{else}
									<input name="edit_trans[{$sourceHash}]" id="h_{$sourceHash}" value="{$tran.tran|escape}" size="45" maxlength="255" />
								{/if}
							{/forminput}
						</div>
					{/if}
				{/foreach}

				{if $saveSuccess}
					{tr}The following items have been saved successfully{/tr}
					{formfeedback success=$saveSuccess}
				{else}
					<div class="row submit">
						<input type="submit" name="cancel" value="{tr}Cancel{/tr}" />&nbsp;
						<input type="submit" name="save_translations" value="{tr}Save{/tr}" />
					</div>

					{alphabar iall=1 lang=$lang translate=1 un_trans=$unTrans all_trans=$allTrans}
				{/if}
			{/form}
		{/if}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
