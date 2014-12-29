<?php
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
class_exists('Insure') or require(dirname(__FILE__).'/Insure.php');

class KPaymentVerifyRequest extends TrxRequest
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
	    
    /** �ֻ��ų��� */
    const MERCHANT_MOBILE_LEN  = 4;
    
    /** ֧�����뷽ʽ */
    public $iPaymentLinkType = "1"; 
	
	/** �������� */
    private $iOrder            = null; 
	
    /** ��Ʒ���� */
    private $iProductType     = self::PRD_TYPE_ONE;
    
    /** �����̻��� */
    private $iSubMerchantID    = "";
    
    /** �����̻��� */
    private $iSubMerchantName    = "";
    
    /** �����̻�MCC */
    private $iMCC    = "";
    
    /** ���п��� */
    private $iCardNo     = "";
    
    /** �ֻ��ź�4λ */
    private $iMobile    = "";
    
    /** ���ڱ�ʶ */
    private $iInstallment    = "";
    
    /** ���� */
    private $iPeriod    = "";
    
    /** ��Ŀ���� */
    private $iProjectID     = "";
    
    /** ֧������ */
    private $iPaymentType     = self::PAY_TYPE_ABC;
	
	/**
	 * ����KPaymentResendRequest����
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
		$this->setProductType($xml->getValueNoNull('ProductType'));
		$this->setSubMerchantID($xml->getValueNoNull('SubMerchantID'));
		$this->setSubMerchantName($xml->getValueNoNull('SubMerchantName'));
		$this->setMCC($xml->getValueNoNull('MCC'));
		$this->setCardNo($xml->getValueNoNull('CardNo'));
		$this->setMobile($xml->getValueNoNull('Mobile'));
		$this->setInstallment($xml->getValueNoNull('Installment'));
		$this->setPeriod($xml->getValueNoNull('Period'));
		$this->setProjectID($xml->getValueNoNull('ProjectID'));
		$this->setPaymentType($xml->getValueNoNull('PaymentType'));
		$this->setMerchantRemarks($xml->getValueNoNull('MerchantRemarks'));
		$this->setPaymentLinkType($xml->getValueNoNull('PaymentLinkType'));
		
	}
	
	/**
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣprotected
	 */
	protected function getRequestMessage()
	{
		$ord=new Order();
		$ord->__constructXMlDocument($this->getOrder());
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_KPAYVERIFY_REQ.'</TrxType>'.
			 $ord->getXMLDocument(1).
			 '<ProductType>'.$this->getProductType().'</ProductType>'.
			 '<SubMerchantID>'.$this->getSubMerchantID().'</SubMerchantID>'.
			 '<SubMerchantName>'.$this->getSubMerchantName().'</SubMerchantName>'.
			 '<MCC>'.$this->getMCC().'</MCC>'.
			 '<CardNo>'.$this->getCardNo().'</CardNo>'.
			 '<MobileNo>'.$this->getMobile().'</MobileNo>'.
			 '<Installment>'.$this->getInstallment().'</Installment>'.
			 '<Period>'.$this->getPeriod().'</Period>'.
			 '<ProjectID>'.$this->getProjectID().'</ProjectID>'.
			 '<PaymentType>'.$this->getPaymentType().'</PaymentType>'.
			 '<PaymentLinkType>'.$this->getPaymentLinkType().'</PaymentLinkType>'.
			 '<MerchantRemarks>'.$this->getMerchantRemarks().'</MerchantRemarks>'.
			 '</TrxRequest>';
		return $str;		 
	}
	/**
	 * ֧��������Ϣ�Ƿ�Ϸ�protected
	 * @throws TrxException: ֧�����󲻺Ϸ�
	 */
	 protected  function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������Ϣ');
		if($this->iProductType===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨��Ʒ���࣡');
		if($this->iCardNo === null )
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�������п��ţ�');
		if($this->iMobile === null )
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�����ֻ��ź�4λ��');
		if (strlen($this->iMobile) != self::MERCHANT_MOBILE_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�ֻ������벻�Ϸ���');
		if(!$order->isValid())
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������Ϣ���Ϸ���');
		if($this->iProductType!=self::PRD_TYPE_ONE && $this->iProductType!= self::PRD_TYPE_TWO)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��Ʒ���಻�Ϸ���');
		if($this->iPaymentType!=self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT && $this->iPaymentType != self::PAY_TYPE_CREDIT && $this->iPaymentType != self::PAY_TYPE_ALL && $this->iPaymentType!=self::PAY_TYPE_CBP)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����Ͳ��Ϸ���');
		if(count(DataVerifier::stringToByteArray($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
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
	 * @return the $iProductType
	 */
	public function getProductType() {
		return $this->iProductType;
	}

	/**
	 * @param NULL $iProductType
	 */
	public function setProductType($aProductType) {
		$this->iProductType = $aProductType;
	}
	
	/**
	 * @return the $iSubMerchantID
	 */
	public function getSubMerchantID() {
		return $this->iSubMerchantID;
	}

	/**
	 * @param NULL $iSubMerchantID
	 */
	public function setSubMerchantID($aSubMerchantID) {
		$this->iSubMerchantID = $aSubMerchantID;
	}
	
	/**
	 * @return the $iSubMerchantName
	 */
	public function getSubMerchantName() {
		return $this->iSubMerchantName;
	}

	/**
	 * @param NULL $iSubMerchantName
	 */
	public function setSubMerchantName($aSubMerchantName) {
		$this->iSubMerchantName = $aSubMerchantName;
	}
	/**
	 * @return the $iCardNo
	 */
	public function getCardNo() {
		return $this->iCardNo;
	}

	/**
	 * @param NULL $iCardNo
	 */
	public function setCardNo($aCardNo) {
		$this->iCardNo = $aCardNo;
	}
	/**
	 * @return the $iMCC
	 */
	public function getMCC() {
		return $this->iMCC;
	}

	/**
	 * @param NULL $iMCC
	 */
	public function setMCC($aMCC) {
		$this->iMCC = $aMCC;
	}
	
	/**
	 * @return the $iMobile
	 */
	public function getMobile() {
		return $this->iMobile;
	}

	/**
	 * @param NULL $iMobile
	 */
	public function setMobile($aMobile) {
		$this->iMobile = $aMobile;
	}
	
	/**
	 * @param NULL $iInstallment
	 */
	public function setInstallment($aInstallment) {
		$this->iInstallment = $aInstallment;
	}
	
	/**
	 * @return the $iInstallment
	 */
	public function getInstallment() {
		return $this->iInstallment;
	}
	
	/**
	 * @return the $iPeriod
	 */
	public function getPeriod() {
		return $this->iPeriod;
	}
	
	/**
	 * @param NULL $iPeriod
	 */
	public function setPeriod($aPeriod) {
		$this->iPeriod = $aPeriod;
	}
	
	/**
	 * @return the $iProjectID
	 */
	public function getProjectID() {
		return $this->iProjectID;
	}
	
	/**
	 * @param NULL $iProjectID
	 */
	public function setProjectID($aProjectID) {
		$this->iProjectID = $aProjectID;
	}	
	
	/**
	 * @return the $iPaymentType
	 */
	public function getPaymentType() {
		return $this->iPaymentType;
	}
	
	/**
	 * @param NULL $iPaymentType
	 */
	public function setPaymentType($aPaymentType) {
		$this->iPaymentType = $aPaymentType;
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
	
}
?>