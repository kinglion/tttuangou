<?php

/**
 * 模块：APP接口
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name app.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	function main()
	{
		$iphone = ini('iphone');
		$app_img_d = 'https://chart.googleapis.com/chart?cht=qr&chs=175x175&choe=UTF-8&chld=L|1&chl='.urlencode(ini('settings.site_url').'/index.php?mod=downapp&code=down');
		$app_img_x = 'https://chart.googleapis.com/chart?cht=qr&chs=120x120&choe=UTF-8&chld=L|1&chl='.urlencode(ini('settings.site_url').'/index.php?mod=downapp&code=down');
		$from = 'app';
		include handler('template')->file('@admin/app_config');
	}
	function lpc()
	{
		$master = get('master', 'txt');
		$processor = get('processor', 'txt');
		$appObject = app($master);
		if (method_exists($appObject, $processor))
		{
			$appObject->$processor();
			exit;
		}
		else
		{
			exit('LPC.E.404');
		}
	}
}

?>