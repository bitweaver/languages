{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin languages">
	<div class="header">
		<h1>{tr}Import Languages{/tr}</h1>
	</div>

	{formfeedback hash=$impmsg}

	<div class="body">
		{jstabs}
			{jstab title="Import Languages"}
				{form legend="Import languages" enctype="multipart/form-data"}
					<div class="form-group">
						{formlabel label="Select the languages to Import"}
						{formhelp note="Languages that are checked below will be imported from the language string files in the bitweaver distribution. If you have your own language file, please choose it below."}
						{foreach from=$impLanguages key=langCode item=lang}
							{forminput label="checkbox"}
								<input type="checkbox" name="imp_languages[]" value="{$langCode}" /> {$lang.full_name}
							{/forminput}
						{/foreach}

						{if $gBitUser->isAdmin()}
							{forminput label="checkbox"}
								<input type="checkbox" name="import_master" value="1" /> Master Strings
								{formhelp note="The English strings file will be used to set up the language database and will be used as a reference for translations."}
							{/forminput}
						{/if}
					</div>

					<div class="form-group">
						{formlabel label="Upload Language File"}
						{forminput}
							{formhelp note="Choose a language file to upload..."}
								<input type="file" name="upload_file" size="40" /><br/>
						{/forminput}
						{forminput}
							{formhelp note="Upload File Language..."}
							<select name="upload_lang_code" id="upload_lang_code">
								{foreach from=$impLanguages key=langCode item=lang}
									<option value="{$langCode}" >{$lang.full_name}</option>
								{/foreach}
							</select>
						{/forminput}
					</div>

					<div class="form-group">
						{formlabel label="Options"}
						{forminput label="radio"}
							<input type="radio" name="overwrite" value="n" /> {tr}Do not import string if it has been changed in the local database{/tr}
						{/forminput}
						{forminput label="radio"}
							<input type="radio" name="overwrite" value="y" /> {tr}Overwrite changes in the local database{/tr}
						{/forminput}
						{forminput label="radio"}
							<input type="radio" name="overwrite" value="r" checked="checked" /> {tr}Manually resolve conflicts between database and import file{/tr}
						{/forminput}
					</div>

					<div class="form-group submit">
						<input type="submit" class="btn btn-default" name="import" value="{tr}Import{/tr}" />
					</div>
				{/form}
			{/jstab}

			{if $expLanguages}
				{jstab title="Export Languages"}
					{form legend="Export language"}
						<div class="form-group">
							{formlabel label="Language to export" for="exp_lang"}
							{forminput}
								<select class="form-input" name="export_lang_code" id="export_lang_code">
								{foreach from=$expLanguages key=langCode item=lang}
									<option value="{$langCode}" {if $exp_language eq $langCode}selected="selected"{/if}>{$lang.full_name}</option>
								{/foreach}
								</select>
								{formhelp note=""}
							{/forminput}
						</div>

						{if $gBitSystem->isFeatureActive( 'i18n_track_translation_usage' )}
							<div class="form-group">
								{forminput label="checkbox"}
									<input type="checkbox" name="all_trans" id="all_trans" checked="checked" value="y" />All translations
									{formhelp note="This will export all strings of the chosen language for all versions of bitweaver. It is generally a good idea to export these."}
								{/forminput}
							</div>
						{else}
							<input type="hidden" name="all_trans" value="y" />
						{/if}

						<div class="form-group">
							{forminput label="checkbox"}
								<input type="checkbox" name="include_empty" id="include_empty" value="y" />Include Empty
								{formhelp note="This will include empty translation strings as well. This is generally not needed."}
							{/forminput}
						</div>

						<div class="form-group">
							{formlabel label="Destination" for="is_disabled"}
							{forminput label="radio"}
								<input type="radio" name="target" value="temp" /> {tr}Save to temporary file{/tr}
								{formhelp note="This will save the file to a temporary location on the server."}
							{/forminput}
							{forminput label="radio"}
								<input type="radio" name="target" value="download" checked="checked" /> {tr}Download translation file{/tr}
								{formhelp note="Save this to languages/lang/(lang_code)/language.php where lang_code is the language your are downloading."}
							{/forminput}
						</div>

						<div class="form-group submit">
							<input type="submit" class="btn btn-default" name="export" value="{tr}Export{/tr}" />
						</div>
					{/form}
				{/jstab}
			{/if}
		{/jstabs}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
