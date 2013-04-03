{strip}
<li class="dropdown-submenu">
    <a href="#" onclick="return(false);" tabindex="-1" class="sub-menu-root">{tr}{$smarty.const.LANGUAGES_PKG_NAME|capitalize}{/tr}</a>
	<ul class="dropdown-menu sub-menu">
		<li><a class="item" href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page=languages">{tr}Language Settings{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}edit_languages.php">{tr}Edit Languages{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}translate_strings.php">{tr}Translate Strings{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}import.php">{tr}Import / Export{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php">{tr}Master Strings{/tr}</a></li>
	</ul>
</li>
{/strip}
