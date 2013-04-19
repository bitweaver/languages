{strip}
{if $packageMenuTitle}<a href="#"> {tr}{$packageMenuTitle|capitalize}{/tr}</a>{/if}
<ul class="{$packageMenuClass}">
	<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=languages">{tr}Language{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}edit_languages.php">{tr}Edit Languages{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}translate_strings.php">{tr}Translate Strings{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}import.php">{tr}Import / Export{/tr}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php">{tr}Master Strings{/tr}</a></li>
</ul>
{/strip}
