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
	    
    /** 手机号长度 */
    const MERCHANT_MOBILE_LEN  = 4;
    
    /** 支付接入方式 */
    public $iPaymentLinkType = "1"; 
	
	/** 订单对象 */
    private $iOrder            = null; 
	
    /** 商品种类 */
    private $iProductType     = self::PRD_TYPE_ONE;
    
    /** 二级商户号 */
    private $iSubMerchantID    = "";
    
    /** 二级商户名 */
    private $iSubMerchantName    = "";
    
    /** 二级商户MCC */
    private $iMCC    = "";
    
    /** 银行卡号 */
    private $iCardNo     = "";
    
    /** 手机号后4位 */
    private $iMobile    = "";
    
    /** 分期标识 */
    private $iInstallment    = "";
    
    /** 期数 */
    private $iPeriod    = "";
    
    /** 项目代码 */
    private $iProjectID     = "";
    
    /** 支付类型 */
    private $iPaymentType     = self::PAY_TYPE_ABC;
	
	/**
	 * 构造KPaymentResendRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * Class KPaymentRequest 构造函数。使用XML文件初始对象的属性。
	 * @param aXML 初始对象的XML文件。<br>XML文件范例：<br>
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
	 * 回传交易报文。
	 * @return 交易报文信息protected
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
	 * 支付请求信息是否合法protected
	 * @throws TrxException: 支付请求不合法
	 */
	 protected  function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单信息');
		if($this->iProductType===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定商品种类！');
		if($this->iCardNo === null )
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未输入银行卡号！');
		if($this->iMobile === null )
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未输入手机号后4位！');
		if (strlen($this->iMobile) != self::MERCHANT_MOBILE_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'手机号输入不合法！');
		if(!$order->isValid())
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单信息不合法！');
		if($this->iProductType!=self::PRD_TYPE_ONE && $this->iProductType!= self::PRD_TYPE_TWO)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'商品种类不合法！');
		if($this->iPaymentType!=self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT && $this->iPaymentType != self::PAY_TYPE_CREDIT && $this->iPaymentType != self::PAY_TYPE_ALL && $this->iPaymentType!=self::PAY_TYPE_CBP)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付类型不合法！');
		if(count(DataVerifier::stringToByteArray($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'商户备注信息不合法！');
		if($this->iPaymentLinkType != self::PAY_LINK_TYPE_NET && $this->iPaymentLinkType != self::PAY_LINK_TYPE_MOBILE && $this->iPaymentLinkType != self::PAY_LINK_TYPE_TV && $this->iPaymentLinkType != self::PAY_LINK_TYPE_IC)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付接入类型不合法！');
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