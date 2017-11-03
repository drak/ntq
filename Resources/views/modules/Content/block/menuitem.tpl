{assign var='currentPid' value=''}
{if isset($smarty.get.pid)}
    {assign var='currentPid' value=$smarty.get.pid|@intval}
{/if}
{if $page.id eq 2}
    <li id="menuItemNews"{if isset($toplevelmodule) && $toplevelmodule eq 'MUNewsModule'} class="active"{/if}><a href="/{$lang}/news/messages/view" title="News">News</a></li>
{elseif $page.id eq 6}
    {if $lang eq 'de'}
        <li id="menuItemLocale"><a href="/en/" title="View this page in English">English</a></li>
    {else}
        <li id="menuItemLocale"><a href="/de/" title="Diese Seite auf Deutsch anschauen">Deutsch</a></li>
    {/if}
{/if}
<li id="menuItem{$page.id}"{if $currentPid eq $page.id} class="active"{/if}><a href="{modurl modname='Content' type='user' func='view' pid=$page.id}" title="{$page.title|safetext}">{$page.title|safetext}</a>
    {*if !empty($page.subPages)}
    <ul>
        {foreach from=$page.subPages item=subpage}
        {include file='block/menuitem.tpl' page=$subpage}
        {/foreach}
    </ul>
    {/if*}
</li>
