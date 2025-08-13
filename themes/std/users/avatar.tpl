{extends file='../layout.tpl'}

{block name=title}{$lang.change_avatar} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <form action="" method="post" enctype="multipart/form-data">
            <p>
                <p>{$lang.avatar}: </p>
                <input type="file" name="file">
            </p>

            <button type="submit" name="do_change">
                {$lang.change}
            </button>
        </form>
    </div><br>
{/block}