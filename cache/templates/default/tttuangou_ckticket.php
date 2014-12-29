<? include handler('template')->file('header'); ?>
<div class="site-ms">
<div class="site-ms__left">
<? if($sellerid > 0) { ?>
<div class="ts_menu_2">
<ul>
<li class="ts3_mbtn2"><a href="?mod=seller&code=product&op=list">产品列表</a></li>
<li class="ts3_mbtn2"><a href="?mod=fund">我要结算</a></li>
<li class="ts3_mbtn2"><a href="?mod=fund&code=order">结算记录</a></li>
<li class="ts3_mbtn2"><a href="?mod=fund&code=money">结算金额明细</a></li>
<li class="ts3_mbtn1"><a href="?mod=list&code=ckticket"><?=TUANGOU_STR?>券验证</a></li>
</ul>
</div>
<? } ?>
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title"><?=TUANGOU_STR?>券查询</p>
<div class="sect">
<form action="<?=$action?>" method="post"  enctype="multipart/form-data">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<div id="ck_product_name"></div>
<div class="nleftL">
<div class="field">
<label><?=TUANGOU_STR?>券编号：</label>
<input type="text" id="number" name="number" value="" class="f_input input_h"  size="30">
<span id="status" class="hint">请输入<?=TUANGOU_STR?>券编号</span>
</div>
<div class="field">
<label><?=TUANGOU_STR?>券密码：</label>
<input type="text" id="password" name="password" class="f_input input_h"  size="30">
</div>
<div class="actbtn">
<input type="button" id="btn_tickCheck" class="btn" name='submit'  value="查询">
<? if($sellerid > 0) { ?>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="btn_tickUse" class="btn btn-primary" name='submit'  value="消费">
<? } ?>
</div>
</div>
<div class="nleftL">
<div class="field">
<? $wap_url = ini('settings.site_url').rewrite('/index.php?mod=wap') ?>
<br/>
您也可以通过手机访问 <a href="<?=$wap_url?>" style="font-weight:bold;"><?=$wap_url?></a> 进行<?=TUANGOU_STR?>券验证
</div>
</div>
</form>
</div>
</div>
</div>
</div> 
<script type="text/javascript">
var ms_url = '<?=$action?>';
function tickCheck()
{
var num = $('#number').val();
if (num.length != 9 && num.length != 12 && num.length != 16)
{
status('<font class="R">请输入正确的<?=TUANGOU_STR?>券编号！</font>');
return;
}
status('正在查询中...');
$.get(ms_url+'&do=check&number='+$('#number').val()+'&timer='+(new Date()).getTime(), function(data){
status(data);
});
}
function tickMakeUse()
{
var num = $('#number').val();
if (num.length != 9 && num.length != 12 && num.length != 16)
{
status('<font class="R">请输入正确的<?=TUANGOU_STR?>券编号！</font>');
return;
}
var password = $('#password').val();
if (password.length != 3 && password.length != 6)
{
status('<font class="R">请输入正确的<?=TUANGOU_STR?>券密码！</font>');
return;
}
if (!confirm('您确认要消费此<?=TUANGOU_STR?>券吗？')) return;
status('正在登记中...');
$.get(ms_url+'&do=makeuse&number='+$('#number').val()+'&password='+$('#password').val()+'&timer='+(new Date()).getTime(), function(data){
status(data);
});
}
function tickGetProductName()
{
var num = $('#number').val();
if (num.length != 9 && num.length != 12 && num.length != 16)
{
return;
}
$('#ck_product_name').html('正在查询产品名称...');
$.get(ms_url+'&do=getname&number='+num+'&timer='+(new Date()).getTime(), function(data){
$('#ck_product_name').hide();
$('#ck_product_name').html(data);
PNDiv_Position_Show();
});
}
function status(html, color)
{
$('#status').html(html);
}
$(document).ready(function(){
//$('#btn_tickCheck').bind('click', function(){tickCheck()});
$('#btn_tickUse').bind('click', function(){tickMakeUse()});
$('#number').bind('blur', function(){tickGetProductName();tickCheck();});
});
function PNDiv_Position_Show()
{
var iH = $('#ck_product_name').outerHeight();
var iT = $('#number').position().top-iH-10+'px';
var iL = $('#number').position().left+'px';
$('#ck_product_name').css('top', iT);
$('#ck_product_name').css('left', iL);
$('#ck_product_name').slideDown();
}
</script>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>