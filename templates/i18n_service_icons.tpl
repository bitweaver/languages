{strip}
	{foreach from=$i18nTranslations item=trans}
		<a href="{$smarty.const.BIT_ROOT_URL}index.php?content_id={$trans.content_id}">{biticon ipackage=languages iname="languages/`$trans.lang_code`" iexplain=$trans.full_name}</a>
	{/foreach}
{/strip}
