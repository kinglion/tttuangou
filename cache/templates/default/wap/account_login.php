<? include handler('template')->file('@wap/header'); ?>
<? if($errmsg) { ?>
<?=$errmsg?><hr/>
<? } ?>
<form action="?mod=wap&code=account&op=logcheck" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
账号：<input type="text" name="username" /><br/>
密码：<input type="password" name="password" /><br/>
<input type="submit" value="登录" />
</form>
<? include handler('template')->file('@wap/footer'); ?>