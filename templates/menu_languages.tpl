{strip}
{if $gBitUser->hasPermission( 'p_languages_edit' )}
	<ul>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}edit_languages.php">{biticon iname="preferences-desktop-locale" iexplain="Edit Languages" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}translate_strings.php">{biticon iname="preferences-desktop-locale" iexplain="Translate Strings" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}import.php">{biticon iname="view-refresh" iexplain="Import / Export" ilocation=menu}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php">{biticon iname="text-html" iexplain="Master Strings" ilocation=menu}</a></li>
	</ul>
{/if}
{/strip}
