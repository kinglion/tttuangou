<? include handler('template')->file('header'); ?>
<script language="javascript">
function check(){
if($('#name').val()=='' || $('#phone').val()=='' || $('#content').val()==''){
alert('请将基本信息填写完整，谢谢！');
return false;
}
return true;
}
</script>
<div class="site-ms">
<div class="site-ms__left">
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title">商务合作</p>
<div class="sect">
<div class="nleftL">
特别欢迎优质商家、淘宝大卖家提供<?=TUANGOU_STR?>信息。
<form action="?mod=list&code=doteamwork" method="post"  onsubmit="return check()">
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<div class="field">
<label>您的称呼</label>
<input type="text" name="name" id="name"  class="f_input input_h" value=""  size="30">
</div>
<div class="field">
<label>您的电话</label>
<input type="text" name="phone" id="phone" onblur="checkuname();" class="f_input input_h"size="30">
</div>
<div class="field">
<label>其他联系方式</label>
<input name="elsecontat" type="text" class="f_input input_h" id="elsecontat"  size="30">
<span class="hint">请留下您的手机、QQ号或邮箱，方便联系</span> 
</div>
<div class="field">
<label><?=TUANGOU_STR?>内容</label>
<textarea name="content" id="content" rows="5" cols="80" class="f-textarea"></textarea>
</div>
<div id="l_act">
<input type="submit" class="btn btn-primary"  value="提 交">
</div>
</form>
</div>
</div>
</div> 
</div>
</div>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>