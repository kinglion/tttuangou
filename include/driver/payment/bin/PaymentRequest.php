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

	/** ��Ʒ���ࣺ��ʵ����Ʒ�������IP��������MP3��... */
	const PRD_TYPE_ONE='1';
	
	/** ��Ʒ���ࣺʵ����Ʒ */
	const PRD_TYPE_TWO='2';
	
	/** ֧�����ͣ�ũ�п�֧�� */
	const PAY_TYPE_ABC='1';
	
	/** ֧�����ͣ����ʿ�֧�� */
	const PAY_TYPE_INT='2';
	
	/** ֧�����ͣ�ũ�д��ǿ�֧��*/
	const PAY_TYPE_CREDIT='3';//�������� 2009 4 23
	
	/** ֧�����ͣ�ũ��֧���ϲ�����*/
	const PAY_TYPE_ALL='A';// 20100203
	
	/** ֧�����ͣ����ڵ������Ŀ���֧����ʽ*/
	const PAY_TYPE_CBP='5';//����2012 4 12
	
	/** ֪ͨ�̻����ͣ�URL֪ͨ */
	const NOTIFY_TYPE_URL='0';
	
	/** ֪ͨ�̻����ͣ�������֪ͨ */
	const NOTIFY_TYPE_SERVER='1';
	
	/** ֧������ش���ַ��󳤶� */
	const RESULT_NOTIFY_URL_LEN=200;
	
	/** �̻���ע��Ϣ��󳤶� */
	const MERCHANT_REMARKS_LEN=500;

	/** ���뷽ʽ:INTENET���� */
	const PAY_LINK_TYPE_NET='1';
	
	/** ���뷽ʽ:MOBILE���� */
	const PAY_LINK_TYPE_MOBILE='2';
	
	/** ���뷽ʽ:���ֵ������� */
	const PAY_LINK_TYPE_TV='3';
	
	/** ���뷽ʽ:���ܿͻ��� */
	const PAY_LINK_TYPE_IC='4';
	
	/** ֧�����뷽ʽ */
	public  $iPaymentLinkType = '1';
	/** �������� */
	private $iOrder=null;
	
	/** �������� */
	private $iInsure=null;// add for ec2010
	
	/** ��Ʒ���� */
	private  $iProductType     =self:: PRD_TYPE_ONE;
	
	/** ֪ͨ�̻����� */
	private $iNotifyType      =self:: NOTIFY_TYPE_URL;
	
	/** ֧������ */
	private $iPaymentType     =self:: PAY_TYPE_ABC;
	
	/** ֧������ش���ַ */
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

	/** �̻���ע��Ϣ �� trxrequest���Ѷ���Ϊprotected*/
//	private $iMerchantRemarks = '';
	
	/**
	 * ����PaymentRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * Class PaymentRequest ���캯����ʹ��XML�ļ���ʼ��������ԡ�
	 * @param aXML ��ʼ�����XML�ļ���<br>XML�ļ�������<br>
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
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣprotected
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
	 * ֧��������Ϣ�Ƿ�Ϸ�protected
	 * @throws TrxException: ֧�����󲻺Ϸ�
	 */
	 protected  function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		$insure=new Insure();
		$insure->constructInsure($this->iInsure);
		
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������Ϣ');
		if($this->getProductType()===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨��Ʒ���࣡');
		if($this->iResultNotifyURL===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨֧������ش���ַ��');
		if(!$order->isValid())
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������Ϣ���Ϸ���');
		if($this->iProductType!=self::PRD_TYPE_ONE && $this->iProductType!= self::PRD_TYPE_TWO)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��Ʒ���಻�Ϸ���');
		//�������� 2009 4 23
		if($this->iPaymentType!=self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT && $this->iPaymentType != self::PAY_TYPE_CREDIT && $this->iPaymentType != self::PAY_TYPE_ALL && $this->iPaymentType!=self::PAY_TYPE_CBP)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����Ͳ��Ϸ���');
		if($this->iNotifyType != self::NOTIFY_TYPE_URL && $this->iNotifyType != self::NOTIFY_TYPE_SERVER)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����֪ͨ���Ͳ��Ϸ���');
		if(!DataVerifier::isValidURL($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
		if(!strlen(trim($this->iResultNotifyURL)))	
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
		//getBytes
		//DataVerifier::stringToByteArray($this->iResultNotifyURL)
		if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL))>self::RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧������ش���ַ���Ϸ���');
		//getBytes 
		
		if(count(DataVerifier::stringToByteArray($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�̻���ע��Ϣ���Ϸ���');
		if($this->iPaymentLinkType != self::PAY_LINK_TYPE_NET && $this->iPaymentLinkType != self::PAY_LINK_TYPE_MOBILE && $this->iPaymentLinkType != self::PAY_LINK_TYPE_TV && $this->iPaymentLinkType != self::PAY_LINK_TYPE_IC)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧���������Ͳ��Ϸ���');
		//add for ec2010
		
		if($this->iInsure!=null &&$this->iInsure != "")
		{
			if($insure->getType() != Insure::INSURE_TYPE_APPOINTED || $insure->getType() != Insure::INSURE_TYPE_COMMON || $insure->getType() != Insure::INSURE_TYPE_FINANCING)
			{
				$tError=$insure->isValid();
				if(strlen($tError)!=0)
				{
					throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������Ϣ���Ϸ���['.$tError.']');
				}
			}
		}
	
	}
	/**
	 * �ش�������Ӧ����
	 * @throws TrxException����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
	 * @return ���ױ�����Ϣ
	 */
	protected function constructResponse($aResponseMessage)
	{
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	}
}
/*���Գ�Ա����
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
$aProductName='�й��ƶ�ip��';
$aUnitPrice=100.1;
$aQty=1;
$ordItem1->__constructOrderItem($aProductID, $aProductName, $aUnitPrice, $aQty);
$ordItem1xml=$ordItem1->getXMLDocument();
$ord->addOrderItem($ordItem1xml);
$ordItem2=new OrderItem();
$ordItem2->__constructOrderItem('IP000002', '��ͨip��', 90.1, 2);
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