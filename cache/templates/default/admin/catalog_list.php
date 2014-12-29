<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->js('@jquery.hook')?>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<?=ui('loader')->js('#html/catalog/catalog.mgr.ajax')?>
<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="7">产品分类管理</td> </tr> <tr class="banner"> <td colspan="7">
1、是否开启分类功能？ <font class="ini" src="catalog.enabled"></font>（点击按钮：绿色开启、灰色关闭） （分类显示顺序：数字小的优先显示）<br/>
2、是否自动隐藏在售产品数为0的分类？ <font class="ini" src="catalog.filter.empty.enabled"></font> ] (开启后如果某一分类下在售产品数为0，前台会自动隐藏)<br/>
3、<b>短标记和分类名称可直接编辑，编辑完成后系统会自动保存</b><br/>
4、如果某一分类下没有产品显示，请检查您的产品所属城市和当前浏览的城市是否一致<br/>
5、<font color="red"><b>特别注意：短标记请使用纯字符（字母a到z和数字0到9） 一定不要使用其他特殊字符！否则分类功能将会失效</b></font> </td> </tr> <tr class="tr_nav"> <td width="5%">显示顺序</td> <td >分类名称</td> <td width="15%">短标记（用于url）</td> <td width="15%">产品数<BR>在售/总计</td> <td width="15%">更新时间</td> <td width="15%">管理</td> </tr> 
<? if(count($catalog)==0) { ?>
 <tr class="tips"> <td colspan="6"> <font color="red">提醒：如果您启用了分类功能，那么您必须至少添加一个主分类才可以，否则添加或编辑产品时是无法选择分类的！</font> </td> </tr> 
<? } ?>
 
<? if(is_array($catalog)) { foreach($catalog as $i => $topclass) { ?>
<? if ($topclass['id']==0) continue; ?>

<? $mclass = $topclass;
unset($mclass['subclass']);
$topclass['subclass'] || $topclass['subclass'] = array();
array_unshift($topclass['subclass'], $mclass);
$topclass['subclass']['0']['master'] = true;
$parentID = $mclass['id'];
$parent = $mclass['name'];
$subclass = $topclass['subclass'];
 ?>
<? if(is_array($topclass['subclass'])) { foreach($topclass['subclass'] as $i => $class) { ?>
<? if ($class['id']==0) continue; ?>
<tr> <td style="white-space:nowrap;">
<? if($class['parent'] == 0) { ?>
<? } else { ?><? echo '|——';; ?>
<? } ?>
<font class="dbf th2s" src="id:<?=$class['id']?>@catalog/order"><?=$class['order']?></font></td> <td><? echo $class['master'] ? '' : '|——'; ?><font class="dbf" src="id:<?=$class['id']?>@catalog/name"><?=$class['name']?></font><? echo next($subclass) === false ? ' / <a href="javascript:;" onclick="__catalog_add('.$parentID.')">添加子分类</a>' : ''; ?></td> <td><font class="dbf" src="id:<?=$class['id']?>@catalog/flag"><?=$class['flag']?></font></td> <td><? echo $class['master'] ? '---' : ($class['oslcount'].' / '.$class['procount']); ?></td> <td><? echo date('Y-m-d H:i:s', $class['upstime']); ?></td> <td><a href="javascript:;" onclick="__catalog_del(<?=$class['id']?>, after_catalog_delete)">删除</a>
<? if($class['parent'] == 0) { ?>
&nbsp;&nbsp;<a href="admin.php?mod=catalog&code=edit&id=<?=$topclass['id']?>">编辑</a>
<? } ?>
</td> </tr> 
<? } } ?>
 
<? } } ?>
 <tr class="tips"> <td colspan="6"> <a href="javascript:;" onclick="__catalog_add()">添加主分类</a> </td> </tr> </table> <script type="text/javascript">
$.hook.add('catalog.add.finish', function(id){
location.href = location.href;
});
function after_catalog_delete(id)
{
location.href = location.href;
}
</script> 
<? include handler('template')->file('@admin/footer'); ?>