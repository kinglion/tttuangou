/**
{
	$.notify.loading('正在受理中...');
	$.get('?mod=fund&code=order&op=confirm&orderid='+orderid, function(data){
		$.notify.loading();
		if (data == 'ok')
		{
			$.notify.success('谢谢您的操作！');location.reload();
		}
		else
		{
			$.notify.failed(data);
		}
	});
}