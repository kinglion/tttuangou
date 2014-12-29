/**
	$.hook.add('pro.city.sel.change', function(){
        cplace_regions_reload();
    });
});

function cplace_regions_reload()
{
	var city_id = $('#allCityList').val();
	$('#__cplace_region').html('<option>正在加载</option>');
	$('#__cplace_street').html('<option value="0">全部</option>');
	$.get('admin.php?mod=city&code=place&op=ajaxlist&type=city&id='+city_id.toString(), function(html){
		$('#__cplace_region').html(html);
	});
}

function cplace_region_change()
{
	var region_id = $('#__cplace_region').val();
	$('#__cplace_street').html('<option>正在加载</option>');
	$.get('admin.php?mod=city&code=place&op=ajaxlist&type=region&id='+region_id.toString(), function(html){
		$('#__cplace_street').html(html);
	});
}