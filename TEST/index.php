<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0
Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        {literal}
        div.messages {
            width:800px;
        }
        div.parent {
            border:1px solid #888888;
            margin:20px 0 0 0;
            padding:10px;
        }
        div.parent div.message {
            margin:10px 10px 10px 30px;
        }
        div.child {
            border-top:1px solid #888888;
            margin:10px 10px 0 30px;
            padding:10px;
        }
        div.child div.message {
            margin:10px 10px 10px 30px;
        }
        span.message {
            color:#FF0000;
        }
        form {
            display:inline;
            margin:0;
            padding:0;
        }
        {/literal}
    </style>
</head>
<body>

<form method="post" action="/sample/system/htdocs/bbs/regist">
    名前<br /><input type="text" name="name" size="50" /><br />
    タイトル<br /><input type="text" name="title" size="50" /><br />
    本文<br /><textarea name="contents" cols="50" rows="8"></textarea><br />
    <input type="hidden" name="parent_no" value="{$parent_no}" />
    <input type="submit" name="write" value="書き込む" />
    {if $parent_no != ""}
    <span class="message">No.{$parent_no}への返信です</span>
    {/if}
</form>

<div class="messages">

    {foreach from=$threads item=parent}
    <div class="parent">
        <div class="header">
            No.{$parent.no}　{$parent.title}　投稿者名：{$parent.name}
            <form method="post" action="/sample/system/htdocs/bbs/res">
                <input type="hidden" name="parent_no" value="{$parent.no}" />
                <input type="submit" name="res" value="返信" />
            </form>
            <form method="post" action="/sample/system/htdocs/bbs/delete">
                <input type="hidden" name="no" value="{$parent.no}" />
                <input type="submit" name="del" value="削除" />
            </form>
        </div>
        <div class="message">{$parent.contents}</div>
        {foreach from=$parent.res item=res}
        <div class="child">
            <div class="header">
                {$res.title}　　{$res.name}
                <form method="post" action="/sample/system/htdocs/bbs/delete">
                    <input type="hidden" name="no" value="{$res.no}" />
                    <input type="submit" name="del" value="削除" />
                </form>
            </div>
            <div class="message">{$res.contents}</div>
        </div>
        {/foreach}
    </div>
    {/foreach}

</div>

</body>
</html>