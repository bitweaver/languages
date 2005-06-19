{* $Header: /cvsroot/bitweaver/_bit_languages/modules/mod_switch_language_dropdown.tpl,v 1.1 2005/06/19 04:55:13 bitweaver Exp $ *}
{strip}
{bitmodule title="$moduleTitle" name="switch_language_dropdown"}
	{form method="get" ipackage='languages' ifile='switch_lang.php'}
		<select name="language" onchange="this.form.submit();">
			{foreach from=$languages item=proc key=langCode}
				{if is_disabled ne 'y'}
					<option value="{$langCode}"
						{if $sel_lang eq $langCode}selected="selected"{/if}>
						{$proc.native_name}
					</option>
				{/if}
			{foreachelse}
				<option>{tr}No records found{/tr}</option>
			{/foreach}
		</select>
		<noscript>
			<div class="row submit">
				<input type="submit" value="{tr}Translate{/tr}" />
			</div>
		</noscript>
	{/form}
{/bitmodule}
{/strip}
