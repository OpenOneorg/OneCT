{extends file='../layout.tpl'}

{block name=title}{$lang.comments} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        {$i = 0}
        {include file="../parts/post.tpl"}

        <h1 align="center" class="block_name">
            {$lang.comments}
        </h1>

        <form action="" method="post" enctype="multipart/form-data"  class="post_block">
            <textarea name="text" style="width: 100%;"></textarea>
            <button type="submit" name="do_post">
                {$lang.post}
            </button>
            <p>
                {$text}
            </p>
        </form>

        {$i = 0}
        {foreach $data_wall.comments as $data_comment}
            {include file="../parts/comment.tpl"}
            {$i = $i + 1}
        {/foreach}
    </div><br>
{/block}