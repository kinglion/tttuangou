<? include handler('template')->file('header'); ?>
<?=ui('loader')->js('@jquery.hook')?>
<div class="site-ms">
<div class="site-ms__left">
<div class="ts_menu_2">
<ul>
<li class="ts3_mbtn1"><a href="?mod=recharge"><div>我要充值</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=cash"><div>我要提现</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=recharge&code=order"><div>充值记录</div></a></li>
<li class="ts3_mbtn2"><a href="?mod=cash&code=order"><div>提现记录</div></a></li>
</ul>
</div>
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title" >支付页面</p>
<div class="sect"  >
<div class="nleftL " id="zf_nleftL" >
<div class="field" >
<label>订单编号：</label>
<span><?=$order['orderid']?></span>
</div>
<div class="field">
<label>充值金额：</label>
<span><?=$order['money']?></span>
</div>
<div>
<?=$payment_linker?>
</div>
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