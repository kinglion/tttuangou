<?php
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
class_exists('Insure') or require(dirname(__FILE__).'/Insure.php');

class KPaymentRequest extends TrxRequest
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
	
	
	/** ���� */
    private $iAccName     = "";
    
    /** ֤������ */
    private $iCertificateType    = "";
    
    /** ֤������ */
    private $iCertificateID    = "";
    
    /** ����Ч�� */
    private $iExpDate    = "";
    
    /** ���п�CC2��*/
    private $iCVV2     = "";
    
    /** �ֻ�����֤�� */
    private $iVerifyCode    = "";
    
    /** ֧������ */
    private $iPaymentType     = '1';

    
    
	
	/**
	 * ����KPaymentRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * Class KPaymentRequest ���캯����ʹ��XML�ļ���ʼ��������ԡ�
	 * @param aXML ��ʼ�����XML�ļ���<br>XML�ļ�������<br>
	 */
	public function constructKPaymentRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrder($xml->getValueNoNull('Order'));
		$this->setAccName($xml->getValueNoNull('AccName'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateID($xml->getValueNoNull('CertificateID'));
		$this->setExpDate($xml->getValueNoNull('ExpDate'));
		$this->setCVV2($xml->getValueNoNull('CVV2'));
		$this->setVerifyCode($xml->getValueNoNull('VerifyCode'));
		$this->setPaymentType($xml->getValueNoNull('PaymentType'));
		$this->setMerchantRemarks($xml->getValueNoNull('MerchantRemarks'));
		$this->setPaymentLinkType($xml->getValueNoNull('PaymentLinkType'));
		
	}
	/**
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣprotected
	 */
	public  function getRequestMessage()
	{
		$ord=new Order();
		$ord->__constructXMlDocument($this->getOrder());
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_KPAY_REQ.'</TrxType>'.
			 $ord->getXMLDocument(1).
			 '<AccName>'.$this->iAccName.'</AccName>'.
			 '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
			 '<CertificateID>'.$this->iCertificateID.'</CertificateID>'.
			 '<ExpDate>'.$this->iExpDate.'</ExpDate>'.
			 '<CVV2>'.$this->iCVV2.'</CVV2>'.
			 '<VerifyCode>'.$this->iVerifyCode.'</VerifyCode>'.
			 '<PaymentType>'.$this->iPaymentType.'</PaymentType>'.
			 '<PaymentLinkType>'.$this->iPaymentLinkType.'</PaymentLinkType>'.
			 '<MerchantRemarks>'.$this->iMerchantRemarks.'</MerchantRemarks>'.
			 '</TrxRequest>';
		return $str;			 
	}
	
	/**
	 * ֧��������Ϣ�Ƿ�Ϸ�protected
	 * @throws TrxException: ֧�����󲻺Ϸ�
	 */
	 public   function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������Ϣ');
		if($this->iPaymentType!=self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT && $this->iPaymentType != self::PAY_TYPE_CREDIT && $this->iPaymentType != self::PAY_TYPE_ALL && $this->iPaymentType!=self::PAY_TYPE_CBP)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����Ͳ��Ϸ���');
		if(strlen(trim($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�̻���ע��Ϣ���Ϸ���');
		if($this->iPaymentLinkType != self::PAY_LINK_TYPE_NET && $this->iPaymentLinkType != self::PAY_LINK_TYPE_MOBILE && $this->iPaymentLinkType != self::PAY_LINK_TYPE_TV && $this->iPaymentLinkType != self::PAY_LINK_TYPE_IC)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧���������Ͳ��Ϸ���');
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

	/**
	 * @return the $iPaymentLinkType
	 */
	public function getPaymentLinkType() {
		return $this->iPaymentLinkType;
	}

	/**
	 * @param NULL $iPaymentLinkType
	 */
	public function setPaymentLinkType($aPaymentLinkType) {
		$this->iPaymentLinkType = $aPaymentLinkType;
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
	 * @return he $iAccName
	 */
	public function getAccName(){
		return $this->iAccName;
	}
	
	/**
	 * @param NULL $iAccName
	 */
	public function setAccName($aAccName){
		$this->iAccName = $aAccName;
	}
	
	/**
	 * @return the $iCertificateType
	 */
	public function getCertificateType(){
		return $this->iCertificateType;
	}
	
	/**
	 * @param NULL $iCertificateType
	 */
	public function setCertificateType($aCertificateType){
		$this->iCertificateType = $aCertificateType;
	}
	
	/**
	 * @return the $iCertificateID
	 */
	public function getCertificateID(){
		return $this->iCertificateID;
	}
	/**
	 * @param NULL $iCertificateID
	 */
	public function setCertificateID($aCertificateID){
		$this->iCertificateID = $aCertificateID;
	}
	/**
	 * @return the $iExpDate
	 */
	public function getExpDate(){
		return $this->iExpDate;
	}
	/**
	 * @param NULL $iExpDate����Ч�� 
	 */
	public function setExpDate($aExpDate){
		$this->iExpDate = $aExpDate;
	}
	/**
	 * @return the $iCVV2
	 */
	public function getCVV2(){
		return $this->iCVV2;
	}
	/**
	 * @param NULL $iCVV2���п�CC2��
	 */
	public function setCVV2($aCVV2){
		$this->iCVV2 = $aCVV2;
	}
	/**
	 * @return the $iVerifyCode
	 */
	public function getVerifyCode(){
		return $this->iVerifyCode;
	}
	/**
	 * @param NULL $iVerifyCode�ֻ�����֤��
	 */
	public function setVerifyCode($aVerifyCode){
		$this->iVerifyCode = $aVerifyCode;
	}
	/**
	 * @return the $iPaymentType
	 */
	public function getPaymentType(){
		return $this->iPaymentType;
	}
	/**
	 * @param NULL $iPaymentType֧������ 
	 */
	public function setPaymentType($aPaymentType){
		$this->iPaymentType = $aPaymentType;
	}
	
	
}
/*

//���Գ�Ա����
$pr=new KPaymentRequest();
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
	  <AccName>name</AccName>
	  <CertificateType>I</CertificateType>
	  <CertificateID>001</CertificateID>
	  <ExpDate>0715</ExpDate>
	  <CVV2>1234</CVV2>
	  <VerifyCode>123456</VerifyCode>
	  <PaymentType>1</PaymentType>
	  <MerchantRemarks>hi</MerchantRemarks>
	  <PaymentLinkType>1</PaymentLinkType>';
	  //$xml=new XMLDocument($axml);
//echo $xml->getValueNoNull('Order');
$pr->constructKPaymentRequest($axml);
//echo $pr->getOrder()."<br>";
//echo $pr->getInsure()."<br>";

$ord=new Order();
$ord->__constructXMlDocument($pr->getOrder());
//echo $ord->getXMLDocument(1);
echo $pr->getRequestMessage();
if(!$pr->checkRequest()) echo 'true';
$pr->setPaymentLinkType(1);
$trxRes=new TrxResponse();
$trxRes=$pr->extendPostRequest(1);
echo $trxRes->getReturnCode();

*/
?>