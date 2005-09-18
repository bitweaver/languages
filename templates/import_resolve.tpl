{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin languages">
    <div class="header">
        <h1>{tr}Resolve Language Import Conflicts{/tr}</h1>
    </div>

	{formfeedback hash=$impmsg}

	<div class="body">
		{form legend="Import languages"}
			{foreach from=$impConflicts key=lang item=langConflicts}
				<h2>{tr}Conflicts{/tr}: {$impLanguages.$lang.translated_name}</h2>
				{foreach from=$langConflicts key=sourceHash item=conflict}
				<div class="row">
					{formlabel label="Existing"}
					{forminput}
							<input type="radio" name="conflict[{$lang}][{$sourceHash}]" value="" checked="checked" /> {$conflict.existing}
					{/forminput}
				</div>
				<div class="row">
					{formlabel label="Imported"}
					{forminput}
							<input type="radio" name="conflict[{$lang}][{$sourceHash}]" value="{$conflict.import}" /> {$conflict.import}
					{/forminput}
				</div>
				<br/>
				{/foreach}
			{/foreach}

			<div class="row submit">
				<input type="submit" name="resolve" value="{tr}Import{/tr}" />
			</div>
		{/form}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
