<? include handler('template')->file('header'); ?>
<?=ui('loader')->addon('dialog.art')?>
<?=ui('loader')->addon('dialog.art.iframe')?>
<style type="text/css">
</style>
<div class="site-ms">
<div class="ts_menu_2 w960">
<ul>
<li class="ts3_mbtn1">申请成为商家</li>
</ul>
</div>
<div class="t_area_out">
<div class="t_area_in">
<div class="nleftL w916">
<form action="?mod=seller_join&code=save" method="post"  enctype="multipart/form-data">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tab_list">
<tr><td bgcolor="#F4F8FC">所在城市：</td><td>
<select name="area" id="area">
<? if(is_array($city)) { foreach($city as $i => $value) { ?>
  
<option value="<?=$value['cityid']?>"><?=$value['cityname']?></option>
<? } } ?>
</select></td></tr>
<tr><td width="18%" bgcolor="#F4F8FC">商家名称：</td> <td> <input name="sellername" type="text" id="sellername" size="50"/></td> </tr>
<tr> <td width="18%" bgcolor="#F4F8FC">商家地址：</td> <td> <input name="selleraddress" type="text" id="selleraddress" size="50"/></td> </tr>
<tr> <td bgcolor="#F4F8FC">商家电话：</td> <td><input name="sellerphone" type="text" id="sellerphone" size="50" /></td> </tr>
<tr> <td bgcolor="#F4F8FC">商家网站：</td> <td><input name="sellerurl" type="text" id="sellerurl" size="50" /></td> </tr>
<tr> <td bgcolor="#F4F8FC">与站长的分成：</td>
<td>
<? include handler('template')->file('select_rebate'); ?>
<input type="hidden" name="profit_pre" value="<?=$profit_pre?>" id="profit_pre" />
</td> </tr>
<tr> <td bgcolor="#F4F8FC">地图位置：</td><td>
<input type="hidden" id="map" name="sellermap" />
<a href="javascript:;" onclick="showMapAPI();" id="map_update">(点击设定您的地理位置)</a>
</td> </tr>
<tr> <td bgcolor="#F4F8FC">身份证：</td><td>
<input type="file" name="id_card"/>
</td> </tr>
<tr> <td bgcolor="#F4F8FC">营业执照：</td><td>
<input type="file" name="zhizhao"/>
</td></tr></table>
<br><center><input type="submit" class="btn" name="addsubmit" value="提 交" onclick="return table_submit();" /></center>
</form>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function table_submit(){
if( document.getElementById("sellername").value=="" ){
alert("请填写商家名");
return false;
}
if( document.getElementById("sellerphone").value=="" ){
alert("请填写联系方式");
return false;
}
return true;
}
function getxy(i)
{
$('#map_update').html('商家地点已设置，请提交保存');
$('#map').val(i);
}
function showMapAPI(){
var url = "?mod=seller_join&code=addmap&id="+ $('#map').val();
art.dialog({
title: '您只需要点击地图上的标签到指定的地方，关闭该窗口即可，系统会自己收集您的坐标！',
content: '<iframe src="'+url+'" width="600" height="500"></iframe>',
padding: '0',
fixed: true,
resize: false,
drag: false
});
}
</script>
<? include handler('template')->file('footer'); ?>