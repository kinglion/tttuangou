<? include handler('template')->file('@admin/header'); ?>
 <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header1" > <td colspan="3" > <a class="nav_a" href="?mod=widget">布局管理</a> <a class="nav_a selected" href="?mod=widget&code=block">模块管理</a></td> </tr> <tr class="tr_nav"> <td width="20%" bgcolor="#F4F8FC">标记</td> <td width="20%" bgcolor="#F4F8FC">名称</td> <td bgcolor="#F4F8FC">操作</td> </tr> 
<? if(is_array($list)) { foreach($list as $flag => $value) { ?>
 <tr> <td><?=$flag?></td> <td> <font class="ini" src="widget.~@blocks.<?=$flag?>.name"><? echo $value['name']?$value['name']:'新添加模块'; ?></font> </td> <td align="center">
[ <? echo $this->Block_config_link($flag); ?> ]
[ <a href="?mod=widget&code=block&op=editor&flag=<?=$flag?>">编辑模板</a> ]
[ <? echo $this->Block_delete_link($flag); ?> ]
</td> </tr> 
<? } } ?>
 <tr class="footer"> <td colspan="3"> <a href="?mod=widget&code=block&op=add&class=diy">创建模块</a> </td> </tr> </table>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<? include handler('template')->file('@admin/footer'); ?>