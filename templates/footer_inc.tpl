{if $gBitSystem->isFeatureActive( 'interactive_translation' ) and $gBitUser->hasPermission( 'bit_p_edit_languages' )}
	<div class="translation box">
		<h3>{tr}Translation Links{/tr}</h3>
		{foreach from=$gBitTranslationHash item=hash key=key}
			{if $gBitSystem->isFeatureActive( 'interactive_bittranslation' )}
				<a href="http://www.bitweaver.org/languages/master_strings.php?source_hash={$hash}">{$key}</a> &bull;&nbsp;
			{else}
				<a href="{$smarty.const.LANGUAGES_PKG_URL}master_strings.php?source_hash={$hash}">{$key}</a> &bull;&nbsp;
			{/if}
		{foreachelse}
			{tr}Please reload this page to see the translation links{/tr}
		{/foreach}
	</div>
{/if}
