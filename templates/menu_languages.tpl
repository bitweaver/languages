{strip}
{if $gBitUser->hasPermission( 'p_languages_edit' )}
	<ul>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}edit_languages.php">{tr}Edit Languages{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}import.php">{tr}Import / Export{/tr}</a></li>
		<li><a class="item" href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php">{tr}Master Strings{/tr}</a></li>
	</ul>
{/if}
{/strip}
