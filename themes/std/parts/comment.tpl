<div>
    {* Аватарка пользователя *}
    <img style="float: left; margin-right: 8px;" src="{$user_idss[$i].img50}" width="50px"> 
    
    <div class="post_block1">

        {* Пользователь *}

        <b>
            <a href="user.php?id={$user_idss[$i].id}">
                {$user_idss[$i].username}
            </a>
        </b>

        {* Действия с комментарием *}

        {if $post->isdelete($i)}
            <div style="float: right;">
                <a href="?id={$smarty.get.id}&del={$data_comment.id}">
                    <img src="{$themedir}/imgs/del.gif">
                </a>
            </div>
        {/if}<br>

        {* Дата комментария *}

        <span>{$data_comment.date|date_format:$lang.date}</span>

    </div>

    {* Текст комментария *}
    <p>
        {$data_comment.text}
    </p>
</div>