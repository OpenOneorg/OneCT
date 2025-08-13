{if $smarty.get.p >= 1}
    <a style="float: left;" href="?id={$smarty.get.id}&p={$smarty.get.p - 1}">
        {$lang.back}
    </a>
{/if}

{if $data_wall|count >= 10}
    <a style="float: right;" href="?id={$smarty.get.id}&p={$smarty.get.p + 1}">
        {$lang.forward}
    </a>
{/if}
<br>