{* $Header$ *}

{if $gBitSystem->isFeatureActive( 'babelfish' ) and $gBitSystem->isFeatureActive( 'babelfish_logo' )}

<div class="display babelfish">
<table>
  {section loop=$babelfish_links name=i}
    <tr>
      {if $smarty.section.i.index == 0}
        <td>
          <a href="{$babelfish_links[i].href}" target="{$babelfish_links[i].target}">{$babelfish_links[i].msg}</a>
        </td>
        <td rowspan="{$smarty.section.i.total}" align=right>
          {$babelfish_logo}
        </td>
      {else}
        <td valign="top">
          <a href="{$babelfish_links[i].href}" target="{$babelfish_links[i].target}">{$babelfish_links[i].msg}</a>
        </td>
      {/if}
    </tr>
  {/section}
</table>
</div>

{elseif $gBitSystem->isFeatureActive( 'babelfish' ) and !$gBitSystem->isFeatureActive( 'babelfish_logo' )}

<div class="babelfish">
<table>
  {section loop=$babelfish_links name=i}
  <tr><td>
    <a href="{$babelfish_links[i].href}" target="{$babelfish_links[i].target}"> {$babelfish_links[i].msg}</a>
  </td> </tr>
  {/section}
</table>
</div>

{elseif !$gBitSystem->isFeatureActive( 'babelfish' ) and $gBitSystem->isFeatureActive( 'babelfish_logo' )}

<div class="babelfish">
  {$babelfish_logo}
</div>
{/if}
