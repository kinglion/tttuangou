<? include $this->TemplateHandler->template("header"); ?>
<?=ui('ad')->load('howdo')?>
<?=ui('ad')->load('howdom')?>
<?=ui('ad')->load('howparallel')?>
<div class="site-fs">
<?=logic('city')->place_navigate()?>
<?=ui('catalog')->display()?>
<?=logic('sort')->product_navigate()?>
</div>
<script type="text/javascript">
var __Timer_lesser_auto_accuracy = <? echo ini('ui.igos.litetimer') ? 'true' : 'false'; ?>;
var __Timer_lesser_worker_max = <? echo (int)ini('ui.igos.litetimer_wm'); ?>;
</script>
<?=ui('loader')->js('@time.lesser')?>
<? ui('igos')->load($product) ?>
<?=ui('ad')->load('howthree')?>
<?=ui('iimager')->single_lazy()?>
<? include $this->TemplateHandler->template("footer"); ?>