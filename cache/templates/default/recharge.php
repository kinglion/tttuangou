<? include handler('template')->file('header'); ?>
<script type="text/javascript">
function checkRecharge()
{
var money = Math.round($('#recharge_money').val()*100)/100;
if (isNaN(money))
{
foundError('充值金额必须是一个有效数字！');
return false;
}
if (money <= 0)
{
foundError('充值金额必须大于0！');
return false;
}
return true;
}
function foundError(msg)
{
$('#error_msg').html(msg).css('color', '#f76120');
setTimeout(function(){$('#error_msg').css('color', '')}, 2000);
}
</script>
<div class="site-ms">
<div class="site-ms__left">
<div class="ts_menu_2">
<ul>
<li class="ts3_mbtn1"><a href="?mod=recharge"><div>我要充值</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=cash"><div>我要提现</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=recharge&code=order"><div>充值记录</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=cash&code=order"><div>提现记录</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=me&code=bill"><div>收支明细</div></a></li>
</ul>
</div>
<div class="t_area_out" style="border:none">
<div class="t_area_in">
<p class="cur_title" >帐户充值</p>
<div class="sect"  >
<div class="nleftL" >
<form action="?mod=recharge&code=order&op=save" method="post"  onsubmit="return checkRecharge();" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<div class="field">
<label style=" overflow:hidden;">请输入充值金额</label>
<input id="recharge_money" name="money" type="text" class="f-l" style="_height:27px;"/>&nbsp;<input type="submit" class="btn btn-primary"  value="下一步" />
</div>
</form>
<? if($upcfg['percentage'] > 0) { ?>
<div class="field">在本站使用非充值卡充值，则可额外返现<?=$upcfg['percentage']?>%，例如充值100元，则额外赠送<?=$upcfg['percentage']?>元。</div>
<? } ?>
<div class="field"><p id="error_msg"></p></div>
<div class="field"><a href="?mod=recharge&code=card&op=redirect">使用充值卡</a></div>
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