<? include handler('template')->file('header'); ?>
<div class="site-ms">
<div class="site-ms__left">
<div class="t_area_out">
<div class="t_area_in" style="overflow:hidden;_width:695px; _height:100%">
<p class="cur_title">取消订阅</p>
<div class="sect">
<p class="B2">订阅本站可以第一时间获得最新<?=TUANGOU_STR?>信息。</p>
<div class="enter_address" style="width:88%;">
请输入您的邮件地址或者手机号码：
<form action="?mod=subscribe&code=undo&op=confirm" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<input name="target" type="text" class="f_input" value="<?=$target?>" /> <input type="submit" value="确认" class="btn btn-primary" style=" margin-left:20px;" />
</form>
</div>
</div>
</div>
</div>
</div>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>