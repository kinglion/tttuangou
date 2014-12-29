<?php
/**
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package php
 * @name countdown.mod.php
 * @date 2014-05-08 15:05:45
 */
 




class ModuleObject extends MasterObject
{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
				$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	public function main(){
		$backnum = logic('order')->FreeCountDownOrder();
		$mutiView = true;
		if (ini('ui.igos.pager'))
		{
			
		}
		else
		{
			$_GET[EXPORT_GENEALL_FLAG] = EXPORT_GENEALL_VALUE;
		}
		$product = logic('product')->GetList(logic('misc')->City('id'), NULL, '`is_countdown`=1');
				$usePager = get('page', 'int');
		if (ini('ui.igos.dsper') && $mutiView && count($product) > 1)
		{
			logic('product')->reSort($product);
		}
		if($product){
			foreach($product as &$v){
				if( $v['begintime'] > time() ){
					$lasttime = $v['begintime'] - time();
					if( $lasttime > 24 * 60 *60 ){
						$v['begin_date'] = date('Y-m-d H:s',$v['begintime']);
					}else{
						$v['limit_time'] = $lasttime;
					}
				}
				if( $v['maxnum']==0 ) $v['num']=999;
				else $v['num'] = $v['maxnum'] - $v['successnum'];
								if( $v['num']<0 ) $v['num']=0;
				$v['pic'] = imager($v['imgs'][0],IMG_Original);
			}
		}
		
				include handler('template')->file('buy_countdown');
	}
	public function view(){
		$product_id = get('item', 'int');
		$backnum = logic('order')->FreeCountDownOrder($product_id);
	}
}

?>