<? include handler('template')->file('@admin/header'); ?>
 <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr> <td colspan="4">提示：如需要编辑客服信息、微博链接等，请点击“模块管理”进入对应模块设置。</td> </tr> <tr class="header1" > <td colspan="4" > <a class="nav_a selected" href="?mod=widget">布局管理</a> <a class="nav_a" href="?mod=widget&code=block">模块管理</a></td> </tr> <tr class="tr_nav"> <td width="20%" bgcolor="#F4F8FC">标记</td> <td width="20%" bgcolor="#F4F8FC">名称</td> <td width="20%" bgcolor="#F4F8FC">状态</td> <td bgcolor="#F4F8FC">操作</td> </tr> 
<? if(is_array($list)) { foreach($list as $flag => $value) { ?>
 <tr> <td><?=$flag?></td> <td><font class="ini" src="widget.<?=$flag?>.name"><? echo $value['name']?$value['name']:'新侦测模块'; ?></font></td> <td>
加载了 <b style="font-size:12pt;"><? echo count($value['blocks']); ?></b> 个模块
</td> <td align="center">
[ <a href="?mod=widget&code=config&flag=<?=$flag?>">管理</a> ]
</td> </tr> 
<? } } ?>
 <tr> <td colspan="4">
是否自动侦测新模块？<font class="ini" src="widget.~@config.listener.enabled"></font>（如果您发现系统自动添加很多无用的模块，请关闭自动侦测）
</td> </tr> </table>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<? include handler('template')->file('@admin/footer'); ?>