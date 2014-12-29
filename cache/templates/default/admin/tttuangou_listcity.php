<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<form method="post"  action="<?=$action?>">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="4">
城市管理 / 是否开启城市区域功能？ <font class="ini" src="cplace.enabled"></font>（点击按钮开启关闭）
<br/>
是否在首页标题Title处显示“城市<?=TUANGOU_STR?>”（如“杭州<?=TUANGOU_STR?>”）字样（仅首页多团模式下）？
<font class="ini" src="cplace.cnpre.enabled"></font> </td> </tr> <tr> <td>城市中文名称（用于前台展示）</td> <td>拼音名称（用于URL地址）</td> <td>是否开启状态</td> <td align="center">管理</td> </tr> 
<? if(!empty($city_list)) { ?>
 
<? if(is_array($city_list)) { foreach($city_list as $value) { ?>
 <tr onmouseover="this.className='tr_hover'" onmouseout="this.className='tr_normal'"> <td><?=$value['cityname']?>  
<? if($value['cityid']==$default_city_id) { ?>
(默认城市)
<? } ?>
</td> <td><?=$value['shorthand']?></td> <td>
<? if($value['display']==1) { ?>
开启
<? } else { ?>关闭
<? } ?>
</td> <td align="center"> <a href="?mod=tttuangou&code=editcity&id=<?=$value['cityid']?>">修改</a> <a href="#" onclick="if(confirm('您确认要删除该城市吗？')){window.location.href='?mod=tttuangou&code=deletecity&id=<?=$value['cityid']?>'}">删除</a>
<? if(logic('city')->place_enabled()) { ?>
<a href="?mod=city&code=place&cid=<?=$value['cityid']?>">区域管理</a>
<? } ?>
</td> </tr> 
<? } } ?>
 
<? } ?>
 <tr class="footer"> <td colspan="4"><div align=right></div></td> </tr> </table> <a href="?mod=tttuangou&code=addcity" class="back1 back2">添加城市</a> <br> <center> </center> </form>
<? include handler('template')->file('@admin/footer'); ?>