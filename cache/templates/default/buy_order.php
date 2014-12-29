<? include handler('template')->file('header'); ?>
<?=ui('loader')->css('@jquery.tipTip')?>
<?=ui('loader')->js('@jquery.tipTip')?>
<?=ui('loader')->js('@jquery.hook')?>
<?=ui('loader')->js('@jquery.form')?>
<script type="text/javascript">
function order_finish(url)
{
window.location.href = url;
}
</script>
<div class="site-ms">
<div class="site-ms__left">    
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title">请确认订单</p>
<div class="sect">
<table id="report">
<tr>
<th><?=TUANGOU_STR?>项目</th>
<th>数量</th>
<th>&nbsp;</th>
<th>价格</th>
<th>&nbsp;</th>
<th>总价</th>
</tr>
<tr>
<td width="35%"><?=$order['product']['flag']?></td>
<td width="10%" style="text-align:center;"><?=$order['productnum']?></td>
<td width="4%" style="text-align:center;">x</td>
<td width="12%" style="text-align:center;">&yen; <?=$order['productprice']?></td>
<td width="4%" style="text-align:center;">=</td>
<td width="15%" style="text-align:center;"><span class="B">&yen; <?=$order['price_of_product']?></span>
<p style="color:#999;"><?=$order['product']['weight']?> <?=$order['product']['weightunit']?></p>
</td>
</tr>
</table>
<? logic('address')->html($order) ?>

<? logic('express')->html($order) ?>

<? logic('attrs')->html($order) ?>
<div class="nleftL">
<p class="P_disa">总金额：<span id="totalmoney1"><?=$order['price_of_total']?></span>元</p>
<input type="hidden" id="totalmoney_1" value="<?=$order['price_of_total']?>">
</div>
<? logic('pay')->html($order) ?>
<div class="submit_div">
<form id="order_submit" action="?mod=buy&code=order&op=save" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<input id="order_id" name="order_id" type="hidden" value="<?=$order['orderid']?>" />
<? if($order['is_countdown'] == 1) { ?>
<? if($order['timelimit']>0) { ?>
<input id="order_submit_button" type="submit" class="btn btn-primary" value="确认订单，并支付" />
<span id="timeLimit"></span>
<? } else { ?><input id="order_submit_button" type="submit" class="btn btn-primary" value="抢购失败" disabled="disabled" />
<span id="timeLimit">支付超时导致订单失效</span>
<? } ?>
<? } else { ?><input id="order_submit_button" type="submit" class="btn btn-primary" value="确认订单，并支付" />
<? } ?>
<font id="submit_status"></font>
<? if($order['product']['type'] == 'stuff') { ?>
<input id="express_id" name="express_id" type="hidden" value="<?=$order['expresstype']?>">
<? } ?>
</form>
</div>
</div>
</div>
</div>      
</div>
<?=ui('loader')->js('@buy.order', UI_LOADER_ONCE)?>
<script type="text/javascript">fizinit();selectors();</script>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? if($order['is_countdown'] == 1) { ?>
<script type="text/javascript">
var timeLimit0 = parseInt("0<?=$order['timelimit']?>");
function timeLimit_refresh(){
timeStr = "";
if(timeLimit0 >= 60){
minute = Math.floor(timeLimit0 / 60);
}else if(timeLimit0 >0){
minute = 0;
}else{
document.getElementById("timeLimit").innerHTML = "支付超时导致订单失效";
document.getElementById("order_submit_button").disabled = "disabled";
document.getElementById("order_submit_button").value = "抢购失败";
return false;
}
timeStr = "剩余时间：" + minute +":"+ Math.floor(timeLimit0 - minute*60) + "（过时后将禁止支付，并将商品重新开放给其他人购买）";
document.getElementById("timeLimit").innerHTML = timeStr;
timeLimit0 = timeLimit0 - 0.25;
}
setInterval(timeLimit_refresh,250);
</script>
<? } ?>
<? include handler('template')->file('footer'); ?>