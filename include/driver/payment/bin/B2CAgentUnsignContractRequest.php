<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class B2CAgentUnsignContractRequest extends TrxRequest
{
	/** 通知商户类型：URL通知 */
	const NOTIFY_TYPE_URL    =  '0';
	
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
	
	/** 请求日期 */
	private $iRequestDate = '';
	
	/** 请求时间 */
	private $iRequestTime = '';
	
	/** 订单号 */
	private $iOrderNo = '';
	
	/** 通知方式*/
	private $iNotifyType = '';
	
	/** 签约协议号*/
	private $iAgentSignNo = '';
	
	/**
	 * 构造B2CAgentUnsignContractRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * 初始化B2CAgentUnsignContractRequest对象
	 */
	public function constructB2CAgentUnsignContractRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setAgentSignNo($xml->getValueNoNull('AgentSignNo'));
	
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
				'<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
				'<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<AgentSignNo>'.$this->iAgentSignNo.'</AgentSignNo>'.
				'<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
				'<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
				'<IsSign>'.'Unsign'.'</IsSign>'.
				'</TrxRequest>';
		   return $str;
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
		if(!DataVerifier::isValidString($this->iAgentSignNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'签约协议号不合法');
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
		// 3.检验结果接收URL合法性
		if(!DataVerifier::isValidURL($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'结果回传网址不合法');
		if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL)) > self::RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'验证结果回传网址不合法');
		//4.校验定单最大长度
		//5.校验定单日期合法性
		if(!DataVerifier::isValidDate($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单日期格式不正确');
		//6.校验定单日期合法性
		if(!DataVerifier::isValidTime($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单时间格式不正确');		 
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

	/**
	 * @return the $iAgentSignNo
	 */
	public function getAgentSignNo() {
		return $this->iAgentSignNo;
	}

	/**
	 * @param string $iAgentSignNo
	 */
	public function setAgentSignNo($iAgentSignNo) {
		$this->iAgentSignNo = $iAgentSignNo;
	}


	
}
?>