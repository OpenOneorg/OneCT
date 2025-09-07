{extends file='../layout.tpl'}

{block name=title}{$lang.comments} -- {$sitename}{/block}

{block name=body}
    <div class="main_app">
		<div class="wall">	
            {$i = 0}
            {include file="../parts/post.tpl"}

            <h1 class="head">{$lang.comments}</h1>

            <form action="" method="post" enctype="multipart/form-data" class="posting">
                <textarea name="text" class="postarea"></textarea>
                <button type="submit" name="do_post" class="do_post">{$lang.post}</button>
                <div class="detail">
                    <p>{$lang.markdown_support}</p>
                    {if $text != NULL}
                        <p class="error">{$text}</p>
                    {/if}
                </div>
            </form>

            {$i = 0}
            {foreach $data_wall.comments as $data_comment}
                {include file="../parts/comment.tpl"}
                {$i = $i + 1}
            {/foreach}
        </div>
    </div>
{/block}