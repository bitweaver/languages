{strip}
<div class="floaticon">{bithelp}</div>

<div class="edit languages">
	<div class="header">
		<h1>{tr}Master Language Strings{/tr}</h1>
	</div>

	<div class="body">
		{if $sourceHash}
			{form legend="Edit Master String"}
				<input type="hidden" name="source_hash" value="{$sourceHash}" />
				{formfeedback hash=$masterMsg}
				{formfeedback warning="{tr}You will need to <a href=\"`$smarty.const.LANGUAGES_PKG_URL`edit_languages.php\">clear the System Cache</a> to see the changes.{/tr}"}

				<div class="row">
					{formlabel label="Master String" for="master_string"}
					{forminput}
						<textarea cols="50" rows="5" name="edit_master" id="master_string">{$masterStrings.$sourceHash.source|escape}</textarea>
					{/forminput}
				</div>

				<div class="row submit">
					<input type="submit" name="delete_master" value="{tr}Delete Master{/tr}" />
					&nbsp;<input type="submit" name="change_master" value="{tr}Save{/tr}" />
				</div>
			{/form}

			{minifind name="Search master strings" sort_mode=$sort_mode}

			{form legend="Edit Translations"}
				<input type="hidden" name="source_hash" value="{$sourceHash}" />
				{tr}Translations strings may appear empty if the language is not loaded. The language will be automatically loaded when you click the edit icon.{/tr}
				{foreach from=$languages key=langCode item=lang}
					{if $langCode ne 'en'}
					<div class="row">
						{formlabel label=$lang.native_name}
						{forminput}
							{* if results are guessed, we don't need to escape *}
							{if $masterStrings.$sourceHash.textarea}
								<textarea name="edit_trans[{$langCode}]" id="h_{$sourceHash}" rows="5" cols="50">{if $tranStrings.$langCode.guessed}{$tranStrings.$langCode.tran}{else}{$tranStrings.$langCode.tran|escape}{/if}</textarea>
							{else}
								<input type="text" name="edit_trans[{$langCode}]" id="h_{$sourceHash}" value="{if $tranStrings.$langCode.guessed}{$tranStrings.$langCode.tran}{else}{$tranStrings.$langCode.tran|escape}{/if}" size="45" maxlength="255" />
							{/if}
						{/forminput}
					</div>
					{/if}
				{/foreach}

				<div class="row submit">
					<input type="submit" name="cancel" value="{tr}Cancel{/tr}" />
					&nbsp;<input type="submit" name="guess_translations" value="{tr}Guess Translations{/tr}" />
					&nbsp;<input type="submit" name="save_translations" value="{tr}Save{/tr}" />
				</div>

				<div class="row">
					{formhelp note="Guess Translations will try and get an estimated translation using google language tools. Please make sure you check the returned strings for messed up HTML."}
				</div>
			{/form}

		{else}

			{legend legend="Translations"}
				{minifind name="Search master strings" sort_mode=$sort_mode}

				{alphabar iall=1}

				{formfeedback error=$errorMsg success=$successMsg}

				<ol>
					{foreach from=$masterStrings key=sourceHash item=master}
						<li><a href="{$smarty.server.PHP_SELF}?source_hash={$sourceHash}">{$master.source|escape}</a> {smartlink ititle="Delete Master String" ibiticon="icons/edit-delete" delete_master=1 source_hash=$sourceHash}</li>
					{/foreach}
				</ol>

				{alphabar iall=1}
			{/legend}

		{/if}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
