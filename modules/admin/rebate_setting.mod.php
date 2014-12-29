<?php
/**
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package php
 * @name rebate_setting.mod.php
 * @date 2014-05-08 15:05:45
 */
 



class ModuleObject extends MasterObject{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	function Execute(){
		switch($this->Code){
			case 'show':
				$this->Show();
				break;
			case 'save':
				$this->Save();
				break;
		};
	}
	function Show(){
		$action = '?mod=rebate_setting&code=save';
		$cfg = ini('rebate_setting');
		if( empty($cfg) || count($cfg)<0 ){
			$profit = array( array('pre'=>5, 'text'=>'每月15号结算') );
		}else{
			extract($cfg);
		}
		include(handler('template')->file("@admin/setting_rebate"));
	}
	function Save(){
		$cfg = ini('rebate_setting');
		$cfg['profit'] = array();
		$profit_pre_L = $this->Post['profit_pre'];
		$profit_text_L = $this->Post['profit_text'];
		foreach($profit_pre_L as $k => $v){
			if( is_numeric($v) && (int)$v >= 0 && $profit_text_L[$k]){
				$cfg['profit'][] = array('pre'=>$v, 'text'=>$profit_text_L[$k]);
			}
		}
		ini('rebate_setting',$cfg);
		if($cfg['profit']){
			$this->Messager("保存成功",'?mod=rebate_setting&code=show');
		}else{
			$this->Messager("数据无效，保存失败",'?mod=rebate_setting&code=show');
		}
	}
}
?>