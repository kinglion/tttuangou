<?php
/**
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package php
 * @name seller_join.mod.php
 * @date 2014-05-08 15:05:45
 */
 



 


class ModuleObject extends MasterObject
{
	private $uid = 0;
	private $sid = 0;
	
	private function iniz()
	{
		$this->uid = user()->get('id');
		if ($this->uid < 0)
		{
			$this->Messager('请先登录！', '?mod=account&code=login');
		}
		$this->sid = logic('seller')->U2SID($this->uid);
		if ($this->sid > 0)
		{
			$this->Messager('请等待审核！', 0);
		}
	}
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		$this->iniz();
		$runCode = Load::moduleCode($this);
		$this->$runCode();
	}
	public function main()
	{
		header('Location: '.rewrite('?mod=seller_join&code=info'));
	}
	
	public function info()
	{
		$rebate = logic('rebate')->Get_Rebate_setting();
		$profit_pre = 0;
		$profit_id = 0;
		$city = logic('misc')->CityList();
		include handler('template')->file('seller_join_table');
	}
	function addmap(){
		extract($this->Get);
		extract($this->Post);
		$x='11728000';
		$y='4320000';
		$z=3;
		if($id!=''){
			$xyz=explode(',',$id);
			$x=$xyz[0];
			$y=$xyz[1];
			$z=$xyz[2];
		}
		include(handler('template')->file('@admin/tttuangou_googlemap'));
	}
	function save(){
						$fields = array('area','sellername','selleraddress','sellerphone','sellerurl','sellermap','profit_id');
		$data = array();
		foreach($fields as $f){
			$data[$f] = $_POST[$f];
		}
		$data['userid'] = user()->get('id');
				$sid = logic('seller')->Join($data);
		if (!$sid) $this->Messager('提交失败！请重试', -1);
		$this->Messager('注册成功', '?mod=seller');
	}
	protected function saveImage($file, $fname){
			$path = './uploads/seller/';
			if( empty($file) || $file['error']==4 ) return FALSE;
			if( $file['error'] > 0 ){
					echo '<script type="text/javascript">alert("'. $file['error'] .'");</script>';
					return FALSE;
			}
			$ext = preg_replace("/.*?\.(\w+)$/i", "$1", $file['name']);
			$ext = strtolower( $ext );
			if( !preg_match("/gif|jpg|jpeg|png/i", $ext) ){
					echo '<script type="text/javascript">alert("错误的图片格式");</script>';
					return FALSE;
			}
			$fname = $fname.'.'.$ext;
			if( !move_uploaded_file( $file["tmp_name"] , $path.$fname ) ){
					echo '<script type="text/javascript">alert("移动文件失败");</script>';
					return FALSE;
			}
			return $fname;
	}
	
	public function product_ticket()
	{
		$pid = get('pid', 'int');
				$status = get('status')!==false ? get('status', 'int') : TICK_STA_ANY;
		$fLinkBase = rewrite('?mod=seller&code=product&op=ticket&pid='.$pid.'&status=');
		$fLink = array(
			'all' => array('link'=>$fLinkBase.TICK_STA_ANY,'current'=>''),
			'used' => array('link'=>$fLinkBase.TICK_STA_Used,'current'=>''),
			'unused' => array('link'=>$fLinkBase.TICK_STA_Unused,'current'=>'')
		);
		abs($status) > 1 && $status = TICK_STA_ANY;
		$status == TICK_STA_ANY && $fLink['all']['current'] = ' class="filter_current"';
		$status == TICK_STA_Used && $fLink['used']['current'] = ' class="filter_current"';
		$status == TICK_STA_Unused && $fLink['unused']['current'] = ' class="filter_current"';
				$product = logic('product')->SrcOne($pid);
		if ($product['sellerid'] != $this->sid)
		{
			$this->Messager('这个产品是其他商家的，您无法查看！', '?mod=seller&code=product&op=list');
		}
		$tickets = logic('coupon')->GetList(USR_ANY, ORD_ID_ANY, $status, $pid);
		include handler('template')->file('seller_product_ticket');
	}
	
	public function product_order()
	{
		$pid = get('pid', 'int');
				$status = get('status') !== false ? get('status', 'int') : ORD_PAID_ANY;
		$fLinkBase = rewrite('?mod=seller&code=product&op=order&pid='.$pid.'&status=');
		$fLink = array(
			'all' => array('link'=>$fLinkBase.ORD_PAID_ANY,'current'=>''),
			'used' => array('link'=>$fLinkBase.ORD_PAID_Yes,'current'=>''),
			'unused' => array('link'=>$fLinkBase.ORD_PAID_No,'current'=>'')
		);
		abs($status) > 1 && $status = ORD_PAID_ANY;
		$status == ORD_PAID_ANY && $fLink['all']['current'] = ' class="filter_current"';
		$status == ORD_PAID_Yes && $fLink['used']['current'] = ' class="filter_current"';
		$status == ORD_PAID_No && $fLink['unused']['current'] = ' class="filter_current"';
				$product = logic('product')->SrcOne($pid);
		if ($product['sellerid'] != $this->sid)
		{
			$this->Messager('这个产品是其他商家的，您无法查看！', '?mod=seller&code=product&op=list');
		}
		$orders = logic('order')->GetList(USR_ANY, ORD_STA_ANY, $status, 'o.productid='.$pid);
		include handler('template')->file('seller_product_order');
	}
	
	public function product_delivery()
	{
		$pid = get('pid', 'int');
				$status = get('status') !== false ? get('status', 'int') : DELIV_SEND_No;
		$fLinkBase = rewrite('?mod=seller&code=product&op=delivery&pid='.$pid.'&status=');
		$fLink = array(
			'all' => array('link'=>$fLinkBase.DELIV_SEND_No,'current'=>''),
			'used' => array('link'=>$fLinkBase.DELIV_SEND_Yes,'current'=>''),
			'unused' => array('link'=>$fLinkBase.DELIV_SEND_OK,'current'=>'')
		);
		$status == DELIV_SEND_No && $fLink['all']['current'] = ' class="filter_current"';
		$status == DELIV_SEND_Yes && $fLink['used']['current'] = ' class="filter_current"';
		$status == DELIV_SEND_OK && $fLink['unused']['current'] = ' class="filter_current"';
				$product = logic('product')->SrcOne($pid);
		if ($product['sellerid'] != $this->sid)
		{
			$this->Messager('这个产品是其他商家的，您无法查看！', '?mod=seller&code=product&op=list');
		}
		$deliveries = logic('delivery')->GetList($status, 'p.id='.$pid);
		include handler('template')->file('seller_product_delivery');
	}
	
	public function delivery_single()
	{
		$order = logic('order')->SrcOne(get('oid', 'number'));
		if ($order)
		{
			$product = logic('product')->SrcOne($order['productid']);
			if ($product['sellerid'] == $this->sid)
			{
				logic('delivery')->Invoice(get('oid', 'number'), get('no', 'txt')) && exit('ok');
			}
		}
		exit('error');
	}
	
	public function ajax_alert()
	{
		$id = get('id', 'int');
		$c = logic('coupon')->GetOne($id);
		logic('notify')->Call($c['uid'], 'admin.mod.coupon.Alert', $c);
		exit('ok');
	}
}

?>