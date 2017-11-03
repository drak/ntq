{if count($feed.items) gt 0}
<div class="content-rss">
    <h3><a href="{$feed.permalink}">{if $lang eq 'de'}Fragen mit dem Tag zikula{else}{*$feed.title*}Questions tagged with zikula{/if}</a></h3>
    {if $includeContent}
    {foreach item='item' from=$feed.items}
        <div class="content-rss-item">
            <h4><a href="{$item.permalink}">{$item.title}</a></h4>
            {if $item.description}<div class="content-rss-descr">{$item.description}</div>{/if}
        </div>
    {/foreach}
    {else}
        <ul>
            {foreach item='item' from=$feed.items}
            <li><a href="{$item.permalink}">{$item.title}</a></li>
            {/foreach}
        </ul>
    {/if}
</div>
{/if}
