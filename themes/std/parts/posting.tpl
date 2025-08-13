<form action="" method="post" enctype="multipart/form-data" class="post_block">
    <textarea name="text" style="width: 100%;"></textarea>
    <a href="javascript:openmenu('file_form');" style="float:right;">
        {$lang.attach}
    </a>

    <button type="submit" name="do_post">
        {$lang.post}
    </button><br>    

    <div class="file_form" style="display: none;">
        <p>{$lang.img}: </p>
        <input type="file" name="file">
    </div>

    <p>
        {$text}
    </p>
</form>