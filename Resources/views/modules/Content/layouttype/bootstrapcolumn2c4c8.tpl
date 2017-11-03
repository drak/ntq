{include file="layouttype/header.tpl" pid=$page.id}
<div class="content-layout column2">
    <div class="row">
    <div class="content-area-top col-sm-12">
        {if !empty($page.content[0])}
        {foreach from=$page.content[0] item=c}
        {contenteditthis data=$c access=$access type='content'}
        {$c.output}
        {/foreach}
        {/if}
    </div>
    </div>

    <div class="row">
    <div class="col-sm-4">
        {if !empty($page.content[1])}
        {foreach from=$page.content[1] item=c}
        {contenteditthis data=$c access=$access type='content'}
        {$c.output}
        {/foreach}
        {/if}
    </div>

    <div class="col-sm-8">
        {if !empty($page.content[2])}
        {foreach from=$page.content[2] item=c}
        {contenteditthis data=$c access=$access type='content'}
        {$c.output}
        {/foreach}
        {/if}
    </div>
    </div>

    <div class="row">
    <div class="content-area-bottom col-sm-12">
        {if !empty($page.content[3])}
        {foreach from=$page.content[3] item=c}
        {contenteditthis data=$c access=$access type='content'}
        {$c.output}
        {/foreach}
        {/if}
    </div>
    </div>
</div>
{include file="layouttype/footer.tpl" pid=$page.id}
