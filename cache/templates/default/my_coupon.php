<? include handler('template')->file('header'); ?>
<div class="site-ms">
<div class="site-ms__left">
<? include handler('template')->file('my_menu'); ?>
<div class="t_area_out" style="border:none;">
<div class="t_area_in">
<script type="text/javascript">  
$(document).ready(function(){
$("#report tr:odd").addClass("odd");
$("#report tr:not(.odd)").hide();
$("#report tr:first-child").show();
$("#report tr.odd").click(function(){
$(this).next("tr").toggle();
$(this).find(".arrow").toggleClass("up");
});
});
//jquery 模拟点击打开新窗口
$("a[rel=external]").attr('target', '_blank');
</script>
<ul class="nleftL">
<div style="float:right;">
<li>分类：</li>
<li class="liL_<?=$_s1?>"><a href="?mod=me&code=coupon">全部</a></li>
<li class="liLine">|</li>
<li class="liL_<?=$_s2?>"><a href="?mod=me&code=coupon&status=0">未使用</a></li>
<li class="liLine">|</li>
<li class="liL_<?=$_s3?>"><a href="?mod=me&code=coupon&status=1">已使用</a></li>
<li class="liLine">|</li>
<li class="liL_<?=$_s4?>"><a href="?mod=me&code=coupon&status=2">已过期</a></li>
</div>
</ul>
<div class="nleftL">
<table id="report">
<tr>
<th><?=TUANGOU_STR?>券编号</th>
<th>产品名称</th>
<th>使用状态</th>
<th style="border-right:none;">操作</th>
</tr>
<? if(is_array($ticket_all)) { foreach($ticket_all as $i => $value) { ?>
<tr>
<td width="30%">
<span><?=$value['number']?><br/>密码：<?=$value['password']?></span></td>
<td width="30%"><?=$value['flag']?></td>
<td width="30%">
<? if($value['status']==0) { ?>
<img src="templates/default/images/no.gif" /> 未使用<? } elseif($value['status']==1) { ?><img src="templates/default/images/sue.gif" /> 已使用<? } elseif($value['status']==3) { ?><img src="templates/default/images/err.gif" /> 已作废
<? } else { ?><img src="templates/default/images/err.gif" /> 已过期
<? } ?>
</td>
<td width="10%"><div class="arrow"></div></td>
</tr>
<tr>
<td colspan="4">
<div class="order_info">
<h4>优惠详情</h4>
<p style="text-align:left; line-height:20px;"><?=$value['intro']?>！<br/>
<span style="float:left;">
<?=TUANGOU_STR?>券过期时间：<font color="red"><? echo date('Y-m-d', $value['perioddate']);; ?></font>
&nbsp;&nbsp;<font color="#009933">(<? echo DateLess($value['perioddate']-time(), 2);; ?> )</font>
</span>
<span style="float: right;">
<a href="?mod=me&code=printticket&id=<?=$value['ticketid']?>">打印<?=TUANGOU_STR?>券</a>
<? if(ini('coupon.c2phone.enabled')) { ?>
 - <a href="?mod=apiz&code=c2phone&cid=<?=$value['ticketid']?>">发送到手机</a>
<? } ?>
</span>
<? if($value['status']==1) { ?>
<br><span style="float:left;"><?=TUANGOU_STR?>券使用时间：<font color="blue"><?=$value['usetime']?></font></span>
<? } ?>
</p>
</div>
</td>
</tr>
<? } } ?>
</table>
<div class="pagem product_list_pager"><?=page_moyo()?></div>
</div>
</div>
</div>
</div>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>