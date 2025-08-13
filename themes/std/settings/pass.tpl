{extends file='../layout.tpl'}

{block name=title}{$lang.change_pass} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <form method="post">
			<p>
				<p>{$lang.old_pass}: </p>
				<input type="password" name="oldpass">
			</p>
			<p>
				<p>{$lang.new_pass}: </p>
				<input type="password" name="pass">
			</p>
			<p>
				<p>{$lang.repeat_pass}:</p>
				<input type="password" name="pass2">
			</p>
			<p>
				<button type="submit" name="do_change">
					{$lang.change_pass}
				</button>
			</p>
        </form>
        <p>{$error}</p>
    </div><br>
{/block}