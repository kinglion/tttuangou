<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->js('#admin/js/sdb.parser')?>
<form method="post"  action="<?=$action?>">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="6">分享设置</td> </tr> <tr> <td width="10%">排序</td> <td width="30%">标记</td> <td width="30%">名称</td> <td width="30%">是否显示</td> </tr> 
<? if(!empty($shares)) { ?>
 
<? if(is_array($shares)) { foreach($shares as $flag => $share) { ?>
 <tr onmouseover="this.className='tr_hover'" onmouseout="this.className='tr_normal'"> <td><input type="text" name="order[]" size="3" value="<?=$share['order']?>"/></td> <td><input type="text" name="flag[]" size="13" value="<?=$flag?>" readonly="readonly"/></td> <td><input type="text" name="name[]" size="30" value="<?=$share['name']?>" readonly="readonly"/></td> <td><label><input type="checkbox" name="display[<?=$flag?>]" 
<? if($share['display']=='yes') { ?>
checked="checked"
<? } ?>
/> 显示</label></td> </tr> 
<? } } ?>
 
<? } ?>
 </table> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="2">bShare 设置</td> </tr> <tr> <td width="160" class="td_title">bShare UUID：</td> <td> <input size="50" type="text" name="bshare[uuid]" value="<?=$bshare['uuid']?>" />
[ <a href="<?=ihelper('tg.app.bshare')?>" target="_blank">帮助说明</a> ]
</td> </tr> <tr> <td class="td_title">是否显示分享名称？</td> <td> <font class="ini" src="share.~@bshare.sn"><? echo $bshare['sn'] ? 'true' : 'false'; ?></font> </td> </tr> <tr> <td class="td_title">是否显示分享数统计？</td> <td> <font class="ini" src="share.~@bshare.ssc"><? echo $bshare['ssc'] ? 'true' : 'false'; ?></font> </td> </tr> <tr> <td class="td_title">是否显示更多按钮？</td> <td> <font class="ini" src="share.~@bshare.more"><? echo $bshare['more'] ? 'true' : 'false'; ?></font> </td> </tr> </table> <center> <input type="submit" class="button" value="保存" /> </center> </form>
<? include handler('template')->file('@admin/footer'); ?>