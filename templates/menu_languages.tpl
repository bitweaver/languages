{strip}
{if $gBitUser->hasPermission( 'p_languages_edit' )}
	<ul>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}edit_languages.php">{biticon ipackage="icons" iname="preferences-desktop-locale" iexplain="Edit Languages" iforce="icon"} {tr}Edit Languages{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}import.php">{biticon ipackage="icons" iname="view-refresh" iexplain="Import / Export" iforce="icon"} {tr}Import / Export{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php">{biticon ipackage="icons" iname="text-html" iexplain="Master Strings" iforce="icon"}{tr}Master Strings{/tr}</a></li>
	</ul>
{/if}
{/strip}
