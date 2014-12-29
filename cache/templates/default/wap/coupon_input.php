<? include handler('template')->file('@wap/header'); ?>
<? if($msg) { ?>
<?=$msg?><hr/>
<? } ?>

<? if($product) { ?>
<?=$product['flag']?> / 份数 <?=$product['coupon']['mutis']?>
<? if(isset($product['coupon']['attrs']) && $product['coupon']['attrs']) { ?>
<br/>
<? if(is_array($product['coupon']['attrs']['dsp'])) { foreach($product['coupon']['attrs']['dsp'] as $attr) { ?>
<?=$attr['name']?><br/>
<? } } ?>
<? } ?>
<hr/>
<? } ?>
<form action="?mod=wap&code=coupon&op=verify" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
号码：<input type="text" name="number" value="<?=$number?>" /><br/>
密码：<input type="text" name="password" value="<?=$password?>" /><br/>
<input type="submit" value="验证并消费" />
</form>
<hr/>
<form action="?mod=wap&code=coupon&op=input" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<input type="submit" value="清空输入框" />
</form>
<? include handler('template')->file('@wap/footer'); ?>