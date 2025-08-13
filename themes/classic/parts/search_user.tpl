<table class="user">
    <tr>
		{* Аватарка *}
		<td><img class="img100" src="{$list.img100}"></td>

		<td class="info">
            <a href="user.php?id={$list['id']}">
                <h1>
                    {* Имя пользоателя *}
                    {$list.username}
                    
                    {* Галочка *}
                    {if $list.privilege >= 1}
                        <img src="{$themedir}/imgs/verif.gif">
                    {/if}
                </h1>
            </a>
		</td>
	</tr>
</table>