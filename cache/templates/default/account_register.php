<? include handler('template')->file('header'); ?>
<?=ui('loader')->css('@account.register')?>
<?=ui('loader')->js('@account.register')?>
<script type="text/javascript"> 
$(function(){ 
$("#hometel").focus(function(){$(this).css("background","#CBFE9F");$(".hint0").show();}).blur(function(){$(this).css("background","#FFF");$(".hint0").hide();});
$("#email").focus(function(){$(this).css("background","#CBFE9F");$(".hint1").show();}).blur(function(){$(this).css("background","#FFF");$(".hint1").hide();});
$("#username").focus(function(){$(this).css("background","#CBFE9F");$(".hint2").show();}).blur(function(){$(this).css("background","#FFF");$(".hint2").hide();});
$("#password").focus(function(){$(this).css("background","#CBFE9F");$(".hint3").show();}).blur(function(){$(this).css("background","#FFF");$(".hint3").hide();});
$("#repassword").focus(function(){$(this).css("background","#CBFE9F");$(".hint3").show();}).blur(function(){$(this).css("background","#FFF");$(".hint3").hide();});
$("#phone").focus(function(){$(this).css("background","#CBFE9F");$(".hint4").show();}).blur(function(){$(this).css("background","#FFF");$(".hint4").hide();});
}); 
</script>
<div class="site-ms">
<div class="site-ms__left">
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title">用户注册</p>
<div class="sect">
<form action="<?=$action?>" method="post"  enctype="multipart/form-data" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<div class="nleftL">
<div class="field" style="display:none;">
<label>推荐人手机</label>
<input type="text" name="hometel" id="hometel"  class="f-l input_h" value="" size="30">
<font id="hometel_result"></font>
<span class="hint0" style="display:none;">有推荐人就填，没有则留空</span>
</div>
<div class="field">
<label>Email</label>
<input type="text" name="email" id="email"  class="f-l input_h" value="<?=$email?>" size="30">
<font id="email_result"></font>
<span class="hint1" style="display:none;">登录及找回密码用</span>
</div>
<div class="field">
<label>用户名</label>
<input type="text" name="truename" id="username" class="f-l input_h" size="30">
<font id="username_result"></font>
<span class="hint2" style="display:none;">4-16 个字符，一个汉字为两个字符</span>
</div> 
<div class="field">
<label>密码</label>
<input name="pwd" type="password" class="f-l input_h" id="password" size="30">
<font id="password_result"></font>
<span class="hint3" style="display:none;">最少 4 个字符</span>
</div>
<div class="field">
<label>确认密码</label>
<input name="ckpwd" type="password" class="f-l input_h" id="repassword" size="30">
<font id="repassword_result"></font>
</div>
<div class="field">
<label>手机号码</label>
<input type="text" name="phone" id="phone" class="f-l input_h"size="30">
<font id="phone_result"></font>
<span class="hint4" style="display:none;">请填写您的手机号码，<?=TUANGOU_STR?>券会通过手机发送</span> 
</div> 
<div class="field">
<label>所在城市</label>
<select name="city" class="f_product" id="city" >
<? if(is_array($city)) { foreach($city as $i => $value) { ?>
<option  value="<?=$value['cityid']?>"><?=$value['cityname']?></option>
<? } } ?>
<option value="0">其他</option>
</select>
</div>
<div class="field autologin">
<input name="showemail" type="checkbox" class="f_check" id="showemail" value="1" checked="checked" >
<span>订阅每日最新<?=TUANGOU_STR?>信息 </span>
</div>
<div class="clear">
<input type="hidden" name="home_uid" value="<?=$home_uid?>">
</div>
<div id="l_act">
<input type="submit" class="btn btn-primary"  value="注 册" >
</div>
</div>
</form>
</div>
</div>
</div> 
</div>
<div class="site-ms__right">
<div class="t_area_out">
<h1>已有本站帐户？</h1>
<div class="t_area_in">
<p>请直接 <a href="?mod=account&code=login">登录</a>。</p>
<p><?=account('ulogin')->wlist()?></p>
</div>
</div>
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>