<div class="imgs_displayer">
<div id="imageslider">
<a href="?view=<?=$pid?>" target="_blank">
<? if(ini('ui.igos.lazyimager')) { ?>
<img class="lazy" <? echo 'sr'.'c="'.ini('settings.site_url').'/static/images/1x1.gif"'; ?> data-original="<? echo imager($iid, IMG_Normal); ?>" />
<? } else { ?><img src="<? echo imager($iid, IMG_Normal); ?>" />
<? } ?>
</a>
</div>
</div>