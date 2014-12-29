<? include handler('template')->file('@admin/header'); ?>
 <div class="export_link"> <a class="button back1 back2 fr" href="?mod=export&code=subscribe&referrer=<? echo urlencode($_SERVER['QUERY_STRING']); ?>">导出数据</a> </div> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr> <td colspan="4" style="padding-left:0"> <div class="is_current"><?=$type?>订阅列表</div>
<? if(is_array($typeDfs)) { foreach($typeDfs as $flag => $name) { ?>
<div class="<? echo ($type != $name) ? 'is_button' : 'is_current'; ?>"><a href="?mod=subscribe&class=<?=$flag?>"><?=$name?></a></div>
<? } } ?>
<div class="is_button"><a href="?mod=subscribe&code=config">设置</a></div> </td> </tr> <tr class="tr_nav"> <td>推送目标</td> <td>所属城市</td> <td>订阅时间</td> <td>管理</td> </tr>
<? if(is_array($list)) { foreach($list as $one) { ?>
<tr> <td><?=$one['target']?></td> <td><?=$one['cityName']?></td> <td><? echo date('Y-m-d H:i:s', $one['time']); ?></td> <td><a href="?mod=subscribe&code=del&id=<?=$one['id']?>">删除</a></td> </tr>
<? } } ?>
<tr class="footer"> <td colspan="4">
<?=page_moyo()?>
</td> </tr> <tr class="banner"> <td colspan="4"> <a href="?mod=subscribe&code=broadcast&class=<?=$class?>">订阅信息群发</a> </td> </tr> </table>
<? include handler('template')->file('@admin/footer'); ?>