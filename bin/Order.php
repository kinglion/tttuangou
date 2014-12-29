<?php
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('OrderItem') or require(dirname(__FILE__).'/OrderItem.php');


class Order
{
	/** [订单状态]属性 - 订单取消。 */
	const ORDER_STATUS_CANCEL='00';
	/** [订单状态]属性 - 订单建立，等待支付。*/
	const ORDER_STATUS_NEW='01';
	/** [订单状态]属性 - 消费者已支付，等待支付结果。*/
	const ORDER_STATUS_WAIT='02';
	/** [订单状态]属性 - 订单已支付。*/
	const ORDER_STATUS_PAY='03';
	/** [订单状态]属性 - 订单已结算。*/
	const ORDER_STATUS_SETTLED='04';
	/** [订单状态]属性 - 订单已退款。*/
	const ORDER_STATUS_REFUND='05';
	/** [订单状态]属性 - 订单已有争议。*/
	const ORDER_STATUS_ISSUE='99';
	/** 订单编号最大长度 */
	const ORDER_NO_LEN=50;
	/** 订单说明最大长度 */
	const ORDER_DESC_LEN=100;
	/** 订单网址最大长度 */
	const ORDER_URL_LEN=200;
	/** 订单编号 */
	private $iOrderNo    = '';
	/** 订单有效期 */
	private $iExpiredDate=30;
	/** 订单说明 */
	private $iOrderDesc='';
	/** 订单日期 */
	private $iOrderDate='';
	/** 订单时间 */
	private $iOrderTime='';
	/** 订单金额 */
	private $iOrderAmount=0;
	/** 订单明细。为OrderItem对象的数组。*/
	private $iOrderItems = array();

	/** 订单网址 */
	private $iOrderURL='';
	/** 支付金额 */
	private $iPayAmount=0;
	/** 退货金额 */
	private $iRefundAmount=0;
	/* 订单IP*/
	private $iBuyIP='';
	/** 订单状态 */
	private $iOrderStatus='01';
	/**
    * 订单编号
    * @return 订单编号
    */
	public function getOrderNo()
	{
		return $this->iOrderNo;
	}
	/**
    * 设定订单编号
    * @param aOrderNo 订单编号
    */
	public function setOrderNo($orderNo)
	{
		$this->iOrderNo=trim($orderNo);
	}
	/**
	* 设定订单有效期
	* @param aExpiredDate 订单有效期
	*/
	public function setExpiredDate($aExpiredDate)
	{
		$this->iExpiredDate=trim($aExpiredDate);
	}	
	/**
	* 订单有效期
	* @return 订单有效期
	*/
	public function getExpiredDate()
	{
		return $this->iExpiredDate;
	}
    /**
     * 设定订单说明
     * @param aOrderDesc 订单说明
     */
	public function setOrderDesc($aOrderDesc)
	{
		$this->iOrderDesc=trim($aOrderDesc);
	}
    /**
     * 订单说明
     * @return 订单说明
     */
	public function getOrderDesc()
	{
		return $this->iOrderDesc;
	}
    /**
     * 设定订单日期
     * @param aOrderDate 订单日期（YYYY/MM/DD）
     */
	public function setOrderDate($aOrderDate)
	{
		$this->iOrderDate=trim($aOrderDate);
	}
    /**
     * 订单日期
     * @return 订单日期（YYYY/MM/DD）
     */
	public function getOrderDate()
	{
		return $this->iOrderDate;
	}
    /**
     * 设定订单时间
     * @param aOrderTime 订单时间（HH:MM:SS）
     */
	public function setOrderTime($aOrderTime)
	{
		$this->iOrderTime=trim($aOrderTime);
	}
    /**
     * 订单时间
     * @return 订单时间（HH:MM:SS）
     */
	public function getOrderTime()
	{
		return $this->iOrderTime;
	}
    /**
     * 设定订单金额
     * @param aOrderAmount 订单金额（单位为 RMB￥0.01）
     */
	public function setOrderAmount($aOrderAmount)
	{
		$this->iOrderAmount=$aOrderAmount;
	}
    /**
     * 订单金额
     * @return 订单金额
     */
	public function getOrderAmount()
	{
		return $this->iOrderAmount;
	}
    /**
     * 设定支付金额
     * @param aPayAmount 支付金额
     */
	public function setPayAmount($aPayAmount)
	{
		$this->iPayAmount=$aPayAmount;
	}
    /**
     * 支付金额
     * @return 支付金额
     */
	public function getPayAmount()
	{
		return $this->iPayAmount;
	}
    /**
     * 设定退货金额
     * @param aRefundAmount 退货金额
     */
	public function setRefundAmount($aRefundAmount)
	{
		$this->iRefundAmount=$aRefundAmount;
	}
    /**
     * 退货金额
     * @return 退货金额
     */
	public function getRefundAmount()
	{
		return $this->iRefundAmount;
	} 
	/**
     * 新增订单明细
     * @param aOrderItem 订单明细（OrderItem）对象
     * @return 对象本身
     */
	public function addOrderItem($aOrderItem)
	{
		if(!$this->iOrderItems)
		{
			$this->iOrderItems=array();
			$this->iOrderItems[0]=$aOrderItem;
		
		}
		else {
			array_push($this->iOrderItems, $aOrderItem);
		}
	}
    /**
     * 清除订单明细
     * @return 对象本身
     */
	public function clearOrderItems()
	{
		$this->iOrderItems=array();
	}

    /**
     * 订单明细
     * @return OrderItem对象的ArrayList集合。
     */
	public function getOrderItems()
	{
		return $this->iOrderItems;
	}

    /**
     * 设定订单网址
     * @param aOrderDate 订单网址
     */
	public function setOrderURL($aOrderURL)
	{
		$this->iOrderURL=trim($aOrderURL);
	}
    /**
     * 订单网址
     * @return 订单网址
     */
   	public function getOrderURL()
	{
		return $this->iOrderURL;
	} 
    /**
     * 设定订单IP
     * @param aBuyIP 订单IP
     */
	public function setBuyIP($aBuyIP)
	{
		$this->iBuyIP=trim($aBuyIP);
	}
    /**
     * 订单IP
     * @return 订单IP
     */
   	public function getBuyIP()
	{
		return $this->iBuyIP;
	}
    /**
     * 设定订单状态
     * @param aOrderStatus 订单状态<br>
     * Order.ORDER_STATUS_CANCEL : 订单取消<br>
     * Order.ORDER_STATUS_NEW    : 订单建立，等待支付<br>
     * Order.ORDER_STATUS_WAIT   : 消费者已支付，等待支付结果<br>
     * Order.ORDER_STATUS_PAY    : 订单已支付<br>
     * Order.ORDER_STATUS_SETTLED: 订单已结算<br>
     * Order.ORDER_STATUS_REFUND : 订单已退款<br>
     * Order.ORDER_STATUS_ISSUE  : 订单有争议<br>
     */
	public function setOrderStatus($aOrderStatus)
	{
		$this->iOrderStatus=trim($aOrderStatus);
	}
	/**
     * 订单状态
     * @return 订单状态<br>
     * Order.ORDER_STATUS_CANCEL : 订单取消<br>
     * Order.ORDER_STATUS_NEW    : 订单建立，等待支付<br>
     * Order.ORDER_STATUS_WAIT   : 消费者已支付，等待支付结果<br>
     * Order.ORDER_STATUS_PAY    : 订单已支付<br>
     * Order.ORDER_STATUS_SETTLED: 订单已结算<br>
     * Order.ORDER_STATUS_REFUND : 订单已退款<br>
     * Order.ORDER_STATUS_ISSUE  : 订单有争议<br>
     */
	public function getOrderStatus()
	{
		return $this->iOrderStatus;
	}
	/**
    * 构造Order对象
    */
	public function __construct()
	{
		$this->iOrderItems=array();
	}

    /**
     * 给Order对象，使用XML文件初始化属性。
     * @param aXML 初始对象的XML文件。<br>XML文件范例：<br>
     * &lt;Order&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderNo&gt;ON20031112001&lt;/OrderNo&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderDesc&gt;你在E卡网站上的订单&lt;/OrderDesc&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderDate&gt;2013/03/15&lt;/OrderDate&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderTime&gt;13:50:45&lt;/OrderTime&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderAmount&gt;28000&lt;/OrderAmount&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderItems&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductID&gt;IP000001&lt;/ProductID&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductName&gt;中国移动IP卡&lt;/ProductName&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;UnitPrice&gt;10000&lt;/UnitPrice&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Qty&gt;1&lt;/Qty&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductID&gt;IP000002&lt;/ProductID&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductName&gt;网通IP卡&lt;/ProductName&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;UnitPrice&gt;9000&lt;/UnitPrice&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Qty&gt;2&lt;/Qty&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;/OrderItems&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderURL&gt;http://www.ecard.com/order?ON20031112001&lt;/OrderURL&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;PayAmount&gt;28000&lt;/PayAmount&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;RefundAmount&gt;0&lt;/RefundAmount&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderStatus&gt;01&lt;/OrderStatus&gt;<br>
     * &lt;/Order&gt;<br>
	 * 11字段，没有buyIp
     */
	 public function __constructXMlDocument($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iOrderNo=$xml->getValueNoNull('OrderNo');
		$this->iExpiredDate=$xml->getValueNoNull('ExpiredDate');
	    $this->iOrderDesc=$xml->getValueNoNull('OrderDesc');
		$this->iOrderDate=$xml->getValueNoNull('OrderDate');
		$this->iOrderTime=$xml->getValueNoNull('OrderTime');
		$this->iOrderURL=$xml->getValueNoNull('OrderURL');
		$this->iOrderStatus=$xml->getValueNoNull('OrderStatus');
		$this->iOrderAmount=$xml->getValueNoNull('OrderAmount');
		$this->iPayAmount=$xml->getValueNoNull('PayAmount');
		$this->iRefundAmount=$xml->getValueNoNull('RefundAmount');
		//原来java没有这个buyip可能丢了？？？
		$this->iBuyIP=$xml->getValueNoNull('BuyIP');
		$this->iOrderItems=($this->iOrderItems+$xml->getValueArray('OrderItem'));
	}

    /**
     * 订单信息是否合法
     * @return 订单信息是否合法
     */
	public function isValid()
	{
		/*
          说明：
          1、OrderNo、OrderDate、OrderTime、OrderAmount为必要字段
          2、字符串形态的必要字段不得为空
          3、数字形态需大于零
          4、日期、时间的格式需正确
          5、如有定单明细，则订单明细必须合法
        */
		if(!$this->iOrderNo) return false;
		if(!$this->iOrderDate) return false;
		if(!$this->iOrderTime) return false;
		if($this->iOrderAmount<=0) return false;
		if(strlen(trim($this->iOrderNo))==0) return false;
		if(count(DataVerifier::stringToByteArray($this->iOrderNo)) > self::ORDER_NO_LEN) return false;
		if(count(DataVerifier::stringToByteArray($this->iOrderDesc)) > self::ORDER_DESC_LEN) return false;
		if(count(DataVerifier::stringToByteArray($this->iOrderURL)) > self::ORDER_URL_LEN) return false;
		
		if(!DataVerifier::isValidDate($this->iOrderDate)) return false;
		if(!DataVerifier::isValidTime($this->iOrderTime)) return false;
		if(!DataVerifier::isValidAmount($this->iOrderAmount,2)) return false;
		if(strlen(trim($this->iOrderURL))>0)
		{
			if(!DataVerifier::isValidURL($this->iOrderURL))
				return false;
		}
		/*
		for($i=0;$i<count($this->iOrderItems);$i++)
		{
			$tOrderItem=new OrderItem();
			print_r($this->iOrderItems[$i]);
			$tOrderItem->__constructXMlDocument($this->iOrderItems[$i]);
			if(!$tOrderItem->isValid())
				return false;
		}
		
	*/
		foreach($this->iOrderItems as $tOrderItem)
		{
			$ori=new OrderItem();
			$ori->__constructXMlDocument($tOrderItem);
			if(!$ori->isValid())
				return false;
		}	
		return true;
	}
	
    /**
     * 取得对象的XML文件
     * @param aType 是否包含完整对象属性。<br>
     * 1: 只包含支付请求时所需的对象属性。<br> 
     * 2: 只包含订单号、订单金额、支付金额、退货金额及订单状态属性。<br>
     * 3: 包含完整的对象属性。
     * @return XML文件
     */
	public function getXMLDocument($aType)
	{
		 $xmldoc='';
		 $str1= '<Order>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<ExpiredDate>'.$this->iExpiredDate.'</ExpiredDate>'.
				'<OrderAmount>'.strval($this->iOrderAmount).'</OrderAmount>';
		 $str2= '<OrderDesc>'.$this->iOrderDesc.'</OrderDesc>'.
				'<OrderDate>'.$this->iOrderDate.'</OrderDate>'.
				'<OrderTime>'.$this->iOrderTime.'</OrderTime>'.
				'<OrderURL>'.$this->iOrderURL.'</OrderURL>'.
				'<BuyIP>'.$this->getBuyIP().'</BuyIP>'.
				'<OrderItems>';
		 $str3='';
		 $arr=array();
			   for($i=0;$i<count($this->iOrderItems);$i++)
			   {
					$tOrderItem=new OrderItem();
					$tOrderItem->__constructXMlDocument($this->iOrderItems[$i]);
					$strtmp=$tOrderItem->getXMLDocument();
					array_push($arr,$strtmp);
			   }
	     $str3=implode("",$arr);
		 $str4= '</OrderItems>';
		 $str5=	'<PayAmount>'.strval($this->iPayAmount).'</PayAmount>'.
				'<RefundAmount>'.strval($this->iRefundAmount).'</RefundAmount>'.
				'<OrderStatus>'.$this->iOrderStatus.'</OrderStatus>';
		 $str6=	'</Order>';
		 if($aType==1)
		 {	
			$aType1= array($str1,$str2,$str3,$str4,$str6);
			$xmldoc= implode("",$aType1); 
			return $xmldoc;
		 }
		 else if($aType==2)
		 {
			 $aType2=array($str1,$str5,$str6);
			 $xmldoc= implode("",$aType2);
			 return $xmldoc;
		 }
		 else if($aType==3)
		 {
			$aType3=array($str1,$str2,$str3,$str4,$str5,$str6);
			$xmldoc=implode("",$aType3);
			return $xmldoc;
		 }
		 return $xmldoc;
	}
}
/*
$ord=new Order();
$x=new XMLDocument('<Order><OrderNo>11111</OrderNo><ExpiredDate>2013/10/24</ExpiredDate><OrderDesc>jwordertest</OrderDesc>
					<OrderDate>2013/01/24</OrderDate><OrderTime>18:23:23</OrderTime><OrderURL>http://www.jingdong.com</OrderURL>
					<OrderStatus>01</OrderStatus><OrderAmount>87.00</OrderAmount><PayAmount>88.00</PayAmount>
					<RefundAmount>90.00</RefundAmount>
					<OrderItems>
					<OrderItem><ProductID>111</ProductID><ProductName>jw1</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>
					<OrderItem><ProductID>112</ProductID><ProductName>jw2</ProductName><UnitPrice>0.50</UnitPrice><Qty>5</Qty></OrderItem>
					</OrderItems>
					</Order>');
$ord->__constructXMlDocument($x);
echo count($ord->getOrderItems())."numoforderitems";
echo $ord->getOrderNo();
if($ord->isValid())
echo 'jwtrue'."</br>";
echo $ord->getXMLDocument(3);
echo "<br/>".$ord->getPayAmount();
*/

?>