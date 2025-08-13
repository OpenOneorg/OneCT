<div class="pages">
    {if $smarty.get.p >= 1}
        <a class="back" href="?id={$smarty.get.id}&p={$smarty.get.p - 1}">
            {$lang.back}
        </a>
    {/if}

    {if $data_wall|count >= 10}
        <a class="next" href="?id={$smarty.get.id}&p={$smarty.get.p + 1}">
            {$lang.forward}
        </a>
    {/if}
</div>