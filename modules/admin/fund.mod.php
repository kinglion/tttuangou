<?php

/**
 * 模块：商家结算管理
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name fund.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
    public function ModuleObject( $config )
    {
        $this->MasterObject($config);
        $runCode = Load::moduleCode($this);
        $this->$runCode();
    }
    
    function order()
    {
        $orderid = get('orderid', 'number');
		if($orderid)
		{
			$order = logic('fund')->GetOne($orderid);
			if($order){
				if($order['status'] =='doing'){
					$action = "?mod=fund&code=order&op=save";
				}
				$order_log = logic('fund')->Getlog($orderid);
			}else{
				$this->Messager('操作错误！');
			}
		}
		else
		{
			$paystatus = get('paystatus');
			if (in_array($paystatus,array('no','yes','doing','error')))
			{
				$where = "status = '{$paystatus}'";
			}
			else
			{
				$where = '1';
			}
			$list = logic('fund')->GetList($where);
		}
        include handler('template')->file('@admin/fund_order');
    }
	public function order_save(){
		$orderid = post('orderid', 'number');
		$status = post('status', 'txt');
		$info = strip_tags(post('info', 'txt'));
		if(!in_array($status,array('yes','error'))){
			$this->Messager('操作失败，请选择一个操作结果！');
		}
		$return = logic('fund')->Orderdone($orderid,$status,$info);
		if($return){
			$this->Messager('操作成功！');
		}else{
			$this->Messager('操作失败！');
		}
	}
	
    public function order_confirm()
    {
        $orderid = get('orderid', 'number');
        if ($orderid)
        {
            $r = logic('fund')->MakeSuccessed($orderid);
			if($r){exit('ok');}else{exit($r);}
        }
        else
        {
            exit('结算记录流水号不正确');
        }
    }
	function Config()
    {
        $upcfg = ini('fund');
        include handler('template')->file('@admin/fund_config');
    }
    function Config_save()
    {
        $least = post('least', 'int');
		$per = post('per', 'int');
		$least = intval(max(0,$least));
		$per = intval(max(0,$per));
		$least = $least < $per ? $per : $least;
		$upcfg = array(
			'least' => $least,
            'per' => $per
        );
        ini('fund', $upcfg);
        $this->Messager('保存成功！');
    }
	function money_save()
	{
		$id = get('id','int');
		$money = get('money','txt');
		$moneyz = get('moneyz','txt');
		if(!is_numeric($moneyz) || $moneyz < 0 || !is_numeric($money) || $money < 0){
			exit('金额输入错误，修改失败！');
		}
		$data = array('account_money' => $money,'total_money' => $moneyz);
		dbc()->SetTable(table('seller'));
		$r = dbc()->Update($data,'id='.intval($id));
		exit($r ? (string)$r : '修改失败！');
	}
	function iphonesave()
    {
		$url = post('url', 'test');
		$from = post('from', 'test');
		$from = $from == 'app' ? '?mod=app' : '?mod=api&code=release';
		if($url && false == strpos($url,'https://itunes.apple.com/cn/app/')){
			$this->Messager('下载地址填写错误！',$from);
		}
		$cfg = array(
			'url' => $url
        );
        ini('iphone', $cfg);
        $this->Messager('保存成功！',$from);
    }
	function moneyupdate()
	{
		$sql = dbc(DBCMax)->select('seller')->in('id')->order('id.asc')->sql();
	 	$sids = dbc(DBCMax)->query($sql)->done();
		if($sids){
			foreach($sids as $sid){
				$sql = dbc(DBCMax)->select('product')->in('id')->where(array('sellerid'=>$sid['id']))->order('id.asc')->sql();
				$pids = dbc(DBCMax)->query($sql)->done();
				if($pids){
					$c_pid = array();
					foreach($pids as $pid){
						$c_pid[] = $pid['id'];
					}
					$sql = dbc(DBCMax)->select('order')->in('SUM(totalprice-expressprice) AS money')->where('paytime > 0 AND productid IN('.implode(',',$c_pid).')')->sql();
					$moneys = dbc(DBCMax)->query($sql)->done();
					dbc(DBCMax)->update('seller')->data(array('money'=>$moneys[0]['money']))->where(array('id' => $sid['id']))->done();
				}
			}
		}
		$this->Messager('正在更新，请稍后......','?mod=tttuangou&code=mainseller');
	}
}

?>