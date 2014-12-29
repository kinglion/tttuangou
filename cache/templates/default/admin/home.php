<? include handler('template')->file('@admin/header'); ?>
 
 
<? if($statistic) { ?>
 <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder datacount"> <tr class="header"> <td colspan="6"> <div class="NavaL nkj">今日收益</div> </td> </tr> <tr> <td>今日订单：<b><a href="admin.php?mod=order&code=vlist&iscp_tv_area=order_main&iscp_tvfield_order_main=ordbt&iscp_tvbegin_order_main=<?=$dateYmd?>&iscp_tvfinish_order_main=<?=$dateYmd?>"><?=$statistic['today_orders']?></a></b></td> <td>今日付款订单：<b><a href="admin.php?mod=order&code=vlist&iscp_tv_area=order_main&iscp_tvfield_order_main=ordbt&ordproc=__PAY_YET__&iscp_tvbegin_order_main=<?=$dateYmd?>&iscp_tvfinish_order_main=<?=$dateYmd?>"><?=$statistic['today_pay_orders']?></a></b></td> <td>今日未付款订单：<b><a href="admin.php?mod=order&code=vlist&ordproc=WAIT_BUYER_PAY&iscp_tv_area=order_main&iscp_tvfield_order_main=ordbt&iscp_tvbegin_order_main=<?=$dateYmd?>&iscp_tvfinish_order_main=<?=$dateYmd?>"><?=$statistic['today_unpay_orders']?></a></b></td> <td>今日收益：<b><?=$statistic['today_income_orders']?></b> <a href="admin.php?mod=reports&code=view&service=payment"> (前期收益)</a></td> <td></td> <td></td> </tr> </table> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder datacount"> <tr class="header"> <td colspan="6"> <div class="NavaL nkj">网站数据统计</div> </td> </tr> <tr> <td>用户数：<b><a href="<?=$statistic['system_members']['url']?>"><?=$statistic['system_members']['total']?></a></b></td> <td>商家数：<b><a href="<?=$statistic['tttuangou_seller']['url']?>"><?=$statistic['tttuangou_seller']['total']?></a></b></td> <td>城市数：<b><a href="<?=$statistic['tttuangou_city']['url']?>"><?=$statistic['tttuangou_city']['total']?></a></b></td> <td>订阅数：<b><a href="<?=$statistic['tttuangou_subscribe']['url']?>"><?=$statistic['tttuangou_subscribe']['total']?></a></b></td> <td>问答数：<b><a href="<?=$statistic['tttuangou_question']['url']?>"><?=$statistic['tttuangou_question']['total']?></a></b></td> <td>反馈信息：<b><a href="<?=$statistic['tttuangou_usermsg']['url']?>"><?=$statistic['tttuangou_usermsg']['total']?></a></b></td> </tr> <tr> <td>产品数：<b><a href="<?=$statistic['tttuangou_product']['url']?>"><?=$statistic['tttuangou_product']['total']?></a></b></td> <td>订单数：<b><a href="<?=$statistic['tttuangou_order']['url']?>"><?=$statistic['tttuangou_order']['total']?></a></b></td> <td><?=TUANGOU_STR?>券：<b><a href="<?=$statistic['tttuangou_ticket']['url']?>"><?=$statistic['tttuangou_ticket']['total']?></a></b></td> <td>等待发货：<b><a href="<?=$statistic['express_wait_count']['url']?>"><?=$statistic['express_wait_count']['total']?></a></b></td> <td>邮件队列：<b><a href="<?=$statistic['cron_length']['url']?>"><?=$statistic['cron_length']['total']?></a></b></td> <td>数据库：<b><a href="<?=$statistic['data_length']['url']?>"><?=$statistic['data_length']['total']?></a></b></td> </tr> </table> 
<? } ?>
  
<? if($check_upgrade) { ?>
 <script language="JavaScript" type="text/javascript" src="admin.php?mod=upgrade&code=check&js=1"></script> 
<? } ?>
 <script type="text/javascript">
$(document).ready(function()
{
$.get('admin.php?mod=index&code=recommend', function(data)
{
if (data != '')
{
$('#recommend_tabler').show();
$('#recommend').html(data);
}
});
$.get('admin.php?mod=index&code=upgrade_check', function(data){
if (data != 'noups')
{
$('#ups_alert').html(''+data+' &gt;&gt;&gt; <a href="admin.php?mod=upgrade"><font id="ups_alert_light" style="color:red;font-weight:bold;font-size:13px;">点此进行在线升级</font></a>');
}
else
{
$('#ups_alert').html('已是最新版本');
}
});
if (typeof(lrcmd) != 'undefined' && typeof(lrcmd) == 'string')
{
$.get('admin.php?mod=index&code=lrcmd_nt&lv='+lrcmd, function(data){
if (data != 'false')
{
$('#lic_recommend').html(data).slideDown();
}
});
}
$.get('admin.php?mod=wips&code=status&op=ajax&stamp=<? echo time(); ?>', function(html){
$('#wips-status').html(html);
});
});
</script>
<? include handler('template')->file('@admin/footer'); ?>