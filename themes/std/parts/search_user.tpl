<a href="user.php?id={$list['id']}">
    {* Аватарка *}
    <img src="{$list.img100}" width="100px" style="float: left; margin-right: 8px;">

    <h1>   
        {* Имя пользоателя *}
        {$list.username}
        
        {* Галочка *}
        {if $list.privilege >= 1}
            <img src="{$themedir}/imgs/verif.gif">
        {/if}
    </h1>
</a><br><br><br><br>