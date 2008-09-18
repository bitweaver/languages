{strip}
<div class="floaticon">{bithelp}</div>

<div class="edit languages">
	<div class="header">
		<h1>{tr}Master Language Strings{/tr}</h1>
	</div>

	<div class="body">
		{minifind name="Search master strings" sort_mode=$sort_mode}
		{if $sources}
			{form legend="Edit Translations"}
			{formfeedback hash=$masterMsg}
			{formfeedback warning="You will need to clear the System Cache to see the changes." link="languages/edit_languages.php/System Cache"}
			{tr}Translations strings may appear empty if the language is not loaded. The language will be automatically loaded when you click the edit icon.{/tr}
			{foreach from=$sources item=sourceHash}
					<input type="hidden" name="source_hash[]" value="{$sourceHash}" />
					<div class="row">
						{formlabel label="Master String" for="master_string"}
						{forminput}
							<textarea cols="50" rows="5" name="edit_master[{$sourceHash}]" id="master_string">{$masterStrings.$sourceHash.source|escape}</textarea>
						{/forminput}
					</div>
{*
					<div class="row submit">
						<input type="submit" name="delete_master" value="{tr}Delete Master{/tr}" />
						&nbsp;<input type="submit" name="change_master" value="{tr}Save{/tr}" />
					</div>
*}

					{foreach from=$languages key=langCode item=lang}
						{if $langCode ne 'en'}
						<div class="row">
							{formlabel label=$lang.native_name no_translate=1}
							{forminput}
								{* if results are guessed, we don't need to escape *}
								{if $masterStrings.$sourceHash.textarea}
									<textarea name="edit_trans[{$sourceHash}][{$langCode}]" id="h_{$sourceHash}" rows="5" cols="50">{if $tranStrings.$sourceHash.$langCode.guessed}{$tranStrings.$sourceHash.$langCode.trans}{else}{$tranStrings.$sourceHash.$langCode.trans|escape|stripslashes}{/if}</textarea>
								{else}
									<input type="text" name="edit_trans[{$sourceHash}][{$langCode}]" id="h_{$sourceHash}" value="{if $tranStrings.$sourceHash.$langCode.guessed}{$tranStrings.$sourceHash.$langCode.trans}{else}{$tranStrings.$sourceHash.$langCode.trans|escape|stripslashes}{/if}" size="45" maxlength="2048" />
								{/if}
							{/forminput}
						</div>
						{/if}
					{/foreach}
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
			{form legend="Translation Filter"}
				<input type="hidden" name="char" value="{$smarty.request.char}" \>
				<div class="row">
					{formlabel label="Filter" for=""}
					{forminput}
						<label><input type="radio" name="filter" {if !$smarty.request.filter                 }checked="checked" {/if}value="" /> {tr}No filter{/tr}</label><br />
						<label><input type="radio" name="filter" {if $smarty.request.filter == 'untranslated'}checked="checked" {/if}value="untranslated" /> {tr}Only untranslated strings{/tr}</label><br />
						<label><input type="radio" name="filter" {if $smarty.request.filter == 'translated'  }checked="checked" {/if}value="translated" /> {tr}Only translated strings{/tr}</label><br />
						<select name="filter_lang" id="filter_lang">
							<option value="">{tr}Any Language{/tr}</option>
							{foreach from=$languages key=langCode item=lang}
								<option value="{$langCode}" {if $smarty.request.filter_lang == $langCode}selected="selected"{/if}>{$lang.full_name}</option>
							{/foreach}
						</select>
						{formhelp note="Limit the translated filter to this language"}
					{/forminput}
				</div>

				<div class="submit">
					<input type="submit" name="set_filter" value="{tr}Set Filter{/tr}" />
				</div>
			{/form}

			{form legend="Translations" id=formid}
				{alphabar iall=1 filter_lang=$smarty.request.filter_lang filter=$smarty.request.filter}

				{formfeedback hash=$feedback}

				{if $masterStrings}
					<script type="text/javascript">/* <![CDATA[ check / uncheck all */
						document.write("<input name=\"switcher\" id=\"switcher\" type=\"checkbox\" onclick=\"switchCheckboxes(this.form.id,'source_hash[]','switcher')\" />");
						document.write("<label for=\"switcher\">{tr}Select All{/tr}</label> ");
					/* ]]> */</script>
				{/if}

				<ol>
					{foreach from=$masterStrings key=sourceHash item=master}
					<li><input type="checkbox" title="{tr}Delete{/tr}" name="source_hash[]" value="{$sourceHash}" /> <a href="{$smarty.server.PHP_SELF}?source_hash[]={$sourceHash}">{$master.source|escape}</a></li>
					{/foreach}
				</ol>

				<div class="submit">
					<input type="submit" name="guess_translations" value="{tr}Guess Translations{/tr}" />
					<input type="submit" name="delete_master" value="{tr}Delete Seleted Master Strings{/tr}" />
				</div>

				{alphabar iall=1}
			{/form}

		{/if}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
