<?=ui('loader')->css('@jquery.smallslider')?>
<?=ui('loader')->js('@jquery.smallslider')?>
<div id="adImageSlider" class="smallslider">
<ul>
<? if(is_array($cfg['list'])) { foreach($cfg['list'] as $id => $one) { ?>
<li><a href="<?=$one['link']?>" target="<?=$one['target']?>"><img <? echo 'sr'.'c="'.ini('settings.site_url').'/'.$one['image']; ?>" alt="<?=$one['text']?>" width="980" /></a></li>
<? } } ?>
</ul>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#adImageSlider').smallslider({
time: <? echo intval($cfg["dsp"]["time"])*1000; ?>,
onImageStop: true,
switchEffect: 'ease',
switchPath: '<?=$cfg["dsp"]["switchPath"]?>',
switchEase: 'easeOutSine',
showText: <?=$cfg["dsp"]["showText"]?>,
showButtons: <?=$cfg["dsp"]["showButtons"]?>,
textSwitch: 2,
textAlign: 'left'
});
});
</script>