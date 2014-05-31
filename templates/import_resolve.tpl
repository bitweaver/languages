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
					<div class="control-group column-group gutters">
						{formlabel label="Master String"}
						{forminput}
								{$conflict.master|escape|nl2br}
						{/forminput}
					</div>

					<div class="control-group column-group gutters">
						{formlabel label="Existing"}
						{forminput}
							<label><input type="radio" name="conflict[{$lang}][{$sourceHash}]" value="" checked="checked" /> {$conflict.existing|escape|nl2br}</label>
						{/forminput}
					</div>

					<div class="control-group column-group gutters">
						{formlabel label="Imported"}
						{forminput}
							<label><input type="radio" name="conflict[{$lang}][{$sourceHash}]" value="{$conflict.import}" /> {$conflict.import|escape|nl2br}</label>
						{/forminput}
					</div>
					<br/>
				{/foreach}
			{/foreach}

			<div class="control-group submit">
				<input type="submit" class="ink-button" name="resolve" value="{tr}Import{/tr}" />
			</div>
		{/form}
	</div><!-- end .body -->
</div><!-- end .languages -->
{/strip}
