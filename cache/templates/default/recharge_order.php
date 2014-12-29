<? include handler('template')->file('header'); ?>
<?=ui('loader')->js('@jquery.hook')?>
<div class="site-ms">
<div class="site-ms__left">
<div class="ts_menu_2">
<ul>
<li class="ts3_mbtn<?=$navcss1?>"><a href="?mod=recharge"><div>我要充值</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=cash"><div>我要提现</div></a></li>
<li class="ts3_mbtn<?=$navcss2?>"><a href="?mod=recharge&code=order"><div>充值记录</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=cash&code=order"><div>提现记录</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=me&code=bill"><div>收支明细</div></a></li>
</ul>
</div>
<div class="t_area_out" style="border:none;">
<div class="t_area_in">
<? if($order_list) { ?>
<ul class="nleftL">
<font style="font-size:20px;">充值记录</font>
<div style="float: right;">
<li>分类:</li>
<li class="liL_<?=$tabcssall?>"><a href="?mod=recharge&code=order">全部</a></li>
<li class="liLine">|</li>
<li class="liL_<?=$tabcssyes?>"><a href="?mod=recharge&code=order&pay=yes">充值成功</a></li>
<li class="liLine">|</li>
<li class="liL_<?=$tabcssno?>"><a href="?mod=recharge&code=order&pay=no">等待付款</a></li>
</div>
</ul>
<div class="nleftL">
<style>td.line{text-align:center;border-bottom:1px dashed #aaa;height:46px;}</style>
<table style="width:100%">
<tr style="text-align:center;height:33px;background: #f2f2f2;">
<td>充值记录流水号</td>
<td width="150">充值金额</td>
<td width="250">支付方式/支付时间</td>
<td width="120">充值状态</td>
</tr>
<? if(is_array($list)) { foreach($list as $one) { ?>
<tr>
<td class="line"><?=$one['orderid']?></td>
<td class="line"><?=$one['money']?></td>
<td class="line">
<? if($one['payment'] > 0) { ?>
<? echo logic('pay')->misc()->ID2Name($one['payment']); ?><br/>
<? } ?>

<? if($one['paytime'] > 0) { ?>
支付时间：<? echo date('Y-m-d H:i:s', $one['paytime']); ?>
<? } else { ?>等待付款
<? } ?>
</td>
<td class="line">
<? if($one['paytime']==0) { ?>
<? if($one['payment']==0) { ?>
<a href="?mod=recharge&code=order&id=<?=$one['orderid']?>">去付款</a>
<? } else { ?><a href="?mod=recharge&code=pay&id=<?=$one['orderid']?>&ibank=">去付款</a>
<? } ?>
&nbsp;|&nbsp;<a href="?mod=recharge&code=del&id=<?=$one['orderid']?>">取消充值</a>
<? } else { ?>充值成功
<? if($one['add_money'] > 0) { ?>
<br>返现:<?=$one['add_money']?>元
<? } ?>
<? } ?>
</td>
</tr>
<? } } ?>
</table>
<div class="pagem product_list_pager"><?=page_moyo()?></div>
</div>
<? } else { ?><p class="cur_title" >充值方式</p>
<div class="sect"  >
<div class="nleftL" >
<form action="?mod=recharge&code=payment&op=save&id=<?=$order['orderid']?>" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<div class="field">
<label>订单编号：</label>
<span style=" display:block; padding-top:5px;"><?=$order['orderid']?></span>
</div>
<div class="field">
<label>充值金额：</label>
<span style=" display:block; padding-top:5px;"><?=$order['money']?></span>
</div>
<div class="field">
<? logic('pay')->html($order) ?>
</div>
<div class="field">
<input type="submit" class="btn btn-primary"  value="下一步" />
</div>
</form>
</div>
</div>
<? } ?>
</div>
</div>
</div>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>