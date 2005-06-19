{* $Header: /cvsroot/bitweaver/_bit_languages/templates/babelfish.tpl,v 1.1 2005/06/19 04:55:13 bitweaver Exp $ *}

{if $gBitSystemPrefs.feature_babelfish eq 'y' and $gBitSystemPrefs.feature_babelfish_logo eq 'y'}

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

{elseif $gBitSystemPrefs.feature_babelfish eq 'y' and $gBitSystemPrefs.feature_babelfish_logo eq 'n'}

<div class="babelfish">
<table>
  {section loop=$babelfish_links name=i}
  <tr><td>
    <a href="{$babelfish_links[i].href}" target="{$babelfish_links[i].target}"> {$babelfish_links[i].msg}</a>
  </td> </tr>
  {/section}
</table>
</div>

{elseif $gBitSystemPrefs.feature_babelfish eq 'n' and $gBitSystemPrefs.feature_babelfish_logo eq 'y'}

<div class="babelfish">
  {$babelfish_logo}
</div>
{/if}
