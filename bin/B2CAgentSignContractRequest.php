<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');

class B2CAgentSignContractRequest extends TrxRequest
{
	/** 通知商户类型：URL通知 */
	const NOTIFY_TYPE_URL    =   '0';
	
	/** 通知商户类型：服务器通知 */
	const NOTIFY_TYPE_SERVER =   '1';
	
	/** 支付结果回传网址最大长度 */
	const RESULT_NOTIFY_URL_LEN = 200;
	
	/** 商户通知URL */
	private $iResultNotifyURL = '';
	
	/** 证件号码 */
	private $iCertificateNo = '';
	
	/** 证件类型 */
	private $iCertificateType = '';
	
	/** 卡类型 */
	private $iCardType = '';
	
	/** 请求日期 */
	private $iRequestDate = '';
	
	/** 请求时间 */
	private $iRequestTime = '';
	
	/** 订单号 */
	private $iOrderNo = '';
	
	/** 单笔最大限额 */
	//private $iALimitAmt = '';
	
	/** 一日最大限额 */
	//private $iADayLimitAmt = '';
	
	/** 过期时间 */
	private $iInvaidDate = '2099/01/01';
	
	/** 通知方式*/
	private $iNotifyType = '';
	
	/**
	 * 构造B2CAgentSignContractRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * 初始化B2CAgentSignContractRequest对象
	 */
	public function constructB2CAgentSignContractRequest($aXMLDocument) 
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCardType($xml->getValueNoNull('CardType'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		//irequestdate orderdate??? irequesttime ordertime
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setInvaidDate($xml->getValueNoNull('InvaidDate'));
		
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	protected function getRequestMessage() 
	{
		// TODO Auto-generated method stub
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_B2C_AgentSignContract_REQ.'</TrxType>'.
			 '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
			 '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
			 '<CardType>'.$this->iCardType.'</CardType>'.
			 '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
			 '<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
			 '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
			 '<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
			 '<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
			 '<InvaidDate>'.$this->iInvaidDate.'</InvaidDate>'.
			 '<IsSign>'.'Sign'.'</IsSign>'.
			 '</TrxRequest>';
		return $str;
		/*	
	     .append("<ALimitAmt>").append(iALimitAmt).append("</ALimitAmt>")
		 .append("<ADayLimitAmt>").append(iADayLimitAmt).append("</ADayLimitAmt>")
		 */
	}
	protected function checkRequest()
    {
    	//1.验证是否为空
    	if(!DataVerifier::isValidString($this->iResultNotifyURL))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'验证结果回传网址不合法');
    	if(!DataVerifier::isValidString($this->iOrderNo))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单号不合法');
    	if(!DataVerifier::isValidString($this->iRequestDate))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单日期不合法');
    	if(!DataVerifier::isValidString($this->iRequestTime))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单时间不合法');
    	if(!DataVerifier::isValidString($this->iInvaidDate))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'过期时间不合法');
    	if(!DataVerifier::isValidString($this->iCertificateType))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'客户证件类型不合法');
    	if(!DataVerifier::isValidString($this->iCertificateNo))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'客户证件号码不合法');
    	if(!DataVerifier::isValidString($this->iNotifyType))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'通知类型不合法');
    	if($this->iNotifyType != self::NOTIFY_TYPE_URL && $this->iNotifyType != self::NOTIFY_TYPE_SERVER)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'通知类型未定义！');
    	//2.检验证件类型、证件号码合法性
    	if(!DataVerifier::isValidCertificate($this->iCertificateType, $this->iCertificateNo))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'证件类型、证件号码不合法');
    	if($this->iCertificateType != 'I')
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'证件类型必须为公民身份证');
    	if($this->iCardType != '1' && $this->iCardType != '2' && $this->iCardType != 'A')
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'农行卡类型不合法');
    	// 3.检验结果接收URL合法性
    	if(!DataVerifier::isValidURL($this->iResultNotifyURL))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'结果回传网址不合法');
    	if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL)) > self::RESULT_NOTIFY_URL_LEN)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'验证结果回传网址不合法');
    	//4.校验定单最大长度 ???????????
    	//5.校验定单日期合法性
    	if(!DataVerifier::isValidDate($this->iRequestDate))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单日期格式不正确');
    	//6.校验定单日期合法性
    	if(!DataVerifier::isValidTime($this->iRequestTime))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单时间格式不正确');
    	
    	/*
		//1.验证是否为空	
		//4.校验定单最大长度 ?????????????
		//		if (!DataVerifier.isValidString(iOrderNo,ILength.ORDERID_LEN))
			//			throw new TrxException(TrxException.TRX_EXC_CODE_1101,TrxException.TRX_EXC_MSG_1101,"订单号长度超过限制或为空");
		/*		
		*/
	}
	protected function constructResponse($aResponseMessage)
    {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
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
		$this->iResultNotifyURL = $iResultNotifyURL;
	}

	/**
	 * @return the $iCertificateNo
	 */
	public function getCertificateNo() {
		return $this->iCertificateNo;
	}

	/**
	 * @param string $iCertificateNo
	 */
	public function setCertificateNo($iCertificateNo) {
		$this->iCertificateNo = $iCertificateNo;
	}

	/**
	 * @return the $iCertificateType
	 */
	public function getCertificateType() {
		return $this->iCertificateType;
	}

	/**
	 * @param string $iCertificateType
	 */
	public function setCertificateType($iCertificateType) {
		$this->iCertificateType = $iCertificateType;
	}

	/**
	 * @return the $iCardType
	 */
	public function getCardType() {
		return $this->iCardType;
	}

	/**
	 * @param string $iCardType
	 */
	public function setCardType($iCardType) {
		$this->iCardType = $iCardType;
	}

	/**
	 * @return the $iRequestDate
	 */
	public function getRequestDate() {
		return $this->iRequestDate;
	}

	/**
	 * @param string $iRequestDate
	 */
	public function setRequestDate($iRequestDate) {
		$this->iRequestDate = $iRequestDate;
	}

	/**
	 * @return the $iRequestTime
	 */
	public function getRequestTime() {
		return $this->iRequestTime;
	}

	/**
	 * @param string $iRequestTime
	 */
	public function setRequestTime($iRequestTime) {
		$this->iRequestTime = $iRequestTime;
	}

	/**
	 * @return the $iOrderNo
	 */
	public function getOrderNo() {
		return $this->iOrderNo;
	}

	/**
	 * @param string $iOrderNo
	 */
	public function setOrderNo($iOrderNo) {
		$this->iOrderNo = $iOrderNo;
	}

	/**
	 * @return the $iInvaidDate
	 */
	public function getInvaidDate() {
		return $this->iInvaidDate;
	}

	/**
	 * @param string $iInvaidDate
	 */
	public function setInvaidDate($iInvaidDate) {
		$this->iInvaidDate = $iInvaidDate;
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
		$this->iNotifyType = $iNotifyType;
	}	
}
/*
$asc=new B2CAgentSignContractRequest();
*/
?>