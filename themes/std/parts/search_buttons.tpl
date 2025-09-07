{if $smarty.get.p >= 1}
    <a style="float: left;" href="?q={$smarty.get.q}&p={$smarty.get.p - 1}">
        {$lang.back}
    </a>
{/if}

{if $data_count >= 51}
    <a style="float: right;" href="?q={$smarty.get.q}&p={$smarty.get.p + 1}">
        {$lang.forward}
    </a>
{/if}
<br>