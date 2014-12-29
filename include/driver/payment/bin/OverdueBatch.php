<?php 
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
//和batch类一模一样
class OverdueBatch
{/**
	 * 退款批量流水号
	 */
	private $iSerialNumber = '';
	
	/**
	 * 退款总金额
	 */
	private $iRefundAmount = 0;
	
	/**
	 * 退款总笔数
	 */
	private $iRefundCount = 0;
	
	/**
	 * 退款批量状态
	 */
	private $iStatus = '';
	
	/** 退款批量订单明细。为Order对象的数组。*/
	private $iOrders = array();
	
	/**
	 * 构造OverdueBatch对象
	 */
	public function __construct()
	{
		
	}
	/**
	 * 初始OverdueBatch对象
	 */
	public function constructBatch ($aXMLDocument) 
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setSerialNumber($xml->getValueNoNull('SerialNumber'));
		$this->setStatus($xml->getValueNoNull('BatchStatus'));
		$this->setRefundAmount($xml->getValueNoNull('RefundAmount'));
		$this->setRefundCount($xml->getValueNoNull('RefundCount'));
		$this->iOrders=$xml->getValueArray('Order');
	}

	/**
	 * @return the $iSerialNumber
	 */
	public function getSerialNumber() {
		return $this->iSerialNumber;
	}

	/**
	 * @param string $iSerialNumber
	 */
	public function setSerialNumber($iSerialNumber) {
		$this->iSerialNumber = $iSerialNumber;
	}

	/**
	 * @return the $iRefundAmount
	 */
	public function getRefundAmount() {
		return $this->iRefundAmount;
	}

	/**
	 * @param number $iRefundAmount
	 */
	public function setRefundAmount($iRefundAmount) {
		$this->iRefundAmount = $iRefundAmount;
	}

	/**
	 * @return the $iRefundCount
	 */
	public function getRefundCount() {
		return $this->iRefundCount;
	}

	/**
	 * @param number $iRefundCount
	 */
	public function setRefundCount($iRefundCount) {
		$this->iRefundCount = $iRefundCount;
	}

	/**
	 * @return the $iStatus
	 */
	public function getStatus() {
		return $this->iStatus;
	}

	/**
	 * @param string $iStatus
	 */
	public function setStatus($iStatus) {
		$this->iStatus = $iStatus;
	}

	/**
	 * @return the $iOrders
	 */
	public function getOrders() {
		return $this->iOrders;
	}

	/**
	 * @param multitype: $iOrders
	 */
	public function addOrders($aOrders) {
		if(!$this->iOrders )
		{
			$this->iOrders =array();
			$this->iOrders[0]=$aOrders;
		}
		else {
			array_push($this->iOrders, $aOrders);
		}
	}
}
/*
$ob=new OverdueBatch();
$xml='<SerialNumber>001</SerialNumber>
<BatchStatus>refund</BatchStatus>
<RefundAmount>400.55</RefundAmount>
<RefundCount>2</RefundCount>
<Order>OrderNo>11111</OrderNo><ExpiredDate>2013/10/24</ExpiredDate><OrderDesc>jwordertest</OrderDesc>
					<OrderDate>2013/01/24</OrderDate><OrderTime>18:23:23</OrderTime><OrderURL>http://www.jingdong.com</OrderURL>
					<OrderStatus>01</OrderStatus><OrderAmount>87.00</OrderAmount><PayAmount>88.00</PayAmount>
					<RefundAmount>90.00</RefundAmount>
					<OrderItems>
					<OrderItem><ProductID>111</ProductID><ProductName>jw1</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>
					<OrderItem><ProductID>112</ProductID><ProductName>jw2</ProductName><UnitPrice>0.50</UnitPrice><Qty>5</Qty></OrderItem>
					</OrderItems>
					</Order>
<Order>OrderNo>11112</OrderNo><ExpiredDate>2013/10/24</ExpiredDate><OrderDesc>jwordertest2</OrderDesc>
					<OrderDate>2013/01/24</OrderDate><OrderTime>18:23:24</OrderTime><OrderURL>http://www.jingdong.com</OrderURL>
					<OrderStatus>01</OrderStatus><OrderAmount>87.00</OrderAmount><PayAmount>88.00</PayAmount>
					<RefundAmount>90.00</RefundAmount>
					<OrderItems>
					<OrderItem><ProductID>1115</ProductID><ProductName>jw15</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>
					<OrderItem><ProductID>1125</ProductID><ProductName>jw25</ProductName><UnitPrice>0.50</UnitPrice><Qty>5</Qty></OrderItem>
					</OrderItems>
					</Order>';
//$ob->constructBatch($xml);

$ob->setRefundAmount(50.21);
$ob->setRefundCount(5);
$ob->setSerialNumber('55555');
$ob->setStatus('Trxref');
$aOrders='<Order>OrderNo>11111</OrderNo><ExpiredDate>2013/10/24</ExpiredDate><OrderDesc>jwordertest</OrderDesc>
					<OrderDate>2013/01/24</OrderDate><OrderTime>18:23:23</OrderTime><OrderURL>http://www.jingdong.com</OrderURL>
					<OrderStatus>01</OrderStatus><OrderAmount>87.00</OrderAmount><PayAmount>88.00</PayAmount>
					<RefundAmount>90.00</RefundAmount>
					<OrderItems>
					<OrderItem><ProductID>111</ProductID><ProductName>jw1</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>
					<OrderItem><ProductID>112</ProductID><ProductName>jw2</ProductName><UnitPrice>0.50</UnitPrice><Qty>5</Qty></OrderItem>
					</OrderItems>
					</Order>';
$ob->addOrders($aOrders);

echo $ob->getSerialNumber()."<br/>";
echo $ob->getRefundAmount()."<br/>";
echo $ob->getRefundCount()."<br/>";
echo $ob->getStatus()."<br/>";
var_dump($ob->getOrders());
*/
?>