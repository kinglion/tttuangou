<? include handler('template')->file('@admin/header'); ?>
 <form action="?mod=catalog&code=edit" method="post"  enctype="multipart/form-data">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="2"> <a href="?mod=catalog">返回分类列表</a> </td> </tr> <tr> <td width="10%" class="td_title">分类图标：</td> <td> <input name="id" type="hidden" value="<?=$id?>"/> <input name="catalog_image" type="file" />
* 图片分辨率为 18 x 18，不替换请留空
</td> </tr> <tr> <td class="td_title">广告代码：</td> <td> <textarea name="script" style="width:399px"><?=$data[$id]['script']?></textarea> </td> </tr> <tr> <td></td> <td> <input type="submit" value="保存" class="button" /> </td> </tr> </table> </form> 
<? include handler('template')->file('@admin/footer'); ?>