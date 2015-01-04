<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->js('@jquery.thickbox')?>
<?=ui('loader')->css('@jquery.thickbox')?>
<?=ui('loader')->js('#admin/js/coupon.ops')?>
<script type="text/javascript">
var __Global_OID = "<?=$order['orderid']?>";
var __ORDER_PAID = <? echo $order['pay'] ? 'true' : 'false'; ?>;
</script> <div class="header"> <b>处理订单</b> </div> <table id="orderTable" cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tbody> <tr> <td class="tr_nav tr_center" colspan="4">
基本信息
</td> </tr> <tr> <td class="td_title">商品名称：</td> <td class="td_content"><?=$order['product']['flag']?></td> <td class="td_title">商品状态：</td> <td class="td_content"><? echo logic('product')->STA_Name($order['product']['status']); ?></td> </tr> <tr> <td class="td_title">订单编号：</td> <td class="td_content"><?=$order['orderid']?></td> <td class="td_title">下单会员：</td> <td class="td_content"><? echo app('ucard')->load($user['id']); ?></td> </tr> <tr> <td class="td_title">订单状态：</td> <td class="td_content"><? echo logic('order')->STA_Name($order['status']); ?></td> <td class="td_title">下单时间：</td> <td class="td_content"><? echo date('Y-m-d H:i:s', $order['buytime']); ?></td> </tr> <tr> <td class="td_title">订单处理进程：</td> <td class="td_content"><? echo logic('order')->PROC_Name($order['process']); ?></td> <td class="td_title">支付时间：</td> <td class="td_content">
<? if($order['pay'] == 1) { ?>
<? echo $order['paytime'] > 0 ? date('Y-m-d H:i:s', $order['paytime']) : '已支付'; ?>
<? } else { ?>未支付
<? } ?>
</td> </tr>
<? if($order['attrs']) { ?>
<tr> <td class="tr_nav tr_center" colspan="4">
属性信息
</td> </tr> <tr> <td class="td_title">已选：</td> <td class="td_content" colspan="3">
<? if(is_array($order['attrs']['dsp'])) { foreach($order['attrs']['dsp'] as $dsp) { ?>
<?=$dsp['name']?> - &yen;<?=$dsp['price']?><br/>
<? } } ?>
</td> </tr>
<? } ?>

<? if($order['paytype'] > 0) { ?>
<tr> <td class="tr_nav tr_center" colspan="4">
支付信息
</td> </tr> <tr> <td class="td_title">支付方式：</td> <td class="td_content"><?=$payment['name']?></td> <td class="td_title">交易号：</td> <td class="td_content"><?=$paylog['0']['trade_no']?></td> </tr> <tr> <td class="td_title">支付详情：</td> <td class="td_content"> <a href="#TB_inline?&height=100&width=300&inlineId=paylog" class="thickbox" title="支付日志">点此查看支付日志</a> <font class="small">(<? echo count($paylog); ?> 个支付环节)</font> <div id="paylog"> <div class="paylog"> <ul>
<? if(is_array($paylog)) { foreach($paylog as $i => $log) { ?>
<li>时间：<? echo date('Y-m-d H:i:s', $log['time']); ?>，状态：<? echo logic('order')->PROC_Name($log['status']); ?></li>
<? } } ?>
</ul> </div> </div> </td> <td class="td_title">订单金额：</td> <td class="td_content"><?=$order['totalprice']?></td> </tr> <tr> <td class="td_title">支付时间：</td> <td class="td_content">
<? if($order['pay'] == 1) { ?>
<? echo date('Y-m-d H:i:s', $order['paytime']); ?>
<? } else { ?>未支付
<? } ?>
</td> <td class="td_title">支付金额：</td> <td class="td_content">
<? if($order['pay'] == 1) { ?>
<?=$order['paymoney']?>
<? } else { ?>还未支付
<? } ?>
</td> </tr>
<? } ?>
<? if($order['product']['type'] == 'ticket') { ?>
<tr> <td class="tr_nav tr_center" colspan="4">
<?=TUANGOU_STR?>券信息
</td> </tr> <tr> <td class="td_title"><?=TUANGOU_STR?>券总数：</td> <td class="td_content"><? echo count($coupons); ?></td> <td class="td_title">过期时间：</td> <td class="td_content"><? echo date('Y-m-d H:i:s', $order['product']['perioddate']); ?></td> </tr> <tr> <td class="td_title">详情：</td> <td class="td_content"> <a href="#TB_inline?&height=200&width=400&inlineId=couponlist" class="thickbox" title="<?=TUANGOU_STR?>券列表">点此查看<?=TUANGOU_STR?>券</a> <div id="couponlist"> <div class="coupons"> <ul>
<? if(is_array($coupons)) { foreach($coupons as $i => $coupon) { ?>
<li id="cp_on_<?=$coupon['ticketid']?>">
号码：<?=$coupon['number']?>，密码：<?=$coupon['password']?>
<font style="float:right;">
操作：
<? if($coupon['status'] == TICK_STA_Unused) { ?>
<a href="javascript:couponReissue(<?=$coupon['ticketid']?>);">补发通知</a>
<? } else { ?><strike><? echo logic('coupon')->STA_Name($coupon['status']); ?></strike>
<? } ?>
 - <a href="javascript:couponDelete(<?=$coupon['ticketid']?>);">删除</a> </font> </li>
<? } } ?>
</ul> </div> </div> </td> <td class="td_title">管理：</td> <td class="td_content"> <a href="?mod=coupon&code=add&uid=<?=$order['userid']?>&pid=<?=$order['productid']?>&oid=<?=$order['orderid']?>">添加<?=TUANGOU_STR?>券</a> </td> </tr>
<? if(count($coupons) == 0 && $order['pay'] == ORD_PAID_Yes) { ?>
<tr> <td class="tr_center" colspan="4"><font style="color:#FF2C00;font-weight:bold;">重要提示</font> &nbsp;-&nbsp; <a href="#show_help" onclick="javascript:$('#help_of_no_coupon').toggle();return false;">点此查看</a></td> </tr> <tr class="tips" id="help_of_no_coupon" style="display:none;background:#FFEDB2;"> <td colspan="4">
1. 产品成团后才会生成<?=TUANGOU_STR?>券（达到指定人数）<br/>
2. 如果您使用的是支付宝担保交易接口或者支付宝双接口，且本订单状态为“等待收货”，请联系您的买家，让其到支付宝进行确认收货操作，之后系统会自动生成<?=TUANGOU_STR?>券<br/>
3. 如果您想让用户付款到支付宝的时候就生成<?=TUANGOU_STR?>券，请到“全局设置”-“支付设置”中启用“先行发送<?=TUANGOU_STR?>券”功能<br/>
4. 支付宝担保交易接口，用户会首先付款到支付宝平台，这时您的支付宝账户是没有这笔钱的，只有用户进行了确认收货操作，这笔钱才会从支付宝平台转到您的支付宝账户<br/>
5. 用户付款到第三方平台，我们即认为用户已经付款完毕，“实付（支付）金额”便为用户支付金额
</td> </tr>
<? } ?>
<? } elseif($order['product']['type'] == 'stuff') { ?><tr> <td class="tr_nav tr_center" colspan="4">
配送信息
</td> </tr> <tr> <td class="td_title">配送方式：</td> <td class="td_content"><?=$express['name']?>&nbsp;&nbsp;&nbsp;&nbsp;<font color="#cccccc">( <? echo logic('express')->CID2Name($express['express']); ?> )</font></td> <td class="td_title">运费：</td> <td class="td_content"><?=$order['expressprice']?></td> </tr> <tr> <td class="td_title">收货地址：</td> <td class="td_content" colspan="2"><?=$address['region']?> <?=$address['address']?></td> <td class="td_content">邮编：<?=$address['zip']?></td> </tr> <tr> <td class="td_title">收货人：</td> <td class="td_content"><?=$address['name']?></td> <td class="td_title">联系电话：</td> <td class="td_content"><?=$address['phone']?></td> </tr>
<? } ?>
<tr> <td class="tr_nav tr_center" colspan="4">
额外信息
</td> </tr> <tr> <td class="td_title">买家留言：</td> <td class="td_content" colspan="3"><?=$order['extmsg']?></td> </tr> <tr> <td class="td_title">回复买家：</td> <td class="td_content" colspan="3" title="（前台用户可在“我的订单”中看到）"> <input id="extmsg_reply" type="text" title="<?=$order['extmsg_reply']?>" value="<?=$order['extmsg_reply']?>" /> <input id="extmsg_reply_btn" type="button" value="保存" onclick="OrderExtmsgReply()" /> </td> </tr> <tr> <td class="tr_nav tr_center" colspan="4">
操作信息
</td> </tr> <tr> <td class="td_title">订单备注：</td> <td class="td_content" colspan="3" title="（仅供管理员在后台查看）"> <input id="remark" type="text" title="<?=$order['remark']?>" value="<?=$order['remark']?>" /> <input id="remark_btn" type="button" value="保存" onclick="OrderRemark()" /> </td> </tr> <tr> <td class="td_title">管理操作备注：</td> <td class="td_content" colspan="3"> <textarea id="opmark"></textarea> </td> </tr> <tr> <td class="td_title">当前可执行操作：</td> <td class="td_content" colspan="3">
<? if($order['product']['type'] == 'stuff' && $order['process'] == 'WAIT_SELLER_SEND_GOODS' && $order['status'] == ORD_STA_Normal) { ?>
<input class="button" type="button" onclick="javascript:window.location='?mod=delivery&code=process&oid='+__Global_OID;" value="发货" />
<? } ?>

<? if($order['pay'] == ORD_PAID_Yes) { ?>
<? if($order['status'] == ORD_STA_Normal || $order['status'] == ORD_STA_Failed) { ?>
<input class="service" type="button" href="?mod=order&code=refund" value="退款" title="退款金额会自动充值到用户帐户余额，订单会自动标记为【已退款】" />
<? } ?>
<? } ?>
<? if($order['pay'] == ORD_PAID_No && $order['status'] == ORD_STA_Normal) { ?>
<input class="service" type="button" href="?mod=order&code=confirm" value="确认付款" title="确认订单后，系统会自动发送<?=TUANGOU_STR?>券，实物会显示等待发货" />
<? } ?>

<? if($order['status'] == ORD_STA_Normal && $order['process'] != 'TRADE_FINISHED') { ?>
<input class="service" type="button" href="?mod=order&code=cancel" value="取消订单" title="取消订单后，将不能再对订单进行任何操作（可删除）" />
<? } ?>

<? if($order['process'] == 'TRADE_FINISHED') { ?>
<input class="service" type="button" href="?mod=order&code=afservice" value="售后服务" title="事件通知管理系统会自动将操作备注作为售后信息发送至用户（需开启相关事件通知开关）" />
<? } ?>

<? if($order['status'] == ORD_STA_Refund && $order['process'] != 'TRADE_FINISHED') { ?>
<input class="service" type="button" href="?mod=order&code=ends" value="结单" title="结单后会将订单状态更新为【交易完成】" />
<? } ?>

<? if($order['status'] == ORD_STA_Cancel || $order['status'] == ORD_STA_Overdue) { ?>
<input class="service" type="button" href="?mod=order&code=reset" value="重启订单" title="重新启用订单后，您才可以对该订单进行其他操作" />
<? } ?>

<? if(true) { ?>
<input class="service" type="button" href="?mod=order&code=delete" value="删除订单" title="删除订单时会删除相关的<?=TUANGOU_STR?>券信息和发货信息" />
<? } ?>
<font id="service_result" style="margin-left: 10px;"></font> </td> </tr> <tr> <td class="tr_nav tr_center" colspan="4">
操作记录
</td> </tr> <tr> <td><b>操作者</b></td> <td><b>操作时间</b></td> <td colspan="2" width="50%"><b>备注</b></td> </tr>
<? if(is_array($clog)) { foreach($clog as $i => $log) { ?>
<tr> <td><? echo $log['uid'] ? user($log['uid'])->get('name') : '<font color="#cccccc">[ 系统 ]</font>'; ?></td> <td><? echo date('Y-m-d H:i:s', $log['time']); ?></td> <td colspan="2"><?=$log['remark']?></td> </tr>
<? } } ?>
</tbody> </table> <div id="service_refund_area" style="display: none;">
注意：您正在进行退款操作（取消已支付的订单也需要退款）
<hr style="margin:10px auto;border:1px solid #ccc;"/>
退款金额：<input id="service_refund_money" type="text" style="border:1px solid #999;font-size:15px;color:#000;padding:3px;" value="<?=$order['paymoney']?>" /> <a href="#refund_money_clear" onclick="javascript:$('#service_refund_money').val(0);return false;">[ 清零 ]</a> <hr style="margin:10px auto;border:1px solid #ccc;"/> <b>退款前，请一定要确认您已经收到了用户付过来的款项！</b> </div> <a href="?<?=$referrer?>" class="back1 back2">返回订单列表</a>
<? include handler('template')->file('@admin/footer'); ?>