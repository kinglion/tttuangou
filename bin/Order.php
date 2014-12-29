<?php
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('OrderItem') or require(dirname(__FILE__).'/OrderItem.php');


class Order
{
	/** [����״̬]���� - ����ȡ���� */
	const ORDER_STATUS_CANCEL='00';
	/** [����״̬]���� - �����������ȴ�֧����*/
	const ORDER_STATUS_NEW='01';
	/** [����״̬]���� - ��������֧�����ȴ�֧�������*/
	const ORDER_STATUS_WAIT='02';
	/** [����״̬]���� - ������֧����*/
	const ORDER_STATUS_PAY='03';
	/** [����״̬]���� - �����ѽ��㡣*/
	const ORDER_STATUS_SETTLED='04';
	/** [����״̬]���� - �������˿*/
	const ORDER_STATUS_REFUND='05';
	/** [����״̬]���� - �����������顣*/
	const ORDER_STATUS_ISSUE='99';
	/** ���������󳤶� */
	const ORDER_NO_LEN=50;
	/** ����˵����󳤶� */
	const ORDER_DESC_LEN=100;
	/** ������ַ��󳤶� */
	const ORDER_URL_LEN=200;
	/** ������� */
	private $iOrderNo    = '';
	/** ������Ч�� */
	private $iExpiredDate=30;
	/** ����˵�� */
	private $iOrderDesc='';
	/** �������� */
	private $iOrderDate='';
	/** ����ʱ�� */
	private $iOrderTime='';
	/** ������� */
	private $iOrderAmount=0;
	/** ������ϸ��ΪOrderItem��������顣*/
	private $iOrderItems = array();

	/** ������ַ */
	private $iOrderURL='';
	/** ֧����� */
	private $iPayAmount=0;
	/** �˻���� */
	private $iRefundAmount=0;
	/* ����IP*/
	private $iBuyIP='';
	/** ����״̬ */
	private $iOrderStatus='01';
	/**
    * �������
    * @return �������
    */
	public function getOrderNo()
	{
		return $this->iOrderNo;
	}
	/**
    * �趨�������
    * @param aOrderNo �������
    */
	public function setOrderNo($orderNo)
	{
		$this->iOrderNo=trim($orderNo);
	}
	/**
	* �趨������Ч��
	* @param aExpiredDate ������Ч��
	*/
	public function setExpiredDate($aExpiredDate)
	{
		$this->iExpiredDate=trim($aExpiredDate);
	}	
	/**
	* ������Ч��
	* @return ������Ч��
	*/
	public function getExpiredDate()
	{
		return $this->iExpiredDate;
	}
    /**
     * �趨����˵��
     * @param aOrderDesc ����˵��
     */
	public function setOrderDesc($aOrderDesc)
	{
		$this->iOrderDesc=trim($aOrderDesc);
	}
    /**
     * ����˵��
     * @return ����˵��
     */
	public function getOrderDesc()
	{
		return $this->iOrderDesc;
	}
    /**
     * �趨��������
     * @param aOrderDate �������ڣ�YYYY/MM/DD��
     */
	public function setOrderDate($aOrderDate)
	{
		$this->iOrderDate=trim($aOrderDate);
	}
    /**
     * ��������
     * @return �������ڣ�YYYY/MM/DD��
     */
	public function getOrderDate()
	{
		return $this->iOrderDate;
	}
    /**
     * �趨����ʱ��
     * @param aOrderTime ����ʱ�䣨HH:MM:SS��
     */
	public function setOrderTime($aOrderTime)
	{
		$this->iOrderTime=trim($aOrderTime);
	}
    /**
     * ����ʱ��
     * @return ����ʱ�䣨HH:MM:SS��
     */
	public function getOrderTime()
	{
		return $this->iOrderTime;
	}
    /**
     * �趨�������
     * @param aOrderAmount ��������λΪ RMB��0.01��
     */
	public function setOrderAmount($aOrderAmount)
	{
		$this->iOrderAmount=$aOrderAmount;
	}
    /**
     * �������
     * @return �������
     */
	public function getOrderAmount()
	{
		return $this->iOrderAmount;
	}
    /**
     * �趨֧�����
     * @param aPayAmount ֧�����
     */
	public function setPayAmount($aPayAmount)
	{
		$this->iPayAmount=$aPayAmount;
	}
    /**
     * ֧�����
     * @return ֧�����
     */
	public function getPayAmount()
	{
		return $this->iPayAmount;
	}
    /**
     * �趨�˻����
     * @param aRefundAmount �˻����
     */
	public function setRefundAmount($aRefundAmount)
	{
		$this->iRefundAmount=$aRefundAmount;
	}
    /**
     * �˻����
     * @return �˻����
     */
	public function getRefundAmount()
	{
		return $this->iRefundAmount;
	} 
	/**
     * ����������ϸ
     * @param aOrderItem ������ϸ��OrderItem������
     * @return ������
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
     * ���������ϸ
     * @return ������
     */
	public function clearOrderItems()
	{
		$this->iOrderItems=array();
	}

    /**
     * ������ϸ
     * @return OrderItem�����ArrayList���ϡ�
     */
	public function getOrderItems()
	{
		return $this->iOrderItems;
	}

    /**
     * �趨������ַ
     * @param aOrderDate ������ַ
     */
	public function setOrderURL($aOrderURL)
	{
		$this->iOrderURL=trim($aOrderURL);
	}
    /**
     * ������ַ
     * @return ������ַ
     */
   	public function getOrderURL()
	{
		return $this->iOrderURL;
	} 
    /**
     * �趨����IP
     * @param aBuyIP ����IP
     */
	public function setBuyIP($aBuyIP)
	{
		$this->iBuyIP=trim($aBuyIP);
	}
    /**
     * ����IP
     * @return ����IP
     */
   	public function getBuyIP()
	{
		return $this->iBuyIP;
	}
    /**
     * �趨����״̬
     * @param aOrderStatus ����״̬<br>
     * Order.ORDER_STATUS_CANCEL : ����ȡ��<br>
     * Order.ORDER_STATUS_NEW    : �����������ȴ�֧��<br>
     * Order.ORDER_STATUS_WAIT   : ��������֧�����ȴ�֧�����<br>
     * Order.ORDER_STATUS_PAY    : ������֧��<br>
     * Order.ORDER_STATUS_SETTLED: �����ѽ���<br>
     * Order.ORDER_STATUS_REFUND : �������˿�<br>
     * Order.ORDER_STATUS_ISSUE  : ����������<br>
     */
	public function setOrderStatus($aOrderStatus)
	{
		$this->iOrderStatus=trim($aOrderStatus);
	}
	/**
     * ����״̬
     * @return ����״̬<br>
     * Order.ORDER_STATUS_CANCEL : ����ȡ��<br>
     * Order.ORDER_STATUS_NEW    : �����������ȴ�֧��<br>
     * Order.ORDER_STATUS_WAIT   : ��������֧�����ȴ�֧�����<br>
     * Order.ORDER_STATUS_PAY    : ������֧��<br>
     * Order.ORDER_STATUS_SETTLED: �����ѽ���<br>
     * Order.ORDER_STATUS_REFUND : �������˿�<br>
     * Order.ORDER_STATUS_ISSUE  : ����������<br>
     */
	public function getOrderStatus()
	{
		return $this->iOrderStatus;
	}
	/**
    * ����Order����
    */
	public function __construct()
	{
		$this->iOrderItems=array();
	}

    /**
     * ��Order����ʹ��XML�ļ���ʼ�����ԡ�
     * @param aXML ��ʼ�����XML�ļ���<br>XML�ļ�������<br>
     * &lt;Order&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderNo&gt;ON20031112001&lt;/OrderNo&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderDesc&gt;����E����վ�ϵĶ���&lt;/OrderDesc&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderDate&gt;2013/03/15&lt;/OrderDate&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderTime&gt;13:50:45&lt;/OrderTime&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderAmount&gt;28000&lt;/OrderAmount&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderItems&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductID&gt;IP000001&lt;/ProductID&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductName&gt;�й��ƶ�IP��&lt;/ProductName&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;UnitPrice&gt;10000&lt;/UnitPrice&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Qty&gt;1&lt;/Qty&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductID&gt;IP000002&lt;/ProductID&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;ProductName&gt;��ͨIP��&lt;/ProductName&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;UnitPrice&gt;9000&lt;/UnitPrice&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;Qty&gt;2&lt;/Qty&gt;<br>
     * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;/OrderItems&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderURL&gt;http://www.ecard.com/order?ON20031112001&lt;/OrderURL&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;PayAmount&gt;28000&lt;/PayAmount&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;RefundAmount&gt;0&lt;/RefundAmount&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;OrderStatus&gt;01&lt;/OrderStatus&gt;<br>
     * &lt;/Order&gt;<br>
	 * 11�ֶΣ�û��buyIp
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
		//ԭ��javaû�����buyip���ܶ��ˣ�����
		$this->iBuyIP=$xml->getValueNoNull('BuyIP');
		$this->iOrderItems=($this->iOrderItems+$xml->getValueArray('OrderItem'));
	}

    /**
     * ������Ϣ�Ƿ�Ϸ�
     * @return ������Ϣ�Ƿ�Ϸ�
     */
	public function isValid()
	{
		/*
          ˵����
          1��OrderNo��OrderDate��OrderTime��OrderAmountΪ��Ҫ�ֶ�
          2���ַ�����̬�ı�Ҫ�ֶβ���Ϊ��
          3��������̬�������
          4�����ڡ�ʱ��ĸ�ʽ����ȷ
          5�����ж�����ϸ���򶩵���ϸ����Ϸ�
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
     * ȡ�ö����XML�ļ�
     * @param aType �Ƿ���������������ԡ�<br>
     * 1: ֻ����֧������ʱ����Ķ������ԡ�<br> 
     * 2: ֻ���������š�������֧�����˻�������״̬���ԡ�<br>
     * 3: ���������Ķ������ԡ�
     * @return XML�ļ�
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