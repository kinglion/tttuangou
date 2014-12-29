<script>
var pre_L = new Array;
</script>
<? if(is_array($rebate['profit'])) { foreach($rebate['profit'] as $i => $v) { ?>
<label>
<input type="radio" name="profit_id" value="<?=$i?>" onclick="modify_pre_input(<?=$i?>);"
<? if($i==$profit_id) { ?>
 checked="checked"
<? } ?>
/>
<span><?=$v['pre']?> % </span><?=$v['text']?>
</label>
<br/>
<script>pre_L.push("<?=$v['pre']?>");</script>
<? } } ?>
<script>
function modify_pre_input(id){
document.getElementById("profit_pre").value = pre_L[id];
}
</script>