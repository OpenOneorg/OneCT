{if $smarty.get.p >= 1}
    <a style="float: left;" href="?q={$smarty.get.q}&p={$smarty.get.p - 1}">
        {$lang.back}
    </a>
{/if}

{if $data_wall|count >= 50}
    <a style="float: right;" href="?q={$smarty.get.q}&p={$smarty.get.p + 1}">
        {$lang.forward}
    </a>
{/if}
<br>