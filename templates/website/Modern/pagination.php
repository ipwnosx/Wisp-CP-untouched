<div class="clear"></div>
<div class="sayfalama">
{if-first}<span><a href="{first-link}">{first}</a></span>{/if-first}
{if-before}<span><a href="{before-link}">{before}</a></span>{/if-before}
{loop}<span{active} class="sayfalama-active"{/active}><a href="{page-link}">{page}</a></span>{/loop}
{if-next}<span><a href="{next-link}">{next}</a></span>{/if-next}
{if-last}<span><a href="{last-link}">{last}</a></span>{/if-last}
</div>