<div class="t_area_out ">
<? if(MEMBER_ID < 1) { ?>
<h1>会员登录</h1>
<div class="t_area_in">
<a href="?mod=account&code=login">我要登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?mod=account&code=register">我要注册</a>
</div>
<? } else { ?><? $forbidmoney = intval(user()->get('forbid_money')); ?>
<h1>我的账户</h1>
<div class="t_area_in">
账户余额： <font style="font-weight:bold;font-size:2em;color:#f76120;"><?=user()->get('money')?></font><br>
<? if($forbidmoney > 0) { ?>
冻结资金： <font style="font-weight:bold;font-size:2em;color:#666666;"><?=user()->get('forbid_money')?></font><br>
<? } ?>
<p style="padding:10px 0px 0px 0;"><a href="?mod=recharge">我要充值</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?mod=cash">我要提现</a></p>
</div>
<? } ?>
</div>