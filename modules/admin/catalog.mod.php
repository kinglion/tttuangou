<?php

/**
 * 模块：分类管理
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name catalog.mod.php
 * @version 1.1
 */

class ModuleObject extends MasterObject
{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	function Main()
	{
		$catalog = logic('catalog')->Navigate(2);
		include handler('template')->file('@admin/catalog_list');
	}
	function Add_ajax()
	{
		$parent = get('parent', 'int');
		$parent || $parent = 0;
		$parent && $master = logic('catalog')->GetOne($parent);
		$master['parent'] > 0 && $master = false;
		include handler('template')->file('@admin/catalog_add_ajax');
	}
	function Add_save()
	{
		$parent = post('parent', 'int');
		$parent || $parent = 0;
		$flag = post('flag', 'text');
		$name = post('name', 'text');
		$id = -1;
		if (preg_match('/^[a-z0-9]+$/i', $flag) && $flag && $name)
		{
			$id = logic('catalog')->Add($parent, $flag, $name);
		}
		exit('<script type="text/javascript">var op = window.opener ? window.opener : window.parent; op.__catalog_add_finish('.$id.');</script>');
	}
	function Del_ajax()
	{
		$id = get('id', 'int');
		$id || exit('false');
		logic('catalog')->Delete($id);
		exit('ok');
	}
	function Subclass_list_ajax()
	{
		$parent = get('parent', 'int');
		$category = get('category', 'int');
		$list = logic('catalog')->GetList($parent);
		foreach ($list as $i => $one)
		{
			$extend = '';
			if ($one['id'] == $category)
			{
				$extend = ' selected="selected"';
			}
			echo '<option value="'.$one['id'].'"'.$extend.'>'.$one['name'].'</option>';
		}
	}

        function edit()
    {
    	$id = post('id', 'int');
    	if ($id> 0) {
    		$data = ini('catalog.icon');
	        $script = post('script', 'string');
	        $result = logic('upload')->Save('catalog_image', false, false);
	        $data[$id] = array('icon'=>$result['url'],'script'=>$script);
	        ini('catalog.icon', $data);
	        $this->Messager('分类配置已经更新！', '?mod=catalog');
    	}else{
    		$id = get('id', 'int');
    		$data = ini('catalog.icon');
			if($data && is_array($data)){
    		foreach ($data as $key => $value) {
    			if ($key != $id) {
    				unset($data[$key]);
    			}
    			$data[$key]['script'] = stripcslashes($value['script']);
    		}
			}
    		include handler('template')->file('@admin/catalog_edit');
    	}
        
    }
}
?>