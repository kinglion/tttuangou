<?php
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');

class IdentityVerifyRequest extends TrxRequest
{
	
	/** 支付结果回传网址最大长度 */
	const RESULT_NOTIFY_URL_LEN = 200;
	/** 身份验证结果回传网址 */
	private $iResultNotifyURL = '';
	
	/** 银行卡号 */
	private $iBankCardNo = '';
	
	/** 证件类型 */
	private $iCertificateType = '';
	
	/** 证件号码 */
	private $iCertificateNo = '';
	
	/** 请求日期 */
	private $iRequestDate ='';
	
	/** 请求时间 */
	private $iRequestTime = '';
	
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
	 * @return the $iBankCardNo
	 */
	public function getBankCardNo() {
		return $this->iBankCardNo;
	}

	/**
	 * @param string $iBankCardNo
	 */
	public function setBankCardNo($iBankCardNo) {
		$this->iBankCardNo = $iBankCardNo;
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
	 * 构造IdentityVerifyRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * 使用XML文件初始IdentityVerifyRequest对象的属性。
	 * @param aXML 初始对象的XML文件。
	 */
	public function constructIdentityVerifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setBankCardNo($xml->getValueNoNull('BankCardNo'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		//???怎么是orderdate和ordertime不应该是RequestDate和RequestTime
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));	
	}
	/**
	 * 回传交易报文。
	 * @return 交易报文信息???orderdate ordertime
	 */
	protected function getRequestMessage()
	{
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_IDENTITY_VERIFY_REQ.'</TrxType>'.
			 '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
			 '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
			 '<BankCardNo>'.$this->iBankCardNo.'</BankCardNo>'.
			 '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
			 '<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
			 '<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
			 '</TrxRequest>';
		echo '回传信息：'.$str;
		return $str;	 	 
	}
	/**
	 * 支付请求信息是否合法
	 * @throws TrxException: 支付请求不合法
	 */
	protected function checkRequest()
	{
		//验证是否为空
		if(!DataVerifier::isValidString($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'验证结果回传网址不合法');
		if(!DataVerifier::isValidString($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单日期不合法');
		if(!DataVerifier::isValidString($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单时间不合法');
		// 1.检验卡号合法性
		if(!DataVerifier::isValidBankCardNo($this->iBankCardNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'银行卡号不合法');
		// 2.检验证件类型、证件号码合法性
		if(!DataVerifier::isValidCertificate($this->iCertificateType, $this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'证件类型、证件号码不合法');
		// 3.检验结果接收URL合法性
		if(!DataVerifier::isValidURL($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'结果回传网址不合法');
		if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL)) > self::RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'验证结果回传网址不合法！');
		//4.校验定单最大长度
		//		if (!DataVerifier.isValidString(iOrderNo,ILength.ORDERID_LEN))
		//			throw new TrxException(TrxException.TRX_EXC_CODE_1101,TrxException.TRX_EXC_MSG_1101,"订单号长度超过限制或为空");
		//5.校验定单日期合法性
		if(!DataVerifier::isValidDate($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单日期格式不正确');
		//6.校验定单日期合法性
		if(!DataVerifier::isValidTime($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单时间格式不正确');
		
	}
	/**
	 * 回传交易响应对象。
	 * @return 交易报文信息
	 */
	protected function constructResponse($aResponseMessage)
	{
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	}
		
}

?>
