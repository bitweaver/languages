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
				{formfeedback warning="You will need to clear the System Cache to see the changes." link="languages/edit_languages.php/System Cache"}

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
								<textarea name="edit_trans[{$langCode}]" id="h_{$sourceHash}" rows="5" cols="50">{if $tranStrings.$langCode.guessed}{$tranStrings.$langCode.trans}{else}{$tranStrings.$langCode.trans|escape|stripslashes}{/if}</textarea>
							{else}
								<input type="text" name="edit_trans[{$langCode}]" id="h_{$sourceHash}" value="{if $tranStrings.$langCode.guessed}{$tranStrings.$langCode.trans}{else}{$tranStrings.$langCode.trans|escape|stripslashes}{/if}" size="45" maxlength="255" />
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

			{minifind name="Search master strings" sort_mode=$sort_mode}
			{form legend="Translations" id=formid}
				{alphabar iall=1}

				{formfeedback hash=$feedback}

				{if $masterStrings}
					<script type="text/javascript">/* <![CDATA[ check / uncheck all */
						document.write("<input name=\"switcher\" id=\"switcher\" type=\"checkbox\" onclick=\"switchCheckboxes(this.form.id,'source_hash[]','switcher')\" />");
						document.write("<label for=\"switcher\">{tr}Select All{/tr}</label> ");
					/* ]]> */</script>
				{/if}

				<ol>
					{foreach from=$masterStrings key=sourceHash item=master}
					<li><input type="checkbox" title="{tr}Delete{/tr}" name="source_hash[]" value="{$sourceHash}" /> <a href="{$smarty.server.PHP_SELF}?source_hash={$sourceHash}">{$master.source|escape}</a></li>
					{/foreach}
				</ol>

				<div class="submit">
					<input type="submit" name="delete_master" value="{tr}Delete Seleted Master Strings{/tr}" />
				</div>

				{alphabar iall=1}
			{/form}

		{/if}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
