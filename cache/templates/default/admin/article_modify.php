<? include handler('template')->file('@admin/header'); ?>
<?=ui('loader')->addon('editor.kind')?>
<form action="?mod=article&code=save" method="post"  enctype="multipart/form-data">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/> <table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder"> <tr class="header"> <td colspan="2">文章编辑</td> </tr> <tr> <td width="50" bgcolor="#F4F8FC">标题</td> <td> <input type="text" name="title" value="<?=$article['title']?>" size="60" /> </td> </tr> <tr> <td bgcolor="#F4F8FC">内容</td> <td> <textarea id="editor" name="content" style="width:100%;"><? echo htmlspecialchars($article['content']); ?></textarea> </td> </tr> <tr> <td bgcolor="#F4F8FC">署名</td> <td> <input type="text" name="writer" value="<?=$article['writer']?>" /> </td> </tr> <tr> <td colspan="2" bgcolor="#F4F8FC"> <center> <input type="hidden" name="id" value="<?=$article['id']?>" /> <input type="submit" value="保存" class="button" /> </center> </td> </tr> </table> </form> <script type="text/javascript">
$(document).ready(function(){
KE.show({id:'editor'});
});
</script>
<? include handler('template')->file('@admin/footer'); ?>