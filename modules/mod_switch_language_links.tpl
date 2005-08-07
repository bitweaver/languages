{* $Header: /cvsroot/bitweaver/_bit_languages/modules/mod_switch_language_links.tpl,v 1.2 2005/08/07 17:39:28 squareing Exp $ *}
{strip}
{bitmodule title="$moduleTitle" name="switch_language_links"}
	{foreach from=$languages item=lang key=langCode}
		{if is_disabled ne 'y'}
			<span {if $sel_lang eq $langCode}class="highlight"{/if} style="display:bock;width:33%;float:left;">
				<a title="{$lang.native_name} ({$lang.translated_name})" href="{$smarty.const.LANGUAGES_PKG_URL}switch_lang.php?language={$langCode}">{$lang.lang_code}</a>
			</span>
		{/if}
	{/foreach}
	<div class="clear"></div>
{/bitmodule}
{/strip}
