<? include handler('template')->file('@admin/header'); ?>
 <div class="header"> <a href="?mod=article">文章列表</a> </div> <table id="orderTable" cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <thead> <tr class="tr_nav"> <td width="3%">编号</td> <td width="15%">标题</td> <td width="6%">用户</td> <td width="6%">署名</td> <td width="8%">管理</td> </tr> </thead> <tbody> 
<? if(is_array($articles)) { foreach($articles as $one) { ?>
 <tr> <td>
<?=$one['id']?>
</td> <td>
<?=$one['title']?>
</td> <td><? echo app('ucard')->load($one['author_id']); ?></td> <td>
<?=$one['writer']?>
</td> <td> <a href="?mod=article&code=modify&id=<?=$one['id']?>">[ 编辑 ]</a> <a href="?mod=article&code=delete&id=<?=$one['id']?>" onclick="return confirm('确认要删除吗？');">[ 删除 ]</a> </td> </tr> 
<? } } ?>
 </tbody> <tfoot> <tr class="footer"> <td colspan="5"><a href="admin.php?mod=article&code=create">发布新文章</a></td> </tr> <tr> <td colspan="5"><?=page_moyo()?></td> </tr> </tfoot> </table>
<? include handler('template')->file('@admin/footer'); ?>