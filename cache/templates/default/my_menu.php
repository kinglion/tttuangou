<? $_m1=$_m2=$_m3=$_m4=$_m5=$_m6=$_m7=$_m8=2;
$code = $this->Code;
if ($code == '' || $code == 'coupon') $_m1=1;
if ($code == 'order') $_m2=1;
if ($code == 'bill') $_m3=1;
if ($code == 'setting') $_m4=1;
if ($code == 'address') $_m5=1;
if ($code == 'favorite') $_m6=1;
if ($code == 'rebate') $_m7=1;
if ($code == 'credit') $_m8=1;
 ?>
<div class="ts_menu_2">
<ul>
<li class="ts3_mbtn<?=$_m1?>"><a href="?mod=me&code=coupon"><div>我的<?=TUANGOU_STR?>券</div></a></li>
<li class="ts3_mbtn<?=$_m2?>"><a href="?mod=me&code=order"><div>我的订单</div></a></li>
<li class="ts3_mbtn<?=$_m3?>"><a href="?mod=me&code=bill"><div>收支明细</div></a></li>
<li class="ts3_mbtn<?=$_m6?>"><a href="?mod=me&code=favorite"><div>我的收藏</div></a></li>
<li class="ts3_mbtn<?=$_m4?>"><a href="?mod=me&code=setting"><div>账户设置</div></a></li>
<li class="ts3_mbtn<?=$_m5?>"><a href="?mod=me&code=address"><div>收货地址</div></a></li>
<!--<li class="ts3_mbtn<?=$_m7?>"><a href="?mod=me&code=rebate"><div>我的返利</div></a></li>-->
<!--<li class="ts3_mbtn<?=$_m8?>"><a href="?mod=me&code=credit"><div>我的积分</div></a></li>-->
</ul>
</div>