<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="4">
静态页面列表
</td> </tr> <tr> <td width="10%">标记</td> <td>名称</td> <td width="10%">状态</td> <td width="20%">管理</td> </tr> 
<? if(is_array($list)) { foreach($list as $flag => $html) { ?>
 <tr> <td><?=$flag?></td> <td><a href="<? echo rewrite('index.php?mod=html&code='.$flag); ?>" target="_blank" title="查看静态页面"><?=$html['title']?></a></td> <td><font class="ini" src="html.list.<?=$flag?>.enabled"><? echo $html['enabled'] ? 'true' : 'false'; ?></font></td> <td> <a href="?mod=html&code=edit&flag=<?=$flag?>">编辑</a> - <a href="?mod=html&code=del&flag=<?=$flag?>" onclick="return confirm('确认删除吗？');">删除</a> </td> </tr> 
<? } } ?>
 <tr> <td></td> <td colspan="3"><a href="?mod=html&code=add"> - 添加 - </a></td> </tr> </table>
<? include handler('template')->file('@admin/footer'); ?>