<?php

/**
 * 支付方式：农行支付
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package payment
 * @name alipay.php
 * @version 1.0
 */

class trustPayBankPaymentDriver extends PaymentDriver
{
	protected $master = null;
	
	public function MasterIframe($object)
	{
		$this->master = $object;
	}
	private $Gateway_ssl = './trustbank.php';
	//private $Gateway_ssl = '?mod=buy&code=order&op=save';
	
	private $Gateway_com = 'http://notify.alipay.com/trade/notify_query.do?';
	
	private $is_notify = null;
	
	public function CreateLink($payment, $parameter)
	{
				$parameter['name'] = preg_replace('/\&[a-z]{2,4}\;/i', '', $parameter['name']);
		$parameter['detail'] = str_replace(array('"',"'",'\\','&'), '', $parameter['detail']);
		
				$post = array(
						'service'           => $payment['config']['service'],
			'payment_type'      => '8',
						'seller_email'		=> $payment['config']['account'],
			'partner'			=> $payment['config']['partner'],
			'return_url'		=> $parameter['notify_url'],
			'notify_url'		=> $parameter['notify_url'],
			'_input_charset'	=> ini('settings.charset'),
			'show_url'			=> $parameter['product_url'],
						'OrderNo'		=> $parameter['sign'],
			'subject'			=> $parameter['name'],
			'body'				=> '',
			'OrderAmount'				=> $parameter['price'],
			'quantity'			=> 1,
						'logistics_fee'		=> '0.00',
			'logistics_type'	=> 'EXPRESS',
			'logistics_payment'	=> 'SELLER_PAY',
			'ExpiredDate' => 30,
			'OrderDate' => date('Y/m/d'),
			'OrderTime' => date('H:i:s'),
			'BuyIP' => '172.30.7.75',
			'OrderDesc' => 'Game Card Order',
			'OrderURL' => $parameter['product_url'],
			'ProductType' => 1,
			'PaymentType' => 1,
			'PaymentLinkType' => 1,
			'NotifyType' => 0,
			'ResultNotifyURL' => $parameter['notify_url']."&OrderNo=".$parameter['sign']."&sign=".$parameter['sign']."&total_fee=".$parameter['price']."&trade_status=WAIT_SELLER_SEND_GOODS",
			'MerchantRemarks' => '',
		);
		if ($payment['config']['service'] == 'create_partner_trade_by_buyer')
		{
						$parameter['addr_name'] || $parameter['addr_name'] = 'USER';
			$parameter['addr_address'] || $parameter['addr_address'] = 'ADDRESS';
			$parameter['addr_zip'] || $parameter['addr_zip'] = '000000';
			$parameter['addr_phone'] || $parameter['addr_phone'] = '13000000000';
						$post['receive_name']		= $parameter['addr_name'];
			$post['receive_address']	= $parameter['addr_address'];
			$post['receive_zip']		= $parameter['addr_zip'];
			$post['receive_phone']		= $parameter['addr_phone'];
		}
				$token = account('ulogin')->token();
		if ($token)
		{
			$post['token'] = $token;
		}
		$post['extend_param'] = 'isv^tt11';
		return $this->__BuildForm($payment, $post);
	}
	
	public function CreateConfirmLink($payment, $order)
	{
		if ($payment['config']['service'] == 'create_direct_pay_by_user' || $this->isDirectPay($payment, $order['orderid']))
		{
			return '?mod=buy&code=tradeconfirm&id='.$order['orderid'];
		}
		else
		{
			$paylog = logic('pay')->GetLog($order['orderid'], 0, '1', true);
			return 'http://lab.alipay.com/consume/record/buyerConfirmTrade.htm?tradeNo='.$paylog['trade_no'];
		}
	}
	
	public function CallbackVerify($payment)
	{
		if ($this->__Is_Nofity())
		{
						sleep(rand(1, 9));
						$trade_status = $this->__Notify_Verify($payment);
		}
		else
		{
			$trade_status = $this->__Return_Verify($payment);
		}
		return $this->__Trade_Status($trade_status);
	}
	
	public function GetTradeData()
	{
		$src = ($this->__Is_Nofity()) ? 'POST' : 'GET';
		$trade = array();
		$trade['sign'] = logic('safe')->Vars($src, 'sign', 'number');
		$trade['trade_no'] = logic('safe')->Vars($src, 'trade_no', 'number');
		$trade['price'] = logic('safe')->Vars($src, 'total_fee', 'float');
		$trade['money'] = $trade['price'];
		$trade['status'] = $this->__Trade_Status(logic('safe')->Vars($src, 'trade_status', 'txt'));
		return $trade;
	}
	
	public function StatusProcesser($status)
	{
		if (!$this->__Is_Nofity())
		{
			return false;
		}
		if ($status != 'VERIFY_FAILED')
		{
			return false;
		}
		else
		{
			echo 'failed';
		}
		return true;
	}
	
	public function GoodSender($payment, $express, $sign, $type)
	{
		if ($payment['config']['service'] == 'create_direct_pay_by_user' || $this->isDirectPay($payment, $sign))
		{
						if ($type == 'ticket')
			{
				logic('callback')->Bridge($sign)->Processed($sign, 'TRADE_FINISHED');
			}
			else
			{
				logic('callback')->Bridge($sign)->Processed($sign, 'WAIT_BUYER_CONFIRM_GOODS');
			}
			return;
		}
				$post = array(
						'service'           => 'send_goods_confirm_by_platform',
			'partner'           => $payment['config']['partner'],
			'_input_charset'    => ini('settings.charset'),
						'trade_no'			=> $express['trade_no'],
			'logistics_name'    => $express['name'],
			'invoice_no'		=> $express['invoice'],
			'transport_type'    => 'EXPRESS',
		);
		$url = $this->__BuildURL($payment, $post);
		
				$this->__SrvGET($url);
				return;
	}
	
	
	private function __Trade_Status($trade_status)
	{
		return ($trade_status == 'TRADE_SUCCESS') ? 'TRADE_FINISHED' : $trade_status;
	}
	
	private function isDirectPay($payment, $sign)
	{
		$directPay = false;
		if ($payment['config']['service'] == 'trade_create_by_buyer')
		{
						$order = logic('order')->SrcOne($sign);
			$paylog = logic('pay')->GetLog($order['orderid'], $order['userid']);
			$directPay = (count($paylog) == 3 && $paylog[0]['status'] == 'TRADE_FINISHED');
		}
		return $directPay;
	}
	
	private function __Is_Nofity()
	{
		if (is_null($this->is_notify))
		{
			if (post('trade_status'))
			{
				$this->is_notify = true;
			}
			else
			{
				$this->is_notify = false;
			}
		}
		return $this->is_notify;
	}
	
	//支付第一步
	public function __ActionPay($parameter){
		class_exists('TrxResponse') or require(dirname(__FILE__).'/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/bin/TrxType.php');
		class_exists('Order') or require(dirname(__FILE__).'/bin/Order.php');
		class_exists('Insure') or require(dirname(__FILE__).'/bin/Insure.php');
		class_exists('PaymentRequest') or require(dirname(__FILE__).'/bin/PaymentRequest.php');
		//1、取得支付请求所需要的信息
		$tOrderNo = $parameter['OrderNo'];
		$tExpiredDate = $parameter['ExpiredDate'];
		$tOrderDesc = $parameter['OrderDesc'];
		$tOrderDate = $parameter['OrderDate'];
		$tOrderTime = $parameter['OrderTime'];
		$tOrderAmountStr = $parameter['OrderAmount'];
		$tOrderURL = $parameter['OrderURL'];
		$tBuyIP = $parameter['BuyIP'];
		
		$tProductType = $parameter['ProductType'];
		$tPaymentType = $parameter['PaymentType'];
		$tNotifyType = $parameter['NotifyType'];
		$tResultNotifyURL = $parameter['ResultNotifyURL'];
		$tMerchantRemarks = $parameter['MerchantRemarks'];
		$tPaymentLinkType = $parameter['PaymentLinkType'];
		
		//2、生成订单对象
		$ord=new Order();
		$ord->setOrderNo($tOrderNo);
		$ord->setExpiredDate($tExpiredDate);
		$ord->setOrderDesc($tOrderDesc);
		$ord->setOrderDate($tOrderDate);
		$ord->setOrderTime($tOrderTime);
		$ord->setOrderAmount($tOrderAmountStr);
		$ord->setOrderURL($tOrderURL);
		$ord->setBuyIP($tBuyIP);
		$ordItemOne=new OrderItem();
		$ordItemOne->__constructOrderItem('IP000001', '中国移动ip卡', 100.1, 1);
		$ordItemOnexml=$ordItemOne->getXMLDocument();
		
		$ordItem2=new OrderItem();
		$ordItem2->__constructOrderItem('IP000002', '网通ip卡', 90.1, 2);
		$ordItem2xml=$ordItem2->getXMLDocument();
		$ord->addOrderItem($ordItemOnexml);
		$ord->addOrderItem($ordItem2xml);
		$ordxml=$ord->getXMLDocument(3);
		//echo $ord->getXMLDocument(1);
		//4、生成支付请求对象
		$pr=new PaymentRequest();
		$pr->setOrder($ordxml);
		//echo $pr->getOrder();
		$pr->setProductType($tProductType);
		$pr->setPaymentType($tPaymentType);
		$pr->setNotifyType($tNotifyType);
		//$pr->setResultNotifyURL('http://localhost:8118/WebSite4/Default.aspx');
		$pr->setResultNotifyURL($tResultNotifyURL);
		$pr->setMerchantRemarks($tMerchantRemarks);
		$pr->setPaymentLinkType($tPaymentLinkType);
		//5、传送支付请求并取得支付网址
		$tTrxResponse = $pr->extendPostRequest(1);
		if($tTrxResponse->isSuccess())
		{ 
			var_dump("成功！");
			exit;
			//6、支付请求提交成功，将客户端导向支付页面
			$paymentUrl=$tTrxResponse->getValue('PaymentURL');
			echo "<script language='javascript'>";
			echo "location.href='$paymentUrl'";
			echo "</script>";
		}
		else {
		   //7、支付请求提交失败，商户自定后续动作
			echo "ReturnCode   = [".$tTrxResponse->getReturnCode()."]<br>";
			echo "ErrorMessage = [".$tTrxResponse->getErrorMessage()."]<br>";
		}
	}
	
	private function __BuildForm($payment, $parameter)
	{
		$sign = $this->__CreateSign($payment, $parameter);
		$url = $this->Gateway_ssl;
		$sHtml = '<form id="pay_submit" name="alipaysubmit" action="'.$url.'" method="post" target="_blank">';
		foreach ($parameter as $key => $val)
		{
			$sHtml.= '<input type="hidden" name="'.$key.'" value="'.$val.'"/>';
		}
		$sHtml .= '<input type="hidden" name="sign" value="'.$sign.'"/>';
		$sHtml .= '<input type="hidden" name="sign_type" value="MD5"/>';
		$sHtml .= '<input type="hidden" name="FORMHASH" value="'.FORMHASH.'"/>';
		$sHtml .= '<input type="submit" value="农业银行付款" class="formbutton formbutton_ask" onclick="javascript:$.hook.call(\'pay.button.click\');" >';
		$sHtml .= '</form>';
		return $sHtml;
	}
	
	private function __BuildURL($payment, $parameter)
	{
		$sign = $this->__CreateSign($payment, $parameter);
		$parameter = $this->__arg_sort($parameter);
		$arg = $this->__create_linkstring_urlencode($parameter);
		$url = $this->Gateway_ssl.$arg.'&sign='.$sign.'&sign_type='.'MD5';
		return $url;
	}
	
	private function __Return_Verify($payment)
	{
		/*if($payment['config']['ssl'] == 'true')
		{
			$url = $this->Gateway_ssl
				.'service=notify_verify'
				.'&partner='.$payment['config']['partner']
				.'&notify_id='.get('notify_id', 'txt');
		}
		else
		{
			$url = $this->Gateway_com
				.'partner='.$payment['config']['partner']
				.'&notify_id='.get('notify_id', 'txt');
		}

		$result = $this->__Verify($url);
		*/
		class_exists('TrxResponse') or require(dirname(__FILE__).'/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/bin/TrxType.php');
		class_exists('Order') or require(dirname(__FILE__).'/bin/Order.php');
		class_exists('QueryOrderRequest') or require(dirname(__FILE__).'/bin/QueryOrderRequest.php');
		$tOrderNo = $_GET['OrderNo'];
		$tEnableDetailQuery=FALSE;
		
		$qor=new QueryOrderRequest();
		$qor->setOrderNo($tOrderNo);
		$qor->enableDetailQuery($tEnableDetailQuery);
		
		$tTrxResponse=$qor->postRequest();
		if($tTrxResponse->isSuccess())
		{//5、生成订单对象
			$tOrder=new Order();
			$tOrder->__constructXMlDocument($tTrxResponse->getValue('Order'));
			
			/*echo "OrderNo      = [".$tOrder->getOrderNo()."]<br>";
			echo "OrderAmount  = [".$tOrder->getOrderAmount()."]<br>";
			echo "OrderDesc    = [".$tOrder->getOrderDesc()."]<br>";
			echo "OrderDate    = [".$tOrder->getOrderDate()."]<br>";
			echo "OrderTime    = [".$tOrder->getOrderTime()."]<br>";
			echo "OrderURL     = [".$tOrder->getOrderURL()."]<br>";
			echo "PayAmount    = [".$tOrder->getPayAmount()."]<br>";
			echo "RefundAmount = [".$tOrder->getRefundAmount()."]<br>";
			echo "OrderStatus  = [".$tOrder->getOrderStatus()."]<br>";*/
			//6、取得订单明细
			//if($tEnableDetailQuery==true)
			//{
			/*
				$tOrderItems=$tOrder->getOrderItems();
				//var_dump($tOrderItems);
				//echo count($tOrderItems).'num';
				for($i=0;$i<count($tOrderItems);$i++)
				{
					$tOrderItem=$tOrderItems[$i];
					$tOI=new OrderItem();
					$tOI->__constructXMlDocument($tOrderItem);
					echo "ProductID   = [".$tOI->getProductID()."]<br>";
					echo "ProductName = [".$tOI->getProductName()."]<br>";
					echo "UnitPrice   = [".$tOI->getUnitPrice()."]<br>";
					echo "Qty         = [".$tOI->getQty()."]<br>";
				}
		//	}*/
		}
		else {
			
		}
		$parameter = $this->__para_filter($_GET);
		$parameter = $this->__arg_sort($parameter);
		$sign  = $this->__CreateSign($payment, $parameter);
		/*if (preg_match('/true$/i', $result) && $sign == get('sign', 'txt'))
		{
			
			return get('trade_status', 'txt');
		}*/
		if($tOrder->getOrderAmount() == $tOrder->getPayAmount()){
			return 'WAIT_SELLER_SEND_GOODS';
		}
		else
		{
			return 'VERIFY_FAILED';
		}
	}
	
	private function __Notify_Verify($payment)
	{
	
		class_exists('TrxResponse') or require(dirname(__FILE__).'/bin/core/TrxResponse.php');
		class_exists('TrxException') or require(dirname(__FILE__).'/bin/core/TrxException.php');
		class_exists('TrxRequest') or require(dirname(__FILE__).'/bin/core/TrxRequest.php');
		class_exists('TrxType') or require(dirname(__FILE__).'/bin/TrxType.php');
		class_exists('Order') or require(dirname(__FILE__).'/bin/Order.php');
		class_exists('QueryOrderRequest') or require(dirname(__FILE__).'/bin/QueryOrderRequest.php');
		$tOrderNo = $_POST['OrderNo'];
		$tEnableDetailQuery=FALSE;
		
		$qor=new QueryOrderRequest();
		$qor->setOrderNo($tOrderNo);
		$qor->enableDetailQuery($tEnableDetailQuery);
		
		$tTrxResponse=$qor->postRequest();
		if($tTrxResponse->isSuccess())
		{//5、生成订单对象
			$tOrder=new Order();
			$tOrder->__constructXMlDocument($tTrxResponse->getValue('Order'));
			
			/*echo "OrderNo      = [".$tOrder->getOrderNo()."]<br>";
			echo "OrderAmount  = [".$tOrder->getOrderAmount()."]<br>";
			echo "OrderDesc    = [".$tOrder->getOrderDesc()."]<br>";
			echo "OrderDate    = [".$tOrder->getOrderDate()."]<br>";
			echo "OrderTime    = [".$tOrder->getOrderTime()."]<br>";
			echo "OrderURL     = [".$tOrder->getOrderURL()."]<br>";
			echo "PayAmount    = [".$tOrder->getPayAmount()."]<br>";
			echo "RefundAmount = [".$tOrder->getRefundAmount()."]<br>";
			echo "OrderStatus  = [".$tOrder->getOrderStatus()."]<br>";*/
			//6、取得订单明细
			//if($tEnableDetailQuery==true)
			//{
			/*
				$tOrderItems=$tOrder->getOrderItems();
				//var_dump($tOrderItems);
				//echo count($tOrderItems).'num';
				for($i=0;$i<count($tOrderItems);$i++)
				{
					$tOrderItem=$tOrderItems[$i];
					$tOI=new OrderItem();
					$tOI->__constructXMlDocument($tOrderItem);
					echo "ProductID   = [".$tOI->getProductID()."]<br>";
					echo "ProductName = [".$tOI->getProductName()."]<br>";
					echo "UnitPrice   = [".$tOI->getUnitPrice()."]<br>";
					echo "Qty         = [".$tOI->getQty()."]<br>";
				}
		//	}*/
		}
		else {
			
		}
		$parameter = $this->__para_filter($_GET);
		$parameter = $this->__arg_sort($parameter);
		$sign  = $this->__CreateSign($payment, $parameter);
		/*if (preg_match('/true$/i', $result) && $sign == get('sign', 'txt'))
		{
			
			return get('trade_status', 'txt');
		}*/
		if($tOrder->getOrderAmount() == $tOrder->getPayAmount()){
			return 'WAIT_SELLER_SEND_GOODS';
		}
		else
		{
			return 'VERIFY_FAILED';
		}
	}
	
	private function __Verify($url, $time_out = '60')
	{
		$urlArr     = parse_url($url);
		$errNo      = '';
		$errStr     = '';
		$transPorts = '';
		if($urlArr['scheme'] == 'https')
		{
			$transPorts = 'ssl://';
			$urlArr['port'] = '443';
		}
		else
		{
			$transPorts = 'tcp://';
			$urlArr['port'] = '80';
		}
		$fp = msockopen($transPorts . $urlArr['host'], $urlArr['port'], $errNo, $errStr, $time_out);
		if(!$fp)
		{
			zlog('error')->found('error.msockopen');
			die("ERROR: $errNo - $errStr<br />\n");
		}
		else
		{
			fputs($fp, "POST ".$urlArr["path"]." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$urlArr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlArr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlArr["query"] . "\r\n\r\n");
			while(!feof($fp))
			{
				$info[]=@fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(",",$info);
			return $info;
		}
	}
	
	private function __SrvGET($url, $time_out = '60')
	{

		$urlArr     = parse_url($url);
		$errNo      = '';
		$errStr     = '';
		$transPorts = '';
		if($urlArr['scheme'] == 'https')
		{
			$transPorts = 'ssl://';
			$urlArr['port'] = '443';
		}
		else
		{
			$transPorts = 'tcp://';
			$urlArr['port'] = '80';
		}
		$fp = msockopen($transPorts . $urlArr['host'], $urlArr['port'], $errNo, $errStr, $time_out);
		if(!$fp)
		{
			zlog('error')->found('error.msockopen');
			die("ERROR: $errNo - $errStr<br />\n");
		}
		else
		{
			fputs($fp, "GET ".$urlArr["path"]."?".$urlArr["query"]." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$urlArr["host"]."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			while(!feof($fp))
			{
				$info[]=@fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(",",$info);
			return $info;
		}
	}
	
	private function __CreateSign($payment, $parameter)
	{
		$parameter = $this->__para_filter($parameter);
		$parameter = $this->__arg_sort($parameter);
		$string = $this->__create_linkstring($parameter);
		$string .= $payment['config']['key'];
		$string = md5($string);
		return $string;
	}
	private function __create_linkstring($array)
	{
		$arg  = '';
		foreach ($array as $key => $val)
		{
			$arg .= $key.'='.$val.'&';
		}
		$arg = substr($arg, 0, count($arg)-2);
		return $arg;
	}
	private function __create_linkstring_urlencode($array)
	{
		$arg  = '';
		foreach ($array as $key => $val)
		{
			if ($key != 'service' && $key != '_input_charset')
			{
				$arg .= $key.'='.urlencode($val).'&';
			}
			else
			{
				$arg .= $key.'='.$val.'&';
			}
		}
		$arg = substr($arg, 0, count($arg)-2);
		return $arg;
	}
	private function __arg_sort($array)
	{
		ksort($array);
		reset($array);
		return $array;
	}
	private function __para_filter($parameter)
	{
		$ignores = array(
			'sign' => 1,
			'sign_type' => 1,
			'mod' => 1,
			'pid' => 1
		);
		$para = array();
		foreach ($parameter as $key => $val)
		{
			if(isset($ignores[$key]) || $val == '')
			{
				continue;
			}
			else
			{
				$para[$key] = $val;
			}
		}
		return $para;
	}
}

?>