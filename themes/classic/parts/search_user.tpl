    <tr>
		{* Аватарка *}
		<th><img class="img100" src="{$list.img100}"></th>

		<th class="info">
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
		</th>
	</tr>