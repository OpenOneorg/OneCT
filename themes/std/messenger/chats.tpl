{extends file='../layout.tpl'}

{block name=title}Мессенджер -- {$sitename}{/block}

{block name=body}
    <div class="page">

        <a href="" style="color: black; text-decoration: none;">
            {* Аватарка *}
            <img src="../themes/std/imgs/blankimg.jpg" width="50px" style="float: left; margin-right: 8px;">

            <b>   
                {* Имя пользоателя *}
                Чат1
            </b>
            <p>
                Пользователь: Lorem Ipsum...
            </p>
        </a><hr>
        <a href="" style="color: black; text-decoration: none;">
            {* Аватарка *}
            <img src="../themes/std/imgs/blankimg.jpg" width="50px" style="float: left; margin-right: 8px;">

            <b>   
                {* Имя пользоателя *}
                Чат2
            </b>
            <p>
                Пользователь: Lorem Ipsum...
            </p>
        </a><hr>
        <a href="" style="color: black; text-decoration: none;">
            {* Аватарка *}
            <img src="../themes/std/imgs/blankimg.jpg" width="50px" style="float: left; margin-right: 8px;">

            <b>   
                {* Имя пользоателя *}
                Чат3
            </b>
            <p>
                Пользователь: Lorem Ipsum...
            </p>
        </a>
    </div><br>
{/block}