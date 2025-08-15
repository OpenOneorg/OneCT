    <div class="block" id="{"post{$data.id}"}">
            {* Имя пользователя *}

            <b>
                <a class="user" href="user.php?id={$from_ids[$i].id}">
                    {$from_ids[$i].username}
                </a>
			</b>

            {* Текст закрепления *}

            {if $data.is_pin}
                {$lang.pin}
            {/if}

            {* Кнопки действий *}

            {if $post->isbuttons($i)}
                <div class="buttons">
                    <a href="?id={$smarty.get.id}&pin={$data.id}">
                        <img src="{$themedir}/imgs/pin.gif">
                    </a>

                    <a href="?id={$smarty.get.id}&del={$data.id}">
                        <img src="{$themedir}/imgs/del.gif">
                    </a>
                </div>
            {/if}<br>

            {* Дата поста *}

            <span>{$data.date|date_format:$lang.date}</span><br>

            {* Выкладыватель поста *}

            <b>
                {$lang.by}: 
                <a class="user" href="user.php?id={$user_ids[$i].id}">
                    {$user_ids[$i].username}
                </a>
            </b><br>

        {* Картинка поста *}

        {if isset($data.image)}
            <img src="{$data.image}" width="100%">
        {/if}

        {* Текст поста *}

        <p>{$data.text_html}</p>

        {* Лайки *}
        
        <div class="buttons" {if $data.liked} id="selected" {/if}>
            <a href="?id={$smarty.get.id}&p={$smarty.get.p}&like={$data.id}" style="float: right;">
                {if $data.liked}
                    <img src="{$themedir}/imgs/like_sel.gif">
                {else}
                    <img src="{$themedir}/imgs/like.gif">
                {/if}

                <span class="likecount">{$data.likes}</span>
            </a>
        </div><br>
    </div>
    
    {* Кнопка с комментариями *}

    <div class="opencom">
        {if isset($data.comments)}
            <a href="comments.php?id={$data.id}">
                {$lang.comments} 
                ({$data.comments})
            </a>
        {/if}
    </div>