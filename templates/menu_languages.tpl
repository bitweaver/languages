{strip}
{if $gBitUser->hasPermission( 'p_languages_edit' )}
{if $packageMenuTitle}<a class="dropdown-toggle" data-toggle="dropdown" href="#"> {tr}{$packageMenuTitle}{/tr} <b class="caret"></b></a>{/if}
<ul class="{$packageMenuClass}">
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}edit_languages.php">{booticon iname="icon-flag"   iexplain="Edit Languages" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}translate_strings.php">{booticon iname="icon-flag"   iexplain="Translate Strings" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}import.php">{booticon iname="icon-recycle"   iexplain="Import / Export" ilocation=menu}</a></li>
	<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php">{biticon iname="text-html" iexplain="Master Strings" ilocation=menu}</a></li>
</ul>
{/if}
{/strip}
