<?php 
/**
 * 商户端接口软件包业务处理类，负责商户提交支付请求的处理。
 */
class FundPaymentRequest extends TrxRequest
{
	/** 商品种类：非实体商品，如服务、IP卡、下载MP3、... */
	const PRD_TYPE_ONE       =   "1";
	
	/** 商品种类：实体商品 */
	const PRD_TYPE_TWO       =   "2";
	
	/** 支付类型：农行卡支付 */
	const PAY_TYPE_ABC       =   "1";
	
	/** 支付类型：国际卡支付 */
	const PAY_TYPE_INT       =   "2";
	
	/** 通知商户类型：URL通知 */
	const NOTIFY_TYPE_URL    =   "0";
	
	/** 通知商户类型：服务器通知 */
	const NOTIFY_TYPE_SERVER =   "1";
	
	/** 支付结果回传网址最大长度 */
	const RESULT_NOTIFY_URL_LEN = 200;
	
	/** 商户备注信息最大长度 */
	const MERCHANT_REMARKS_LEN  = 200;
	
	/** 交易类型 1 开户支付 2 基金购买 */
	const TRX_OPEN_ACCOUNT = "1";
	
	const TRX_BUY_FUND = "2";
	
	/** 订单对象 */
	private $iOrder           = null;
	
	/** 商品种类 */
	private  $iProductType    = self::PRD_TYPE_ONE;
	
	/** 通知商户类型 */
	private $iNotifyType      = self::NOTIFY_TYPE_URL;
	
	/** 支付类型 */
	private $iPaymentType     = self::PAY_TYPE_ABC;
	
	/** 支付结果回传网址 */
	private $iResultNotifyURL = '';
	
	/** 商户备注信息 TrxRequest已定义为protected
	private $iMerchantRemarks = '';
	*/
	
	/** 交易类型 1 开户，2 基金申购*/
	private $iTrxSubType = '';
	
	/** 证件号码*/
	private $iCertificateNo = '';
	
	/** 证件类型*/
	private $iCertificateType = '';
	
	/** 银行账号*/
	private $iBankCardNo = '';
	
	/**
	 * 构造FundPaymentRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	public function constructFundPaymentRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrder($xml->getValueNoNull('Order'));
		$this->setPaymentType($xml->getValueNoNull('PaymentType'));
		$this->setProductType($xml->getValueNoNull('ProductType'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setMerchantRemarks($xml->getValueNoNull('MerchantRemarks'));
		$this->setBankCardNo($xml->getValueNoNull('BankCardNo'));
		$this->setTrxSubType($xml->getValueNoNull('TrxSubType'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 回传交易报文。
     * @return 交易报文信息
	 */
	protected function checkRequest() 
	{
		$ord=new Order();
		$ord->__constructXMlDocument($this->getOrder());
		$tMessage='<TrxRequest>'.
				  '<TrxType>'.TrxType::TRX_TYPE_FUND_PAY_REQ.'</TrxType>'.
				  $ord->getXMLDocument(1).
				  '<ProductType>'.$this->iProductType.'</ProductType>'.
				  '<PaymentType>'.$this->iPaymentType.'</PaymentType>'.
				  '<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
				  '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
				  '<MerchantRemarks>'.$this->iMerchantRemarks.'</MerchantRemarks>'.
				  '<TrxSubType>'.$this->iTrxSubType.'</TrxSubType>'.
				  '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
				  '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
				  '<BankCardNo>'.$this->iBankCardNo.'</BankCardNo>'.
				  '</TrxRequest>';
		return $tMessage;
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 支付请求信息是否合法
     * @throws TrxException: 支付请求不合法
	 */
	 protected function getRequestMessage() 
	 {
	 	$order=new Order();
	 	$order->__constructXMlDocument($this->iOrder);
	 	if($this->iOrder==null)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单信息');
	 	if($this->iProductType==null)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定商品种类！');
	 	if($this->iResultNotifyURL==null)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定支付结果回传网址！');
	 	if(!$order->isValid())
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单信息不合法！');
	 	if($this->iProductType!=self::PRD_TYPE_ONE && $this->iProductType!= self::PRD_TYPE_TWO)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'商品种类不合法！');
	 	if($this->iPaymentType != self::PAY_TYPE_ABC && $this->iPaymentType != self::PAY_TYPE_INT)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付类型不合法！');
	 	if($this->iNotifyType != self::NOTIFY_TYPE_SERVER && $this->iNotifyType != self::NOTIFY_TYPE_URL)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果通知类型不合法！');
	 	if(!DataVerifier::isValidURL($this->iResultNotifyURL))
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
	 	if(!strlen(trim($this->iResultNotifyURL)))
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
	 	//getBytes
	 	if(strlen(trim($this->iResultNotifyURL))>self::RESULT_NOTIFY_URL_LEN)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
		if(count(DataVerifier::stringToByteArray($this->iMerchantRemarks))>self::MERCHANT_REMARKS_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'商户备注信息不合法！');
	 	if($this->iTrxSubType!=self::TRX_BUY_FUND && $this->iTrxSubType!=self::TRX_OPEN_ACCOUNT)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'交易子类型信息不合法！');
	 	if(strlen(trim($this->iBankCardNo))==0)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101);
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		return new TrxResponse($aResponseMessage);
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
	public function setOrder($iOrder) {
		$this->iOrder = $iOrder;
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
		$this->iProductType = $iProductType;
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
	 * @return the $iPaymentType
	 */
	public function getPaymentType() {
		return $this->iPaymentType;
	}

	/**
	 * @param string $iPaymentType
	 */
	public function setPaymentType($iPaymentType) {
		$this->iPaymentType = $iPaymentType;
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
	 * @return the $iTrxSubType
	 */
	public function getTrxSubType() {
		return $this->iTrxSubType;
	}

	/**
	 * @param string $iTrxSubType
	 */
	public function setTrxSubType($iTrxSubType) {
		$this->iTrxSubType = $iTrxSubType;
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


	
}
?>