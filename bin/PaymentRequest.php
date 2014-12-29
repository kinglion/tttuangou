<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
class_exists('Insure') or require(dirname(__FILE__).'/Insure.php');

class PaymentRequest extends TrxRequest
{

	/** 商品种类：非实体商品，如服务、IP卡、下载MP3、... */
	const PRD_TYPE_ONE='1';
	
	/** 商品种类：实体商品 */
	const PRD_TYPE_TWO='2';
	
	/** 支付类型：农行卡支付 */
	const PAY_TYPE_ABC='1';
	
	/** 支付类型：国际卡支付 */
	const PAY_TYPE_INT='2';
	
	/** 支付类型：农行贷记卡支付*/
	const PAY_TYPE_CREDIT='3';//王辰增加 2009 4 23
	
	/** 支付类型：农行支付合并类型*/
	const PAY_TYPE_ALL='A';// 20100203
	
	/** 支付类型：基于第三方的跨行支付方式*/
	const PAY_TYPE_CBP='5';//增加2012 4 12
	
	/** 通知商户类型：URL通知 */
	const NOTIFY_TYPE_URL='0';
	
	/** 通知商户类型：服务器通知 */
	const NOTIFY_TYPE_SERVER='1';
	
	/** 支付结果回传网址最大长度 */
	const RESULT_NOTIFY_URL_LEN=200;
	
	/** 商户备注信息最大长度 */
	const MERCHANT_REMARKS_LEN=500;

	/** 接入方式:INTENET网络 */
	const PAY_LINK_TYPE_NET='1';
	
	/** 接入方式:MOBILE网络 */
	const PAY_LINK_TYPE_MOBILE='2';
	
	/** 接入方式:数字电视网络 */
	const PAY_LINK_TYPE_TV='3';
	
	/** 接入方式:智能客户端 */
	const PAY_LINK_TYPE_IC='4';
	
	/** 支付接入方式 */
	public  $iPaymentLinkType = '1';
	/** 订单对象 */
	private $iOrder=null;
	
	/** 保单对象 */
	private $iInsure=null;// add for ec2010
	
	/** 商品种类 */
	private  $iProductType     =self:: PRD_TYPE_ONE;
	
	/** 通知商户类型 */
	private $iNotifyType      =self:: NOTIFY_TYPE_URL;
	
	/** 支付类型 */
	private $iPaymentType     =self:: PAY_TYPE_ABC;
	
	/** 支付结果回传网址 */
	private $iResultNotifyURL = '';
	
	/**
	 * @return the $iPaymentLinkType
	 */
	public function getPaymentLinkType() {
		return $this->iPaymentLinkType;
	}

	/**
	 * @param string $iPaymentLinkType
	 */
	public function setPaymentLinkType($iPaymentLinkType) {
		$this->iPaymentLinkType = $iPaymentLinkType;
	}

	/**
	 * @return the $iOrder
	 */
	public function getOrder() {
		return $this->iOrder;
	}

	/**
	 * @param NULL $iOrder
	 */
	public function setOrder($aOrder) {
		$this->iOrder = $aOrder;
	}

	/**
	 * @return the $iInsure
	 */
	public function getInsure() {
		return $this->iInsure;
	}

	/**
	 * @param NULL $iInsure
	 */
	public function setInsure($iInsure) {
		$this->iInsure = $iInsure;
	}

	/**
	 * @return the $iProductType
	 */
	public function getProductType() {
		return $this->iProductType;
	}

	/**
	 * @param string $iProductType
	 */
	public function setProductType($iProductType) {
		$this->iProductType = trim($iProductType);
	}

	/**
	 * @return the $iNotifyType
	 */
	public function getNotifyType() {
		return $this->iNotifyType;
	}

	/**
	 * @param string $iNotifyType
	 */
	public function setNotifyType($iNotifyType) {
		$this->iNotifyType = trim($iNotifyType);
	}

	/**
	 * @return the $iPaymentType
	 */
	public function getPaymentType() {
		return $this->iPaymentType;
	}

	/**
	 * @param string $iPaymentType
	 */
	public function setPaymentType($iPaymentType) {
		$this->iPaymentType = trim($iPaymentType);
	}

	/**
	 * @return the $iResultNotifyURL
	 */
	public function getResultNotifyURL() {
		return $this->iResultNotifyURL;
	}

	/**
	 * @param string $iResultNotifyURL
	 */
	public function setResultNotifyURL($iResultNotifyURL) {
		$this->iResultNotifyURL = trim($iResultNotifyURL);
	}

	/** 商户备注信息 在 trxrequest中已定义为protected*/
//	private $iMerchantRemarks = '';
	
	/**
	 * 构造PaymentRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * Class PaymentRequest 构造函数。使用XML文件初始对象的属性。
	 * @param aXML 初始对象的XML文件。<br>XML文件范例：<br>
	 */
	public function constructPaymentRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrder($xml->getValueNoNull('Order'));
		$this->setPaymentType($xml->getValueNoNull('PaymentType'));
		$this->setProductType($xml->getValueNoNull('ProductType'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setMerchantRemarks($xml->getValueNoNull('MerchantRemarks'));
		$this->setPaymentLinkType($xml->getValueNoNull('PaymentLinkType'));
		$this->setInsure($xml->getValueNoNull('Insure'));
	}
	/**
	 * 回传交易报文。
	 * @return 交易报文信息protected
	 */
	protected function getRequestMessage()
	{
		$ord=new Order();
		$ord->__constructXMlDocument($this->getOrder());
		$str1='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_PAY_REQ.'</TrxType>'.
			 $ord->getXMLDocument(1).
			 '<ProductType>'.$this->iProductType.'</ProductType>'.
			 '<PaymentType>'.$this->iPaymentType.'</PaymentType>'.
			 '<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
			 '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
			 '<MerchantRemarks>'.$this->iMerchantRemarks.'</MerchantRemarks>'.
			 '<PaymentLinkType>'.$this->iPaymentLinkType.'</PaymentLinkType>';
		$str2='';
			if($this->getInsure()!='')	 
			{
				$insure=new Insure();
				$insure->constructInsure($this->getInsure());
				$str2=$insure->getXMLDocument();
			}			
		$str3='</TrxRequest>';
		return $str1.$str2.$str3;			 
	}
	
	/**
	 * 支付请求信息是否合法protected
	 * @throws TrxException: 支付请求不合法
	 */
	 protected  function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		$insure=new Insure();
		$insure->constructInsure($this->iInsure);
		
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单信息');
		if($this->getProductType()===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定商品种类！');
		if($this->iResultNotifyURL===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定支付结果回传网址！');
		if(!$order->isValid())
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单信息不合法！');
		if($this->iProductType!=self::PRD_TYPE_ONE && $this->iProductType!= self::PRD_TYPE_TWO)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'商品种类不合法！');
		//王辰增加 2009 4 23
		if($this->iPaymentType!=self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT && $this->iPaymentType != self::PAY_TYPE_CREDIT && $this->iPaymentType != self::PAY_TYPE_ALL && $this->iPaymentType!=self::PAY_TYPE_CBP)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付类型不合法！');
		if($this->iNotifyType != self::NOTIFY_TYPE_URL && $this->iNotifyType != self::NOTIFY_TYPE_SERVER)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果通知类型不合法！');
		if(!DataVerifier::isValidURL($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
		if(!strlen(trim($this->iResultNotifyURL)))	
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
		//getBytes
		//DataVerifier::stringToByteArray($this->iResultNotifyURL)
		if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL))>self::RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
		//getBytes 
		
		if(count(DataVerifier::stringToByteArray($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'商户备注信息不合法！');
		if($this->iPaymentLinkType != self::PAY_LINK_TYPE_NET && $this->iPaymentLinkType != self::PAY_LINK_TYPE_MOBILE && $this->iPaymentLinkType != self::PAY_LINK_TYPE_TV && $this->iPaymentLinkType != self::PAY_LINK_TYPE_IC)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付接入类型不合法！');
		//add for ec2010
		
		if($this->iInsure!=null &&$this->iInsure != "")
		{
			if($insure->getType() != Insure::INSURE_TYPE_APPOINTED || $insure->getType() != Insure::INSURE_TYPE_COMMON || $insure->getType() != Insure::INSURE_TYPE_FINANCING)
			{
				$tError=$insure->isValid();
				if(strlen($tError)!=0)
				{
					throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'保险信息不合法！['.$tError.']');
				}
			}
		}
	
	}
	/**
	 * 回传交易响应对象。
	 * @throws TrxException：组成交易报文的过程中发现内容不合法
	 * @return 交易报文信息
	 */
	protected function constructResponse($aResponseMessage)
	{
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	}
}
/*测试成员方法
$pr=new PaymentRequest();
$axml='<Order>
	  <OrderNo>11111</OrderNo><ExpiredDate>2013/10/24</ExpiredDate><OrderDesc>jwordertest</OrderDesc>
	  <OrderDate>2013/01/24</OrderDate><OrderTime>18:23:23</OrderTime><OrderURL>http://www.jingdong.com</OrderURL>
	  <OrderStatus>01</OrderStatus><OrderAmount>87.00</OrderAmount><PayAmount>88.00</PayAmount>
	  <RefundAmount>90.00</RefundAmount>
	  <OrderItems>
	  <OrderItem><ProductID>111</ProductID><ProductName>jw1</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>
	  <OrderItem><ProductID>112</ProductID><ProductName>jw2</ProductName><UnitPrice>0.50</UnitPrice><Qty>5</Qty></OrderItem>
	  </OrderItems>
	  </Order>
	  <PaymentType>1</PaymentType>
	  <ProductType>1</ProductType>
	  <NotifyType>0</NotifyType>
	  <ResultNotifyURL>http://www.baidu.com</ResultNotifyURL>
	  <MerchantRemarks>hi</MerchantRemarks>
	  <PaymentLinkType>1</PaymentLinkType>
	  <Insure><Type>2</Type><Furl>www</Furl><Orders><InsureOrderItem>
	 <Amount>308.02</Amount><Name>cxl</Name><Code>nice</Code><Category>wow</Category><Mode>aha</Mode>
	 </InsureOrderItem>
	 <InsureOrderItem>
	 <Amount>333.02</Amount><Name>jw</Name><Code>great</Code><Category>mom</Category><Mode>xixi</Mode>
	 </InsureOrderItem></Orders><User><Name>jw</Name><CertificateType>I</CertificateType>
	 <CertificateNo>130628198810155026</CertificateNo><CardNo>622845671873621516</CardNo></User></Insure>';
//$xml=new XMLDocument($axml);
//echo $xml->getValueNoNull('Order');
$pr->constructPaymentRequest($axml);
//echo $pr->getOrder()."<br>";
//echo $pr->getInsure()."<br>";

$ord=new Order();
$ord->__constructXMlDocument($pr->getOrder());
//echo $ord->getXMLDocument(1);
echo $pr->getRequestMessage();
if(!$pr->checkRequest()) echo 'true';
*/
/*
$xml='<Order>
<OrderNo>ON200306300001</OrderNo>
<ExpiredDate>30</ExpiredDate>
<OrderDesc>Game Card Order</OrderDesc>
<OrderDate>2003/11/12</OrderDate>
<OrderTime>23:55:30</OrderTime>
<OrderAmount>280.1</OrderAmount>
<OrderURL>http://127.0.0.1/Merchant/MerchantQueryOrder.jsp?ON=ON200306300001&QueryType=1</OrderURL>
<OrderItems>
<OrderItem><ProductID>111</ProductID><ProductName>jw1</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>
<OrderItem><ProductID>112</ProductID><ProductName>jw2</ProductName><UnitPrice>0.50</UnitPrice><Qty>5</Qty></OrderItem>
</OrderItems>
</Order>';

$ord=new Order();
$ord->setOrderNo('ON200306300001');
$ord->setExpiredDate(30);
$ord->setOrderDesc('Game Card Order');
$ord->setOrderDate('2003/11/12');
$ord->setOrderTime('23:55:30');
$ord->setOrderAmount(280.1);
$ord->setOrderURL('http://127.0.0.1/Merchant/MerchantQueryOrder.jsp?ON=ON200306300001&QueryType=1');
$ord->setBuyIP('172.30.7.75');
echo $ord->getBuyIP()."<br>";
$ordItem1=new OrderItem();
$aProductID='IP000001';
$aProductName='中国移动ip卡';
$aUnitPrice=100.1;
$aQty=1;
$ordItem1->__constructOrderItem($aProductID, $aProductName, $aUnitPrice, $aQty);
$ordItem1xml=$ordItem1->getXMLDocument();
$ord->addOrderItem($ordItem1xml);
$ordItem2=new OrderItem();
$ordItem2->__constructOrderItem('IP000002', '网通ip卡', 90.1, 2);
$ordItem2xml=$ordItem2->getXMLDocument();
$ord->addOrderItem($ordItem2xml);
$ordxml=$ord->getXMLDocument(3);

$pr=new PaymentRequest();
$pr->setOrder($ordxml);
//echo $pr->getOrder();
$pr->setProductType(1);
$pr->setPaymentType(1);
$pr->setNotifyType(0);
$pr->setResultNotifyURL('http://localhost:8118/WebSite4/Default.aspx');
//$pr->setResultNotifyURL('http://127.0.0.1/Merchant/MerchantResult.jsp');
$pr->setMerchantRemarks('Hi!');
$pr->setPaymentLinkType(1);
$trxRes=new TrxResponse();
$trxRes=$pr->extendPostRequest(1);
echo $trxRes->getReturnCode();
if($trxRes->isSuccess())
{
	echo 'PaymentURL-->'.$trxRes->getValue('PaymentURL');
}
else
{
	echo 'fail';
}
*/
?>