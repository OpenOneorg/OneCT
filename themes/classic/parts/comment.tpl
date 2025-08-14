<div class="block">

        {* Пользователь *}

        <b>
            <a class="user" href="user.php?id={$user_idss[$i].id}">
                {$user_idss[$i].username}
            </a>
        </b>

        {* Действия с комментарием *}

        {if $post->isdelete($i)}
            <div class="buttons">
                <a href="?id={$smarty.get.id}&del={$data_comment.id}">
                    <img src="{$themedir}/imgs/del.gif">
                </a>
            </div>
        {/if}<br>

        {* Дата комментария *}

        <span>{$data_comment.date|date_format:$lang.date}</span><br>

    {* Текст комментария *}
    <p>{$data_comment.text_html}</p>
</div>
<div class="opencom"></div>