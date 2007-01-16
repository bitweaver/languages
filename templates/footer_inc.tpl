{if $gBitSystem->isFeatureActive( 'i18n_interactive_translation' ) and $gBitUser->hasPermission( 'p_languages_edit' )}
	<div class="translation box">
		<h3>{tr}Translation Links{/tr}</h3>
		{foreach from=$gBitTranslationHash item=hash key=key}
			{if $gBitSystem->isFeatureActive( 'i18n_interactive_bittranslation' )}
				<a href="http://www.bitweaver.org/languages/master_strings.php?source_hash={$hash}">{$key}</a> &bull;&nbsp;
			{else}
				<a href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php?source_hash={$hash}">{$key}</a> &bull;&nbsp;
			{/if}
		{foreachelse}
			{tr}Please reload this page to see the translation links{/tr}
		{/foreach}
	</div>
{/if}
