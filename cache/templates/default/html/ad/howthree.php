<div style="float:none; clear:both;"></div>
<div style="width:980px;  margin:0px auto 15px auto;">
<? $index=0; ?>
<? if(is_array($cfg['list'])) { foreach($cfg['list'] as $id => $one) { ?>
<div style="
<? if($index % 3 != 0) { ?>
margin-left:20px;
<? } ?>
 float:left;">
			<a href="<?=$one['link']?>" target="<?=$one['target']?>"><img <? echo 'src='.ini('settings.site_url').'/'.$one['image']; ?> alt="<?=$one['text']?>"></a>
		</div>
<? $index++; ?>
<? } } ?>
<div style="float:none; clear:both;"></div>
</div>
<div style="float:none; clear:both;"></div>