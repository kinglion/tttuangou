<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->js('#admin/js/recharge.order.ops')?>
<div class="header"> <a href="?mod=recharge&code=order">充值订单列表</a> <font id="recharge_order_clean"></font> </div>
<?=ui('isearcher')->load('admin.recharge_order_list')?>
<table id="orderTable" cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <thead> <tr class="tr_nav"> <td width="15%">充值记录流水号</td> <td width="10%">充值用户</td> <td width="6%">充值金额</td> <td width="16%">支付方式/支付时间</td> <td width="8%">充值处理</td> </tr> </thead> <tbody> 
<? if(is_array($list)) { foreach($list as $one) { ?>
 <tr id="ro_on_<?=$one['id']?>"> <td>
<?=$one['orderid']?>
</td> <td><? echo app('ucard')->load($one['userid']); ?></td> <td>
<?=$one['money']?>
</td> <td>
<? if($one['payment'] > 0) { ?>
<? echo logic('pay')->misc()->ID2Name($one['payment']); ?>
<? } ?>
<br/>
<? if($one['paytime'] > 0) { ?>
支付时间：<? echo date('Y-m-d H:i:s', $one['paytime']); ?>
<? } else { ?>等待支付
<? } ?>
</td> <td>
<? if($one['paytime']==0) { ?>
<a href="javascript:rechargeOrderConfirm(<?=$one['orderid']?>);">[确认充值]</a>
<? } else { ?>充值成功
<? if($one['add_money'] > 0) { ?>
<br/>返现:<?=$one['add_money']?>元
<? } ?>
<? } ?>
</td> </tr> 
<? } } ?>
 </tbody> <tfoot> <tr> <td colspan="5"><?=page_moyo()?></td> </tr> </tfoot> </table>
<? include handler('template')->file('@admin/footer'); ?>