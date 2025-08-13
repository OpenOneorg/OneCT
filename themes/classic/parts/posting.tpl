<form action="" method="post" enctype="multipart/form-data" class="posting">
    <textarea name="text" class="postarea"></textarea>

    <button type="submit" name="do_post" class="do_post">{$lang.post}</button><br>    

    <div class="detail">
        <a class="openmenu" href="javascript:showmenu();">
            <img src="{$themedir}/imgs/close.gif" id="detailicon">
            {$lang.attach}
        </a>
        <div id="menu" style="display: none;">
            <p><?php echo($lang_image); ?></p>
            <input type="file" name="file" class="file" accept=".jpg,.jpeg,.png,.webp,.gif,.bmp">
        </div>
	</div>

    {if $text != NULL}
        <p class="error">{$text}</p>
    {/if}
</form>