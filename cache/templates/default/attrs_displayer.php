<p class="P_dist">属性选择</p>
<? if(is_array($ord_attrs['dsp'])) { foreach($ord_attrs['dsp'] as $dsp) { ?>
<p class="P_disl"><?=$dsp['name']?> - <?=$dsp['price']?> 元</p>
<? } } ?>