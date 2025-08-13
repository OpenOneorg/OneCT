<div class="pages">
    {if $smarty.get.p >= 1}
        <a class="back" href="?q={$smarty.get.q}&p={$smarty.get.p - 1}">
            {$lang.back}
        </a>
    {/if}

    {if $data_wall|count >= 50}
        <a class="next" href="?q={$smarty.get.q}&p={$smarty.get.p + 1}">
            {$lang.forward}
        </a>
    {/if}
</div>