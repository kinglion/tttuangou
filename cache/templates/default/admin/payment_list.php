<? include handler('template')->file('@admin/header'); ?>
 <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td>技巧提示</td> </tr> <tr class="altbg1"> <td><ul> <li>1、支付宝虽然仅对团购站提供“担保交易”，但支付宝拥有最多的在线支付用户，做团购还是必须启用，<A HREF="<?=ihelper('tg.payment.alipay')?>" target=_blank><font color=blue>点此申请支付宝</font></a>。</li> <li>2、<A HREF="<?=ihelper('tg.payment.wangyin')?>" target=_blank><font color=red>【独家】全新“网银直连”支付接口</font>，款项即时到账（落袋为安），个人和企业团购网站都可用，按笔支付费率只有0.55%，比支付宝1.2%费率的一半还低。</a></li> </ul></td> </tr> </table> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="5">在线支付接口设置</td> </tr> <tr> <td width="20%" bgcolor="#F4F8FC">支付接口名称</td> <td width="40%" bgcolor="#F4F8FC">支付平台介绍（前台显示，支持html代码）</td> <td width="10%" bgcolor="#F4F8FC">前台显示顺序</td> <td width="10%" bgcolor="#F4F8FC">启用状态</td> <td width="10%" align="center" bgcolor="#F4F8FC">管理</td> </tr> 
<? if(is_array($list)) { foreach($list as $i => $value) { ?>
<? if (isset($list_local[$value['code']])) unset($list_local[$value['code']]); ?>
<tr> <td class="td-input-w100"> <font class="dbf" src="id:<?=$value['id']?>@payment/name"><?=$value['name']?></font> </td> <td class="td-input-w100"> <font class="dbf" src="id:<?=$value['id']?>@payment/detail"><?=$value['detail']?></font> </td> <td> <font class="dbf" src="id:<?=$value['id']?>@payment/order"><?=$value['order']?></font> </td> <td> <font class="dbf" src="id:<?=$value['id']?>@payment/enabled"><?=$value['enabled']?></font> </td> <td align="center">
[ <? echo $this->Config_link($value['code']); ?> ]<br/>
[ <a href="?mod=reports&code=view&service=payment&hoster=<?=$value['id']?>">财务报表</a> ]
</td> </tr> 
<? } } ?>
 
<? if(is_array($list_local)) { foreach($list_local as $flag => $value) { ?>
 <tr style="background: #F7EAB9;"> <td class="td-input-w100"><?=$value['name']?></td> <td class="td-input-w100"><?=$value['detail']?></td> <td>--</td> <td>--</td> <td align="center">[ <a href="?mod=payment&code=install&flag=<?=$flag?>">安装</a> ]</td> </tr> 
<? } } ?>
 <tr class="banner"> <td class="td_title">
是否先行发送<?=TUANGOU_STR?>券？
</td> <td colspan="4"> <font class="ini" src="payment.trade.sendgoodsfirst"></font>
（针对一些担保交易接口，用户付款到支付平台时是否先发放<?=TUANGOU_STR?>券【虚拟产品】）
</td> </tr> <tr class="banner"> <td class="td_title">
是否关闭上层通知？
</td> <td colspan="4"> <font class="ini" src="payment.lp.enabled"></font>
（关闭后只接受支付网关的对账通知，可以防止通知冲突时造成多生成<?=TUANGOU_STR?>券的问题）
<br/> <font color="red">注意：必须保证您的服务器可以接受支付网关的底层通知后才可以启用此功能，否则用户实际付款后会一直提示等待付款</font> </td> </tr> <tr class="banner"> <td class="td_title">
关闭后的提示内容：
</td> <td colspan="4" class="td-input-w100"> <font class="ini" src="payment.lp.tips"></font> <br/>
（关闭上层通知后，用户从支付网关跳回后的提示内容）
</td> </tr> <tr class="footer"> <td colspan="5"> <b>说明</b>：
<br/>
1、<img class="_flag_img" key="enable" /> 表示启用，<img class="_flag_img" key="disable" /> 表示不启用，点击图标可以快速切换
<br/>
2、输入框均支持实时保存，编辑完成后会自动保存到服务器，无需提交
</td> </tr> </table>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<? include handler('template')->file('@admin/footer'); ?>